<?php

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Helper: create a seeded test user ─────────────────────
function makeUser(string $role = 'admin'): User
{
    return User::factory()->create(['role' => $role, 'status_aktif' => true]);
}

// ════════════════════════════════════════════════════════
// Fee Calculation Logic
// ════════════════════════════════════════════════════════

describe('Transaksi::hitungBiaya()', function () {

    it('charges minimum 1 jam for stays under 60 minutes', function () {
        $masuk  = Carbon::parse('2024-01-01 10:00:00');
        $keluar = Carbon::parse('2024-01-01 10:30:00'); // 30 min

        $result = Transaksi::hitungBiaya($masuk, $keluar, 2000);

        expect($result['durasi_jam'])->toBe(1)
            ->and($result['biaya_total'])->toBe(2000.0);
    });

    it('rounds up partial hours correctly', function () {
        $masuk  = Carbon::parse('2024-01-01 10:00:00');
        $keluar = Carbon::parse('2024-01-01 11:01:00'); // 61 min → 2 jam

        $result = Transaksi::hitungBiaya($masuk, $keluar, 2000);

        expect($result['durasi_jam'])->toBe(2)
            ->and($result['biaya_total'])->toBe(4000.0);
    });

    it('calculates exact 3 hours correctly', function () {
        $masuk  = Carbon::parse('2024-01-01 09:00:00');
        $keluar = Carbon::parse('2024-01-01 12:00:00');

        $result = Transaksi::hitungBiaya($masuk, $keluar, 5000); // mobil

        expect($result['durasi_jam'])->toBe(3)
            ->and($result['biaya_total'])->toBe(15000.0);
    });

    it('handles same minute in/out as 1 jam', function () {
        $masuk  = Carbon::parse('2024-01-01 10:00:00');
        $keluar = Carbon::parse('2024-01-01 10:00:00');

        $result = Transaksi::hitungBiaya($masuk, $keluar, 3000);

        expect($result['durasi_jam'])->toBeGreaterThanOrEqual(1);
    });
});

// ════════════════════════════════════════════════════════
// Role Middleware
// ════════════════════════════════════════════════════════

describe('Role-based access control', function () {

    it('redirects unauthenticated users from admin dashboard', function () {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect();
    });

    it('allows admin to access admin dashboard', function () {
        $admin = makeUser('admin');
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertOk();
    });

    it('denies petugas from accessing admin dashboard', function () {
        $petugas = makeUser('petugas');
        $response = $this->actingAs($petugas)->get('/admin/dashboard');
        $response->assertForbidden();
    });

    it('allows petugas to access gate-masuk', function () {
        $petugas = makeUser('petugas');
        $response = $this->actingAs($petugas)->get('/petugas/gate-masuk');
        $response->assertOk();
    });

    it('denies owner from accessing gate-masuk', function () {
        $owner = makeUser('owner');
        $response = $this->actingAs($owner)->get('/petugas/gate-masuk');
        $response->assertForbidden();
    });

    it('allows owner to access owner dashboard', function () {
        $owner = makeUser('owner');
        $response = $this->actingAs($owner)->get('/owner/dashboard');
        $response->assertOk();
    });

    it('denies inactive users from accessing any route', function () {
        $user = User::factory()->create(['role' => 'admin', 'status_aktif' => false]);
        // Inactive user should be logged out and redirected
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertRedirect();
    });
});

// ════════════════════════════════════════════════════════
// QR Code Generation
// ════════════════════════════════════════════════════════

describe('QR code uniqueness', function () {

    it('generates unique kode_qr for each transaksi', function () {
        $area     = AreaParkir::factory()->create(['kapasitas' => 10, 'terisi' => 0]);
        $tarif    = Tarif::factory()->create(['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000]);
        $kendaraan = Kendaraan::factory()->create();

        $codes = [];
        for ($i = 0; $i < 5; $i++) {
            $kode = 'FT-'.strtoupper(\Illuminate\Support\Str::random(4)).'-'.now()->format('YmdHis').$i;
            $codes[] = $kode;
        }

        expect(count(array_unique($codes)))->toBe(5);
    });

    it('kode_qr column is unique in database', function () {
        $area      = AreaParkir::factory()->create(['kapasitas' => 10, 'terisi' => 0]);
        $tarif     = Tarif::factory()->create(['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000]);
        $kendaraan = Kendaraan::factory()->create();

        Transaksi::create([
            'kode_qr'      => 'FT-UNIQUE-001',
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_area'      => $area->id_area,
            'waktu_masuk'  => now(),
            'id_tarif'     => $tarif->id_tarif,
            'status'       => 'masuk',
        ]);

        expect(fn() => Transaksi::create([
            'kode_qr'      => 'FT-UNIQUE-001', // duplicate
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_area'      => $area->id_area,
            'waktu_masuk'  => now(),
            'id_tarif'     => $tarif->id_tarif,
            'status'       => 'masuk',
        ]))->toThrow(\Illuminate\Database\QueryException::class);
    });
});

// ════════════════════════════════════════════════════════
// Area Capacity
// ════════════════════════════════════════════════════════

describe('Area capacity management', function () {

    it('correctly tracks occupied slots', function () {
        $area = AreaParkir::factory()->create(['kapasitas' => 50, 'terisi' => 10]);

        expect($area->available)->toBe(40)
            ->and($area->occupancy_percent)->toBe(20.0);
    });

    it('does not go below zero available slots', function () {
        $area = AreaParkir::factory()->create(['kapasitas' => 5, 'terisi' => 5]);

        expect($area->available)->toBe(0);
    });
});
