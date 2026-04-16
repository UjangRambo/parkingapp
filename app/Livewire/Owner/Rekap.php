<?php

namespace App\Livewire\Owner;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;

class Rekap extends Component
{
    use WithPagination;

    public string $dateFrom     = '';
    public string $dateTo       = '';
    public string $filterJenis  = '';
    public string $filterStatus = '';

    public function mount(): void
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo   = now()->format('Y-m-d');
    }

    public function updatedDateFrom(): void { $this->resetPage(); }
    public function updatedDateTo(): void { $this->resetPage(); }
    public function updatedFilterJenis(): void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }

    public function render()
    {
        $query = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->when($this->dateFrom, fn($q) => $q->whereDate('waktu_masuk', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn($q) => $q->whereDate('waktu_masuk', '<=', $this->dateTo))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterJenis, fn($q) => $q->whereHas('kendaraan', fn($k) => $k->where('jenis_kendaraan', $this->filterJenis)));

        $transaksis   = $query->latest('waktu_masuk')->paginate(20);
        $totalRevenue = (clone $query)->where('status', 'keluar')->sum('biaya_total');
        $totalCount   = (clone $query)->count();

        return view('livewire.owner.rekap', compact('transaksis', 'totalRevenue', 'totalCount'))
            ->layout('layouts.app.sidebar', ['title' => 'Rekap Transaksi']);
    }
}
