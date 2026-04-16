<?php

namespace App\Livewire\Admin;

use App\Models\Kendaraan as KendaraanModel;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;

class Kendaraan extends Component
{
    use WithPagination;

    public bool    $showModal       = false;
    public bool    $showKartuModal  = false;
    public ?int    $editId          = null;
    public string  $plat_nomor      = '';
    public string  $jenis_kendaraan = 'motor';
    public string  $warna           = '';
    public string  $pemilik         = '';
    public string  $search          = '';
    public ?int    $confirmDelete   = null;
    public ?string $generatedKartu  = null; // kode kartu yang baru di-generate
    public ?string $kartuNama       = null; // nama pemilik untuk modal kartu

    public function updatedSearch(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->reset(['editId', 'plat_nomor', 'warna', 'pemilik']);
        $this->jenis_kendaraan = 'motor';
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $k = KendaraanModel::findOrFail($id);
        $this->editId          = $id;
        $this->plat_nomor      = $k->plat_nomor;
        $this->jenis_kendaraan = $k->jenis_kendaraan;
        $this->warna           = $k->warna ?? '';
        $this->pemilik         = $k->pemilik ?? '';
        $this->showModal       = true;
    }

    public function save(): void
    {
        $this->validate([
            'plat_nomor'      => 'required|string|max:15',
            'jenis_kendaraan' => 'required|string|max:20',
            'warna'           => 'nullable|string|max:20',
            'pemilik'         => 'nullable|string|max:100',
        ]);

        $data = [
            'plat_nomor'      => strtoupper($this->plat_nomor),
            'jenis_kendaraan' => $this->jenis_kendaraan,
            'warna'           => $this->warna,
            'pemilik'         => $this->pemilik,
        ];

        if ($this->editId) {
            KendaraanModel::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Kendaraan diperbarui.');
        } else {
            KendaraanModel::create($data);
            session()->flash('success', 'Kendaraan ditambahkan.');
        }

        LogAktivitas::catat(auth()->id(), 'Kelola kendaraan: ' . $this->plat_nomor);
        $this->showModal = false;
    }

    public function generateKartu(int $id): void
    {
        $k = KendaraanModel::findOrFail($id);

        // Jika belum punya kartu, buat baru. Jika sudah ada, tampilkan yang lama.
        if (!$k->kode_kartu) {
            $k->update(['kode_kartu' => KendaraanModel::generateKodeKartu()]);
            LogAktivitas::catat(auth()->id(), 'Generate kartu karyawan: ' . $k->plat_nomor);
        }

        $this->generatedKartu  = $k->fresh()->kode_kartu;
        $this->kartuNama       = $k->pemilik ?: $k->plat_nomor;
        $this->showKartuModal  = true;
    }

    public function revokeKartu(int $id): void
    {
        $k = KendaraanModel::findOrFail($id);
        $k->update(['kode_kartu' => null]);
        LogAktivitas::catat(auth()->id(), 'Cabut kartu karyawan: ' . $k->plat_nomor);
        session()->flash('success', 'Kartu karyawan dicabut.');
    }

    public function deleteKendaraan(int $id): void
    {
        $k    = KendaraanModel::findOrFail($id);
        $plat = $k->plat_nomor;
        $k->delete();
        LogAktivitas::catat(auth()->id(), 'Hapus kendaraan: ' . $plat);
        session()->flash('success', 'Kendaraan dihapus.');
        $this->confirmDelete = null;
    }

    public function render()
    {
        $kendaraans = KendaraanModel::when(
            $this->search,
            fn($q) => $q->where('plat_nomor', 'like', '%' . $this->search . '%')
                        ->orWhere('pemilik', 'like', '%' . $this->search . '%')
        )->latest()->paginate(15);

        return view('livewire.admin.kendaraan', compact('kendaraans'))
            ->layout('layouts.app.sidebar', ['title' => 'Data Kendaraan Karyawan']);
    }
}
