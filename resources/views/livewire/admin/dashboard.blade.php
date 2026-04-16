<div class="space-y-6">

    {{-- Page header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Dashboard <span class="g-text">Admin</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Selamat datang, {{ auth()->user()->nama_lengkap }} 👋</p>
        </div>
        <div class="text-right hidden sm:block">
            <p class="text-slate-500 dark:text-white/30 text-xs">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="text-slate-500 dark:text-white/50 text-sm font-semibold" x-data x-text="new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'})"></p>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.25);">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                </div>
                <span class="badge-masuk">Aktif</span>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $aktifParkir }}</p>
            <p class="text-slate-500 dark:text-white/40 text-xs mt-1">Kendaraan Parkir Sekarang</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.25);">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white">Rp {{ number_format($todayRevenue/1000, 0, ',', '.') }}k</p>
            <p class="text-slate-500 dark:text-white/40 text-xs mt-1">Pendapatan Hari Ini</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.25);">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayTransaksi }}</p>
            <p class="text-slate-500 dark:text-white/40 text-xs mt-1">Transaksi Hari Ini</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(251,146,60,0.15); border: 1px solid rgba(251,146,60,0.25);">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalUsers }}</p>
            <p class="text-slate-500 dark:text-white/40 text-xs mt-1">Total Pengguna Aktif</p>
        </div>
    </div>

    {{-- Area occupancy + Weekly chart --}}
    <div class="grid lg:grid-cols-2 gap-4">
        <div class="ft-card p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-900 dark:text-white font-bold">Kapasitas Area Parkir</h3>
            </div>
            <div class="space-y-3">
                @foreach($areas as $area)
                @php
                    $pct = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                    $color = $pct >= 90 ? '#f87171' : ($pct >= 70 ? '#fb923c' : '#34d399');
                @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-500 dark:text-white/60 font-medium">{{ $area->nama_area }}</span>
                        <span class="font-semibold" style="color: {{ $color }}">{{ $area->terisi }}/{{ $area->kapasitas }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-1.5 rounded-full" style="background: rgba(255,255,255,0.06);">
                        <div class="h-1.5 rounded-full" style="width: {{ $pct }}%; background: {{ $color }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="ft-card p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-900 dark:text-white font-bold">Pendapatan 7 Hari</h3>
            </div>
            @php
                $maxRevenue = max(array_column($weeklyData, 'total') ?: [1]);
                if ($maxRevenue == 0) $maxRevenue = 1;
            @endphp
            <div class="flex items-end gap-1.5 h-36">
                @foreach($weeklyData as $day)
                @php
                    // 112px = container h-36 (144px) - 32px label area
                    $barPx = max(4, (int) round(($day['total'] / $maxRevenue) * 112));
                @endphp
                <div class="flex-1 flex flex-col items-center justify-end gap-1 h-full group cursor-pointer"
                     title="Rp {{ number_format($day['total'],0,',','.') }}">
                    <span class="text-[9px] font-semibold text-slate-400 dark:text-white/30 opacity-0 group-hover:opacity-100 transition-opacity -mb-0.5">
                        {{ $day['total'] > 0 ? number_format($day['total']/1000,0).'k' : '' }}
                    </span>
                    <div class="w-full rounded-t-lg bar-accent transition-all duration-700"
                         style="height: {{ $barPx }}px;"></div>
                    <span class="text-[10px] text-slate-400 dark:text-white/30 flex-shrink-0 mt-0.5">{{ $day['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent logs --}}
    <div class="ft-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-white/5 flex items-center justify-between">
            <h3 class="text-slate-900 dark:text-white font-bold">Log Aktivitas Terbaru</h3>
            <a href="{{ route('admin.logs') }}" class="text-xs text-indigo-400 hover:text-indigo-300">Lihat Semua →</a>
        </div>
        <table class="ft-table">
            <thead><tr><th>Pengguna</th><th>Aktivitas</th><th>Waktu</th></tr></thead>
            <tbody>
                @forelse($recentLogs as $log)
                <tr>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold" style="background: rgba(99,102,241,0.15); color: #a5b4fc;">{{ $log->user?->initials() ?? '?' }}</div>
                            <span class="font-medium text-slate-500 dark:text-white/80">{{ $log->user?->nama_lengkap ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="text-slate-500 dark:text-white/60">{{ $log->aktivitas }}</td>
                    <td class="text-slate-500 dark:text-white/40 text-xs">{{ $log->waktu_aktivitas->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-slate-500 dark:text-white/30 py-8">Belum ada log</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>






