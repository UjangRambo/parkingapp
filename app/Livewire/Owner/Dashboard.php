<?php

namespace App\Livewire\Owner;

use App\Models\AreaParkir;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $todayRevenue = Transaksi::whereDate('waktu_keluar', today())->where('status', 'keluar')->sum('biaya_total');
        $monthRevenue = Transaksi::whereMonth('waktu_keluar', now()->month)->where('status', 'keluar')->sum('biaya_total');
        $todayCount   = Transaksi::whereDate('waktu_masuk', today())->count();
        $aktif        = Transaksi::where('status', 'masuk')->count();
        $areas        = AreaParkir::all();

        $vehicleBreakdown = Transaksi::where('tb_transaksi.status', 'keluar')
            ->leftJoin('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->leftJoin('tb_tarif', 'tb_transaksi.id_tarif', '=', 'tb_tarif.id_tarif')
            ->selectRaw("
                COALESCE(tb_kendaraan.jenis_kendaraan, tb_tarif.jenis_kendaraan, 'lainnya') as jenis_kendaraan,
                count(*) as total,
                sum(tb_transaksi.biaya_total) as revenue
            ")
            ->groupByRaw("COALESCE(tb_kendaraan.jenis_kendaraan, tb_tarif.jenis_kendaraan, 'lainnya')")
            ->get();

        $weeklyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyRevenue[] = [
                'label' => $date->format('D'),
                'date'  => $date->format('d M'),
                'total' => (float) Transaksi::whereDate('waktu_keluar', $date)->where('status', 'keluar')->sum('biaya_total'),
                'count' => Transaksi::whereDate('waktu_masuk', $date)->count(),
            ];
        }

        return view('livewire.owner.dashboard', compact(
            'todayRevenue', 'monthRevenue', 'todayCount', 'aktif',
            'areas', 'vehicleBreakdown', 'weeklyRevenue'
        ))->layout('layouts.app.sidebar', ['title' => 'Owner Dashboard']);
    }
}
