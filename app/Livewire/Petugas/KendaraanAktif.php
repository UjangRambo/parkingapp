<?php

namespace App\Livewire\Petugas;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;

class KendaraanAktif extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $transaksis = Transaksi::with(['areaParkir', 'tarif', 'kendaraan'])
            ->where('status', 'masuk')
            ->when($this->search, function($query) {
                $query->where('kode_qr', 'like', '%' . $this->search . '%')
                      ->orWhereHas('areaParkir', function($q) {
                          $q->where('nama_area', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest('waktu_masuk')
            ->paginate(15);

        return view('livewire.petugas.kendaraan-aktif', [
            'transaksis' => $transaksis
        ])->layout('layouts.app.sidebar', ['title' => 'Kendaraan Aktif Parkir']);
    }
}
