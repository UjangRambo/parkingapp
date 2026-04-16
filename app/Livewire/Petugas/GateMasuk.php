<?php

namespace App\Livewire\Petugas;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\LogAktivitas;
use Illuminate\Support\Str;
use Livewire\Component;

class GateMasuk extends Component
{
    public int $step = 1;
    public ?Transaksi $newTransaksi = null;
    public ?string $foto_capture = null;
    public bool $isKaryawan = false;          // Flag apakah transaksi ini milik karyawan
    public ?Kendaraan $karyawanData = null;   // Data kendaraan karyawan yang terdeteksi

    private function simpanFoto(?string $base64): ?string
    {
        if (!$base64) return null;

        $img  = str_replace('data:image/jpeg;base64,', '', $base64);
        $img  = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $filename = 'pk_' . time() . '_' . Str::random(5) . '.jpg';
        \Illuminate\Support\Facades\Storage::disk('public')->put('photos/' . $filename, $data);

        return $filename;
    }

    /**
     * Dipanggil dari QR scanner di UI saat mendeteksi kode apapun.
     * Deteksi otomatis apakah kode adalah kartu karyawan (KRY-XXXXX) atau kode lain.
     */
    public function scanDariKamera(string $kode): void
    {
        $kode = strtoupper(trim($kode));

        // Cek apakah ini kartu karyawan
        $kendaraan = Kendaraan::where('kode_kartu', $kode)->first();

        if ($kendaraan) {
            // Cek apakah kendaraan ini sudah ada di dalam (belum keluar)
            $existing = Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)
                ->where('status', 'masuk')
                ->first();

            if ($existing) {
                session()->flash('error', "Kendaraan {$kendaraan->plat_nomor} ({$kendaraan->pemilik}) masih berada di area parkir!");
                return;
            }

            $this->karyawanData = $kendaraan;
            $this->isKaryawan   = true;
            $this->prosesKaryawan($kendaraan);
            return;
        }

        // Bukan kartu karyawan, abaikan (kode QR tiket keluar tidak perlu diproses di gate masuk)
        session()->flash('error', 'Kode tidak dikenali. Gunakan tombol kendaraan di bawah untuk proses pengunjung.');
    }

    /**
     * Proses masuk khusus karyawan — gratis, otomatis, tanpa pilih jenis.
     */
    private function prosesKaryawan(Kendaraan $k): void
    {
        $jenis = strtolower($k->jenis_kendaraan);

        if ($jenis === 'motor') {
            $area = AreaParkir::where('jenis_khusus', 'motor')->whereRaw('terisi < kapasitas')->first();
        } else {
            $area = AreaParkir::whereNull('jenis_khusus')->whereRaw('terisi < kapasitas')->inRandomOrder()->first();
        }

        if (!$area) {
            session()->flash('error', "Area parkir untuk {$jenis} penuh!");
            $this->isKaryawan   = false;
            $this->karyawanData = null;
            return;
        }

        $fotoPath = $this->simpanFoto($this->foto_capture);

        // Kode QR unik per sesi: kode_kartu + timestamp agar tidak duplicate
        // Format: KRY-XXXXX-YYYYMMDDHHmmss (tetap identifiable sebagai karyawan)
        $kodeQr = $k->kode_kartu . '-' . now()->format('YmdHis');

        $transaksi = Transaksi::create([
            'kode_qr'      => $kodeQr,
            'id_kendaraan' => $k->id_kendaraan,
            'id_area'      => $area->id_area,
            'waktu_masuk'  => now(),
            'id_tarif'     => null,    // Gratis
            'biaya_total'  => 0,
            'foto_masuk'   => $fotoPath,
            'status'       => 'masuk',
            'id_user'      => auth()->id(),
        ]);

        $area->increment('terisi');
        LogAktivitas::catat(auth()->id(), 'Gate masuk KARYAWAN: ' . $k->plat_nomor . ' (' . ($k->pemilik ?: 'Karyawan') . ')');

        $this->newTransaksi = $transaksi->load(['areaParkir', 'kendaraan']);
        $this->newTransaksi->jenis_kendaraan_label = $jenis;
        $this->step = 3; // Step 3 = tampilan khusus karyawan
    }

    /**
     * Dipanggil dari tombol pilih jenis kendaraan (pengunjung biasa).
     */
    public function submitKendaraan(string $jenis, ?string $base64 = null): void
    {
        if ($base64) $this->foto_capture = $base64;
        $this->prosesMasuk(strtolower($jenis));
    }

    private function prosesMasuk(string $jenis): void
    {
        if ($jenis === 'motor') {
            $area = AreaParkir::where('jenis_khusus', 'motor')
                ->whereRaw('terisi < kapasitas')
                ->first();
        } else {
            $area = AreaParkir::whereNull('jenis_khusus')
                ->whereRaw('terisi < kapasitas')
                ->inRandomOrder()
                ->first();
        }

        if (!$area) {
            session()->flash('error', "Area parkir untuk {$jenis} penuh!");
            return;
        }

        $fotoPath = $this->simpanFoto($this->foto_capture);
        $tarif    = Tarif::where('jenis_kendaraan', $jenis)->first();
        $kodeQr   = 'FT-' . strtoupper(Str::random(4)) . '-' . now()->format('YmdHis');

        $transaksi = Transaksi::create([
            'kode_qr'      => $kodeQr,
            'id_kendaraan' => null, // Manless — pengunjung
            'id_area'      => $area->id_area,
            'waktu_masuk'  => now(),
            'id_tarif'     => $tarif?->id_tarif,
            'foto_masuk'   => $fotoPath,
            'status'       => 'masuk',
            'id_user'      => auth()->id(),
        ]);

        $area->increment('terisi');
        LogAktivitas::catat(auth()->id(), 'Gate masuk: ' . $kodeQr . ' (' . $jenis . ')');

        $this->newTransaksi = $transaksi->load(['areaParkir', 'tarif']);
        $this->newTransaksi->jenis_kendaraan_label = $jenis;
        $this->isKaryawan = false;
        $this->step = 2;
    }

    public function resetForm(): void
    {
        $this->reset(['newTransaksi', 'isKaryawan', 'karyawanData', 'foto_capture']);
        $this->step = 1;
    }

    public function render()
    {
        $areas = AreaParkir::all();
        $totalMotorTersedia = 0;
        $totalUmumTersedia  = 0;

        foreach ($areas as $area) {
            $tersedia = max(0, $area->kapasitas - $area->terisi);
            if ($area->jenis_khusus === 'motor') {
                $totalMotorTersedia += $tersedia;
            } else {
                $totalUmumTersedia += $tersedia;
            }
        }

        $tarifs = Tarif::orderBy('id_tarif')->get();

        return view('livewire.petugas.gate-masuk', compact('totalMotorTersedia', 'totalUmumTersedia', 'tarifs'))
            ->layout('layouts.app.sidebar', ['title' => 'Gate Masuk']);
    }
}
