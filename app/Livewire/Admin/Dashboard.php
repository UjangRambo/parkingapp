<?php

namespace App\Livewire\Admin;

use App\Models\AreaParkir;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalUsers     = User::where('status_aktif', true)->count();
        $todayRevenue   = Transaksi::whereDate('waktu_keluar', today())->where('status', 'keluar')->sum('biaya_total');
        $todayTransaksi = Transaksi::whereDate('waktu_masuk', today())->count();
        $aktifParkir    = Transaksi::where('status', 'masuk')->count();
        $areas          = AreaParkir::all();
        $recentLogs     = LogAktivitas::with('user')->latest('waktu_aktivitas')->take(10)->get();

        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyData[] = [
                'label' => $date->format('D'),
                'total' => (float) Transaksi::whereDate('waktu_keluar', $date)->where('status', 'keluar')->sum('biaya_total'),
            ];
        }

        return view('livewire.admin.dashboard', compact(
            'totalUsers', 'todayRevenue', 'todayTransaksi', 'aktifParkir',
            'areas', 'recentLogs', 'weeklyData'
        ))->layout('layouts.app.sidebar', ['title' => 'Admin Dashboard']);
    }
}
