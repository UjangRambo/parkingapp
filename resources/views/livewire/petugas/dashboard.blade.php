<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Dashboard <span class="g-text">Petugas</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Selamat datang, {{ auth()->user()->nama_lengkap }}</p>
        </div>
        <div x-data="{ 
            date: '', 
            time: '',
            update() {
                const now = new Date();
                this.date = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
        }" x-init="update(); setInterval(() => update(), 1000)" class="text-right hidden sm:block">
            <p class="text-slate-900 dark:text-white font-bold text-sm" x-text="date"></p>
            <p class="text-orange-500 dark:text-indigo-400 font-mono text-xs mt-0.5" x-text="time"></p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('petugas.gate-masuk') }}"
           class="ft-card p-6 flex flex-col items-center justify-center gap-3 group hover:scale-[1.02] transition-transform cursor-pointer"
           style="min-height: 140px; background: linear-gradient(135deg, rgba(234,88,12,0.08), rgba(234,88,12,0.02)); border-color: rgba(249,115,22,0.25);" class="dark:[background:linear-gradient(135deg,rgba(99,102,241,0.1),rgba(99,102,241,0.03))] dark:[border-color:rgba(99,102,241,0.25)]">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: rgba(234,88,12,0.15); border: 1px solid rgba(234,88,12,0.3);">
                <svg class="w-7 h-7 text-orange-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
            </div>
            <div class="text-center">
                <p class="text-slate-900 dark:text-white font-bold text-lg">Gate Masuk</p>
                <p class="text-slate-500 dark:text-white/40 text-sm">Generate tiket QR</p>
            </div>
        </a>

        <a href="{{ route('petugas.gate-keluar') }}"
           class="ft-card p-6 flex flex-col items-center justify-center gap-3 group hover:scale-[1.02] transition-transform cursor-pointer"
           style="min-height: 140px; background: linear-gradient(135deg, rgba(52,211,153,0.1), rgba(52,211,153,0.03)); border-color: rgba(52,211,153,0.25);">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: rgba(52,211,153,0.2); border: 1px solid rgba(52,211,153,0.3);">
                <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/></svg>
            </div>
            <div class="text-center">
                <p class="text-slate-900 dark:text-white font-bold text-lg">Gate Keluar</p>
                <p class="text-slate-500 dark:text-white/40 text-sm">Scan QR & proses bayar</p>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="stat-card text-center"><p class="text-3xl font-black text-orange-500 dark:text-indigo-400">{{ $totalAktif }}</p><p class="text-slate-500 dark:text-white/40 text-xs mt-1">Kendaraan Parkir</p></div>
        <div class="stat-card text-center"><p class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayCount }}</p><p class="text-slate-500 dark:text-white/40 text-xs mt-1">Transaksi Hari Ini</p></div>
        <div class="stat-card text-center"><p class="text-3xl font-black text-emerald-400">{{ $areas->count() }}</p><p class="text-slate-500 dark:text-white/40 text-xs mt-1">Area Parkir</p></div>
    </div>

    <div class="ft-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-white/5"><h3 class="text-slate-900 dark:text-white font-bold">Kendaraan Aktif Parkir</h3></div>
        <table class="ft-table">
            <thead><tr><th>Kode QR</th><th>Kendaraan</th><th>Area</th><th>Masuk</th><th>Durasi</th></tr></thead>
            <tbody>
                @forelse($recent as $t)
                <tr wire:key="{{ $t->id_parkir }}">
                    <td><span class="font-mono text-xs text-orange-500 dark:text-indigo-300">{{ substr($t->kode_qr,0,12) }}…</span></td>
                    <td>
                        <p class="font-bold text-slate-500 dark:text-white/90 font-mono">{{ $t->id_kendaraan ? $t->kendaraan->plat_nomor : 'Tiket Manless' }}</p>
                        <p class="text-xs text-slate-500 dark:text-white/40 capitalize">{{ $t->tarif?->jenis_kendaraan ?? '—' }}</p>
                    </td>
                    <td class="text-slate-500 dark:text-white/60 text-sm">{{ $t->areaParkir?->nama_area ?? '—' }}</td>
                    <td class="text-slate-500 dark:text-white/60 text-sm">{{ $t->waktu_masuk->format('H:i') }}</td>
                    <td>
                        @php
                            $totalMinutes = (int) ceil($t->waktu_masuk->diffInSeconds(now()) / 60);
                            $hours = floor($totalMinutes / 60);
                            $minutes = $totalMinutes % 60;
                        @endphp
                        <span class="badge-masuk">
                            {{ $hours > 0 ? $hours . ' jam ' : '' }}{{ $minutes }} menit
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-slate-500 dark:text-white/30 py-10">Tidak ada kendaraan parkir saat ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>






