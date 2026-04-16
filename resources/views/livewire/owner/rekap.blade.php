<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Rekap <span class="g-text">Transaksi</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Laporan transaksi parkir dengan filter tanggal</p>
        </div>

        {{-- Export Dropdown --}}
        <div class="relative flex-shrink-0" x-data="{ open: false }" @keydown.escape.window="open = false" @click.outside="open = false">
            <button
                @click="open = !open"
                class="btn-primary flex items-center gap-2 select-none"
                id="export-dropdown-btn"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Export
                <svg class="w-3 h-3 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                class="absolute right-0 mt-2 w-52 rounded-xl overflow-hidden z-50"
                style="background: #1a1a2e; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 60px rgba(0,0,0,0.5);"
            >
                <div class="p-1.5">
                    <p class="text-xs text-white/30 px-3 pt-2 pb-1 uppercase tracking-wider font-semibold">Pilih Format</p>

                    {{-- CSV --}}
                    <a
                        :href="`{{ route('owner.export.csv') }}?dateFrom=${$wire.dateFrom}&dateTo=${$wire.dateTo}&filterJenis=${$wire.filterJenis}&filterStatus=${$wire.filterStatus}`"
                        @click="open = false"
                        id="export-csv-btn"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all duration-150"
                    >
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg text-base" style="background: rgba(16,185,129,0.12);">
                            📊
                        </span>
                        <div>
                            <p class="font-semibold text-sm">Export CSV</p>
                            <p class="text-xs text-white/30">Excel / Google Sheets</p>
                        </div>
                    </a>

                    {{-- PDF --}}
                    <a
                        :href="`{{ route('owner.export.pdf') }}?dateFrom=${$wire.dateFrom}&dateTo=${$wire.dateTo}&filterJenis=${$wire.filterJenis}&filterStatus=${$wire.filterStatus}`"
                        @click="open = false"
                        id="export-pdf-btn"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all duration-150"
                    >
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg text-base" style="background: rgba(239,68,68,0.12);">
                            📄
                        </span>
                        <div>
                            <p class="font-semibold text-sm">Export PDF</p>
                            <p class="text-xs text-white/30">Print-ready, A4 Landscape</p>
                        </div>
                    </a>
                </div>

                {{-- Filter hint --}}
                <div class="border-t mx-3 mb-2 pt-2" style="border-color: rgba(255,255,255,0.07);">
                    <p class="text-xs text-white/25 px-1 pb-1">✦ Menggunakan filter yang aktif</p>
                </div>
            </div>
        </div>
    </div>

    <div class="ft-card p-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <label class="ft-label">Dari Tanggal</label>
                <input wire:model.live="dateFrom" type="date" class="ft-input" style="color-scheme:dark;">
            </div>
            <div>
                <label class="ft-label">Sampai Tanggal</label>
                <input wire:model.live="dateTo" type="date" class="ft-input" style="color-scheme:dark;">
            </div>
            <div>
                <label class="ft-label">Jenis Kendaraan</label>
                <select wire:model.live="filterJenis" class="ft-input ft-select">
                    <option value="">Semua</option>
                    <option value="motor">Motor</option>
                    <option value="mobil">Mobil</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="ft-label">Status</label>
                <select wire:model.live="filterStatus" class="ft-input ft-select">
                    <option value="">Semua</option>
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="stat-card text-center"><p class="text-xs text-slate-500 dark:text-white/40 mb-1 uppercase tracking-wider">Total Transaksi</p><p class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalCount }}</p></div>
        <div class="stat-card text-center"><p class="text-xs text-slate-500 dark:text-white/40 mb-1 uppercase tracking-wider">Total Pendapatan</p><p class="text-2xl font-black text-emerald-400">Rp {{ number_format($totalRevenue,0,',','.') }}</p></div>
    </div>

    <div class="ft-card overflow-hidden">
        <table class="ft-table ft-table-responsive w-full">
            <thead>
                <tr><th>Kode QR</th><th>Kendaraan</th><th>Area</th><th>Masuk</th><th>Keluar</th><th>Durasi</th><th>Biaya</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr wire:key="{{ $t->id_parkir }}">
                    <td data-label="Kode" class="mobile-hidden"><span class="font-mono text-xs text-indigo-300">{{ substr($t->kode_qr,0,14) }}…</span></td>
                    <td data-label="Kendaraan">
                        <p class="font-bold font-mono text-slate-500 dark:text-white/90">{{ $t->kendaraan?->plat_nomor ?? '-' }}</p>
                        <p class="text-xs text-slate-500 dark:text-white/40 capitalize">{{ ucfirst($t->kendaraan?->jenis_kendaraan ?? $t->tarif?->jenis_kendaraan ?? '') }}</p>
                    </td>
                    <td data-label="Area" class="text-slate-500 dark:text-white/60 text-xs mobile-hidden">{{ $t->areaParkir?->nama_area ?? '—' }}</td>
                    <td data-label="Masuk" class="text-slate-500 dark:text-white/60 text-xs">{{ $t->waktu_masuk->format('d/m H:i') }}</td>
                    <td data-label="Keluar" class="text-slate-500 dark:text-white/60 text-xs mobile-hidden">{{ $t->waktu_keluar?->format('d/m H:i') ?? '—' }}</td>
                    <td data-label="Durasi" class="text-slate-500 dark:text-white/60">{{ $t->durasi_jam ? $t->durasi_jam.'j' : '—' }}</td>
                    <td data-label="Biaya">
                        @if($t->biaya_total)
                        <span class="text-emerald-400 font-semibold text-sm">Rp {{ number_format($t->biaya_total/1000,0,',','.') }}k</span>
                        @else<span class="text-slate-500 dark:text-white/30">—</span>@endif
                    </td>
                    <td data-label="Status"><span class="{{ $t->status==='masuk'?'badge-masuk':'badge-keluar' }}">{{ ucfirst($t->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-slate-500 dark:text-white/30 py-12">Tidak ada data transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-slate-200 dark:border-white/5">{{ $transaksis->links() }}</div>
    </div>
</div>






