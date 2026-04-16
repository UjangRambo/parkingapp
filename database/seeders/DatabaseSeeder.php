<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Default Users ────────────────────────────────────────────────
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama_lengkap' => 'Administrator',
                'email'        => 'admin@fasttrack.id',
                'password'     => Hash::make('password'),
                'role'         => 'admin',
                'status_aktif' => true,
            ]
        );

        User::firstOrCreate(
            ['username' => 'owner'],
            [
                'nama_lengkap' => 'Owner FastTrack',
                'email'        => 'owner@fasttrack.id',
                'password'     => Hash::make('password'),
                'role'         => 'owner',
                'status_aktif' => true,
            ]
        );

        User::firstOrCreate(
            ['username' => 'petugas1'],
            [
                'nama_lengkap' => 'Petugas Satu',
                'email'        => 'petugas1@fasttrack.id',
                'password'     => Hash::make('password'),
                'role'         => 'petugas',
                'status_aktif' => true,
            ]
        );

        // ── Default Tarif ────────────────────────────────────────────────
        $tarifs = [
            ['jenis_kendaraan' => 'motor',   'tarif_per_jam' => 2000],
            ['jenis_kendaraan' => 'mobil',   'tarif_per_jam' => 5000],
            ['jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 3000],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::firstOrCreate(
                ['jenis_kendaraan' => $tarif['jenis_kendaraan']],
                ['tarif_per_jam'   => $tarif['tarif_per_jam']]
            );
        }

        // ── Default Area Parkir ──────────────────────────────────────────
        $areas = [
            ['nama_area' => 'Lantai 1 - Blok A', 'kapasitas' => 50,  'terisi' => 0, 'jenis_khusus' => null],
            ['nama_area' => 'Lantai 1 - Blok B', 'kapasitas' => 50,  'terisi' => 0, 'jenis_khusus' => null],
            ['nama_area' => 'Lantai 2 - Blok A', 'kapasitas' => 100, 'terisi' => 0, 'jenis_khusus' => null],
            ['nama_area' => 'Lantai 2 - Blok B', 'kapasitas' => 100, 'terisi' => 0, 'jenis_khusus' => null],
            ['nama_area' => 'Basement',           'kapasitas' => 200, 'terisi' => 0, 'jenis_khusus' => 'motor'],
        ];

        foreach ($areas as $area) {
            AreaParkir::firstOrCreate(
                ['nama_area' => $area['nama_area']],
                ['kapasitas' => $area['kapasitas'], 'terisi' => $area['terisi'], 'jenis_khusus' => $area['jenis_khusus']]
            );
        }
    }
}
