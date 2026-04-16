<?php

namespace App\Livewire\Petugas;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;

class KendaraanKeluar extends Component
{
    use WithPagination;

    public string  $search     = '';
    public string  $filterDate = '';
    public ?int    $detailId   = null;

    public function mount(): void
    {
        $this->filterDate = now()->format('Y-m-d');
    }

    public function updatedSearch(): void    { $this->resetPage(); }
    public function updatedFilterDate(): void { $this->resetPage(); }

    public function showDetail(int $id): void
    {
        $this->detailId = $id;
    }

    public function closeDetail(): void
    {
        $this->detailId = null;
    }

    public function render()
    {
        $query = Transaksi::with(['kendaraan', 'areaParkir', 'tarif', 'user'])
            ->where('status', 'keluar')
            ->when($this->filterDate, fn($q) => $q->whereDate('waktu_keluar', $this->filterDate))
            ->when($this->search, fn($q) =>
                $q->where('kode_qr', 'like', '%' . $this->search . '%')
                  ->orWhereHas('kendaraan', fn($k) =>
                      $k->where('plat_nomor', 'like', '%' . $this->search . '%')
                  )
                  ->orWhereHas('areaParkir', fn($a) =>
                      $a->where('nama_area', 'like', '%' . $this->search . '%')
                  )
            )
            ->latest('waktu_keluar');

        $transaksis   = $query->paginate(15);
        $todayCount   = (clone $query)->count();
        $todayRevenue = Transaksi::where('status', 'keluar')
            ->when($this->filterDate, fn($q) => $q->whereDate('waktu_keluar', $this->filterDate))
            ->sum('biaya_total');

        $detail = $this->detailId
            ? Transaksi::with(['kendaraan', 'areaParkir', 'tarif', 'user'])->find($this->detailId)
            : null;

        return view('livewire.petugas.kendaraan-keluar', compact('transaksis', 'todayCount', 'todayRevenue', 'detail'))
            ->layout('layouts.app.sidebar', ['title' => 'Kendaraan Keluar']);
    }
}
