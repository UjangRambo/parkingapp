<?php

namespace App\Livewire\Petugas;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use App\Models\LogAktivitas;
use Livewire\Component;

class GateKeluar extends Component
{
    public int     $step      = 1;
    public string  $kode_qr   = '';
    public ?Transaksi $transaksi = null;
    public float   $biaya     = 0;
    public int     $durasi    = 0;
    public float   $denda     = 0;
    public string  $bayar     = '';
    public float   $kembalian = 0;
    public ?string $foto_capture = null;

    private function simpanFoto(?string $base64): ?string
    {
        if (!$base64) return null;

        $img = str_replace('data:image/jpeg;base64,', '', $base64);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $filename = 'ex_' . time() . '_' . \Illuminate\Support\Str::random(5) . '.jpg';
        \Illuminate\Support\Facades\Storage::disk('public')->put('photos/' . $filename, $data);

        return $filename;
    }

    public function cariQr(): void
    {
        $this->validate(['kode_qr' => 'required|string']);
        $this->prosesScan($this->kode_qr);
    }

    public function scanDariKamera(string $kode): void
    {
        $this->kode_qr = $kode;
        $this->prosesScan($kode);
    }

    public function pilihVisual(string $kode): void
    {
        $this->kode_qr = $kode;
        $this->prosesScan($kode);
    }

    private function prosesScan(string $kode): void
    {
        // Coba cari exact match dulu (pengunjung / QR tiket normal)
        $t = Transaksi::where('kode_qr', $kode)
                      ->where('status', 'masuk')
                      ->with(['kendaraan', 'areaParkir', 'tarif'])
                      ->first();

        // Fallback: jika tidak ketemu, cek apakah kode ini adalah kode_kartu karyawan
        // (kode_qr di DB bentuknya KRY-XXXXX-timestamp, tapi kartu fisik hanya emit KRY-XXXXX)
        if (!$t) {
            $kendaraan = Kendaraan::where('kode_kartu', $kode)->first();
            if ($kendaraan) {
                $t = Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)
                              ->where('status', 'masuk')
                              ->with(['kendaraan', 'areaParkir', 'tarif'])
                              ->latest('waktu_masuk')
                              ->first();
            }
        }

        if (!$t) {
            $this->addError('kode_qr', 'Tiket tidak ditemukan atau sudah diproses.');
            return;
        }

        // Deteksi karyawan: punya kendaraan & tarif null (free)
        $isKaryawan = $t->id_kendaraan && is_null($t->id_tarif);

        if ($isKaryawan) {
            // Auto-checkout langsung gratis
            $keluar   = now();
            $durasi   = (int) ceil($t->waktu_masuk->diffInMinutes($keluar) / 60);
            if ($durasi < 1) $durasi = 1;

            $fotoPath = $this->simpanFoto($this->foto_capture);

            $t->update([
                'waktu_keluar' => $keluar,
                'durasi_jam'   => $durasi,
                'biaya_total'  => 0,
                'foto_keluar'  => $fotoPath,
                'status'       => 'keluar',
                'id_user'      => auth()->id(),
            ]);

            AreaParkir::find($t->id_area)?->decrement('terisi');
            LogAktivitas::catat(auth()->id(), 'Gate keluar KARYAWAN: ' . $t->kode_qr . ' - GRATIS');

            $this->transaksi = $t->fresh(['kendaraan', 'areaParkir', 'tarif']);
            $this->biaya     = 0;
            $this->durasi    = $durasi;
            $this->denda     = 0;
            $this->kembalian = 0;
            $this->step      = 3; // Langsung ke struk, skip bayar
            return;
        }

        $result          = Transaksi::hitungBiaya($t->waktu_masuk, now(), $t->tarif?->tarif_per_jam ?? 0);
        $this->transaksi = $t;
        $this->biaya     = $result['biaya_total'];
        $this->durasi    = $result['durasi_jam'];
        $this->denda     = $result['denda'];
        $this->bayar     = '';
        $this->kembalian = 0;
        $this->step      = 2;
    }

    public function prosesBayar(?string $base64 = null): void
    {
        if ($base64) $this->foto_capture = $base64;
        $bayarVal = (float) $this->bayar;
        $this->validate(['bayar' => 'required|numeric|min:0']);

        if ($bayarVal < $this->biaya) {
            $this->addError('bayar', 'Jumlah bayar kurang dari biaya parkir.');
            return;
        }

        $t      = Transaksi::findOrFail($this->transaksi->id_parkir);
        $keluar = now();
        $result = Transaksi::hitungBiaya($t->waktu_masuk, $keluar, $t->tarif?->tarif_per_jam ?? 0);

        $fotoPath = $this->simpanFoto($this->foto_capture);
        $t->update([
            'waktu_keluar' => $keluar,
            'durasi_jam'   => $result['durasi_jam'],
            'biaya_total'  => $result['biaya_total'],
            'foto_keluar'  => $fotoPath,
            'status'       => 'keluar',
            'id_user'      => auth()->id(),
        ]);

        AreaParkir::find($t->id_area)?->decrement('terisi');
        LogAktivitas::catat(auth()->id(), 'Gate keluar: ' . $t->kode_qr . ' - Rp ' . number_format($result['biaya_total'], 0, ',', '.'));

        $this->transaksi = $t->fresh(['kendaraan', 'areaParkir', 'tarif']);
        $this->biaya     = $result['biaya_total'];
        $this->durasi    = $result['durasi_jam'];
        $this->denda     = $result['denda'];
        $this->kembalian = $bayarVal - $result['biaya_total'];
        $this->step      = 3;
    }

    public function resetForm(): void
    {
        $this->reset(['kode_qr', 'transaksi', 'biaya', 'durasi', 'denda', 'bayar', 'kembalian', 'foto_capture']);
        $this->step = 1;
    }

    public function render()
    {
        // Load active transactions for visual gallery
        $activeTransaksis = Transaksi::where('status', 'masuk')
            ->with(['areaParkir', 'tarif', 'kendaraan'])
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        return view('livewire.petugas.gate-keluar', compact('activeTransaksis'))
            ->layout('layouts.app.sidebar', ['title' => 'Gate Keluar']);
    }
}
