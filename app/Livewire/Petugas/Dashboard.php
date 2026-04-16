<?php

namespace App\Livewire\Petugas;

use App\Models\AreaParkir;
use App\Models\Transaksi;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalAktif = Transaksi::where('status', 'masuk')->count();
        $todayCount = Transaksi::whereDate('waktu_masuk', today())->count();
        $areas      = AreaParkir::all();
        $recent     = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
                        ->where('status', 'masuk')
                        ->latest('waktu_masuk')
                        ->take(10)
                        ->get();

        return view('livewire.petugas.dashboard', compact('totalAktif', 'todayCount', 'areas', 'recent'))
            ->layout('layouts.app.sidebar', ['title' => 'Dashboard Petugas']);
    }
}
