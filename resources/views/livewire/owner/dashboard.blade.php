<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Executive <span class="g-text">Dashboard</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Overview bisnis parkir FastTrack</p>
        </div>
        <p class="text-slate-500 dark:text-white/30 text-xs hidden sm:block">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card"><p class="text-xs text-slate-500 dark:text-white/40 uppercase tracking-wider mb-2">Pendapatan Hari Ini</p><p class="text-2xl font-black text-emerald-400">Rp {{ number_format($todayRevenue/1000,0,',','.') }}k</p></div>
        <div class="stat-card"><p class="text-xs text-slate-500 dark:text-white/40 uppercase tracking-wider mb-2">Pendapatan Bulan Ini</p><p class="text-2xl font-black text-orange-500 dark:text-indigo-400">Rp {{ number_format($monthRevenue/1000000,1,',','.') }}jt</p></div>
        <div class="stat-card"><p class="text-xs text-slate-500 dark:text-white/40 uppercase tracking-wider mb-2">Transaksi Hari Ini</p><p class="text-2xl font-black text-slate-900 dark:text-white">{{ $todayCount }}</p></div>
        <div class="stat-card"><p class="text-xs text-slate-500 dark:text-white/40 uppercase tracking-wider mb-2">Aktif Parkir</p><p class="text-2xl font-black text-orange-400">{{ $aktif }}</p></div>
    </div>

    <div class="grid lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 ft-card p-5">
            <h3 class="text-slate-900 dark:text-white font-bold mb-4">Pendapatan 7 Hari Terakhir</h3>
            @php $maxRev = max(array_column($weeklyRevenue,'total') ?: [1]); if($maxRev==0) $maxRev=1; @endphp
            <div class="flex gap-2 h-40">
                @foreach($weeklyRevenue as $day)
                @php $barH = max(4,round(($day['total']/$maxRev)*100)); @endphp
                <div class="flex-1 flex flex-col justify-end group relative h-full">
                    {{-- Tooltip --}}
                    <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center text-xs z-10 left-1/2 -translate-x-1/2">
                        <div class="rounded-lg px-2 py-1 whitespace-nowrap bg-slate-900 dark:bg-[#1e1e2e] border border-white/10">
                            <p class="text-orange-400 dark:text-indigo-300 font-semibold">{{ $day['date'] }}</p>
                            <p class="text-white">Rp {{ number_format($day['total'],0,',','.') }}</p>
                            <p class="text-white/50">{{ $day['count'] }} kendaraan</p>
                        </div>
                        <div class="w-2 h-2 bg-slate-900 dark:bg-[#1e1e2e] rotate-45 -mt-1"></div>
                    </div>
                    {{-- Bar --}}
                    <div class="w-full rounded-t-sm bar-accent"
                         style="height:{{ $barH }}%;min-height:4px;transition:height 0.6s ease;"></div>
                </div>
                @endforeach
            </div>
            {{-- Labels row --}}
            <div class="flex gap-2 mt-1">
                @foreach($weeklyRevenue as $day)
                <div class="flex-1 text-center">
                    <span class="text-xs text-slate-500 dark:text-white/30">{{ $day['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="ft-card p-5">
            <h3 class="text-slate-900 dark:text-white font-bold mb-4">Per Jenis Kendaraan</h3>
            @php $totalTrx = $vehicleBreakdown->sum('total') ?: 1; $colors=['motor'=>'#60a5fa','mobil'=>'#a78bfa','lainnya'=>'#fb923c']; @endphp
            <div class="space-y-4">
                @foreach($vehicleBreakdown as $vb)
                @php $pct=round(($vb->total/$totalTrx)*100); $color=$colors[$vb->jenis_kendaraan]??'#94a3b8'; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-slate-500 dark:text-white/70 font-medium capitalize">{{ ucfirst($vb->jenis_kendaraan) }}</span>
                        <span style="color:{{ $color }}" class="font-bold">{{ $vb->total }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-200 dark:bg-white/6"><div class="h-1.5 rounded-full" style="width:{{ $pct }}%;background:{{ $color }};"></div></div>
                    <p class="text-xs text-slate-500 dark:text-white/30 mt-1">Rp {{ number_format($vb->revenue/1000,0,',','.') }}k</p>
                </div>
                @endforeach
                @if($vehicleBreakdown->isEmpty())<p class="text-slate-500 dark:text-white/30 text-sm text-center py-4">Belum ada data</p>@endif
            </div>
        </div>
    </div>

    <div class="ft-card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-900 dark:text-white font-bold">Status Area Parkir</h3>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3">
            @foreach($areas as $area)
            @php $pct=$area->kapasitas>0?round(($area->terisi/$area->kapasitas)*100):0; $c=$pct>=90?'#f87171':($pct>=70?'#fb923c':'#34d399'); @endphp
            <div class="rounded-xl p-3 text-center bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/6">
                <p class="text-xs text-slate-500 dark:text-white/50 mb-1 truncate">{{ $area->nama_area }}</p>
                <p class="text-xl font-black" style="color:{{ $c }}">{{ $pct }}%</p>
                <p class="text-xs text-slate-500 dark:text-white/30">{{ $area->terisi }}/{{ $area->kapasitas }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>






