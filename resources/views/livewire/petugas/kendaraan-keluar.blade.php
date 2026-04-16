<div>
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Kendaraan <span class="g-text">Keluar</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm">Riwayat kendaraan yang telah meninggalkan area parkir</p>
        </div>
    </div>

    {{-- Stats mini --}}
    <div class="grid grid-cols-2 gap-3 mb-5">
        <div class="ft-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(148,163,184,0.1);border:1px solid rgba(148,163,184,0.2);">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 dark:text-white/40 font-medium">Total Keluar</p>
                <p class="text-xl font-black text-slate-900 dark:text-white">{{ number_format($todayCount) }}</p>
            </div>
        </div>
        <div class="ft-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 dark:text-white/40 font-medium">Total Pendapatan</p>
                <p class="text-xl font-black text-emerald-400">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="ft-card p-4 mb-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input wire:model.live="search" type="search" placeholder="Cari kode QR, plat nomor, area..."
                       class="ft-input pl-9">
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <input wire:model.live="filterDate" type="date" class="ft-input" style="width:auto;">
                <button wire:click="$set('filterDate', '')" class="btn-ghost py-2 text-xs px-3">Semua</button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="ft-card overflow-hidden">
        <div>
            <table class="ft-table ft-table-responsive w-full">
                <thead>
                    <tr>
                        <th>Kode Tiket</th>
                        <th>Kendaraan</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Durasi</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    @php $isKaryawan = $t->id_kendaraan && is_null($t->id_tarif); @endphp
                    <tr>
                    <td data-label="Kode" class="font-mono text-xs text-indigo-500 font-bold max-w-[100px] truncate">{{ $t->kode_qr }}</td>
                    <td data-label="Kendaraan">
                            <p class="font-bold text-slate-900 dark:text-white capitalize">
                                {{ ucfirst($t->tarif?->jenis_kendaraan ?? $t->kendaraan?->jenis_kendaraan ?? '—') }}
                                @if($isKaryawan)
                                    <span class="ml-1 text-[9px] bg-indigo-500/20 text-indigo-400 px-1.5 py-0.5 rounded font-black uppercase">Karyawan</span>
                                @endif
                            </p>
                            <p class="text-xs text-slate-500">{{ $t->kendaraan?->plat_nomor ?? 'Manless' }}</p>
                        </td>
                    <td data-label="Masuk" class="text-sm text-slate-500 dark:text-white/60">{{ $t->waktu_masuk->format('d M Y, H:i') }}</td>
                    <td data-label="Keluar" class="text-sm text-slate-500 dark:text-white/60 mobile-hidden">{{ $t->waktu_keluar?->format('d M Y, H:i') ?? '—' }}</td>
                    <td data-label="Durasi">
                            @if($t->durasi_jam)
                                <span class="badge-keluar">{{ $t->durasi_jam }} Jam</span>
                            @else
                                <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </td>
                    <td data-label="Biaya">
                            @if($isKaryawan)
                                <span class="text-indigo-400 font-bold text-sm">GRATIS</span>
                            @else
                                <span class="text-slate-900 dark:text-white font-bold text-sm">
                                    Rp {{ number_format($t->biaya_total ?? 0, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                    <td data-label="Aksi">
                            <button wire:click="showDetail({{ $t->id_parkir }})"
                                    class="btn-primary py-1.5 px-3 text-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-slate-300 dark:text-white/10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/>
                                </svg>
                                <p class="text-slate-500 dark:text-white/30 font-medium text-sm">Tidak ada data kendaraan keluar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transaksis->hasPages())
        <div class="p-4 border-t border-slate-200 dark:border-white/5">
            {{ $transaksis->links(data: ['scrollTo' => false]) }}
        </div>
        @endif
    </div>

    {{-- ── DETAIL MODAL ───────────────────────────────── --}}
    @if($detail)
    <div class="ft-modal-overlay" wire:click.self="closeDetail">
        <div class="ft-modal w-full max-w-xl" style="max-height:90vh;overflow-y:auto;">

            {{-- Modal Header --}}
            <div class="flex items-start justify-between mb-5">
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/40 font-black uppercase tracking-wider mb-1">Detail Transaksi</p>
                    <p class="text-slate-900 dark:text-white font-mono font-bold text-sm">{{ $detail->kode_qr }}</p>
                </div>
                <button wire:click="closeDetail" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Foto Masuk & Keluar --}}
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="space-y-2">
                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest text-center">📸 Foto Masuk</p>
                    <div class="rounded-xl overflow-hidden aspect-video bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10">
                        @if($detail->foto_masuk)
                            <img src="{{ asset('storage/photos/' . $detail->foto_masuk) }}"
                                 class="w-full h-full object-cover cursor-pointer"
                                 onclick="window.open(this.src,'_blank')">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-slate-400 dark:text-white/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                                <span class="text-xs">Tidak Ada Foto</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest text-center">📸 Foto Keluar</p>
                    <div class="rounded-xl overflow-hidden aspect-video bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10">
                        @if($detail->foto_keluar)
                            <img src="{{ asset('storage/photos/' . $detail->foto_keluar) }}"
                                 class="w-full h-full object-cover cursor-pointer"
                                 onclick="window.open(this.src,'_blank')">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-slate-400 dark:text-white/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                                <span class="text-xs">Tidak Ada Foto</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="rounded-xl p-4 space-y-3 mb-4" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);">
                @php $isKaryawan = $detail->id_kendaraan && is_null($detail->id_tarif); @endphp

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Plat Nomor</p>
                        <p class="text-slate-900 dark:text-white font-black font-mono tracking-widest">
                            {{ $detail->kendaraan?->plat_nomor ?? '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Jenis</p>
                        <p class="text-slate-900 dark:text-white font-semibold capitalize">
                            {{ ucfirst($detail->tarif?->jenis_kendaraan ?? $detail->kendaraan?->jenis_kendaraan ?? '—') }}
                            @if($isKaryawan)
                                <span class="text-[9px] ml-1 bg-indigo-500/20 text-indigo-400 px-1.5 py-0.5 rounded font-black uppercase">Karyawan</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Area Parkir</p>
                        <p class="text-slate-900 dark:text-white font-semibold">{{ $detail->areaParkir?->nama_area ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Durasi</p>
                        <p class="text-slate-900 dark:text-white font-semibold">{{ $detail->durasi_jam ?? '—' }} Jam</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Waktu Masuk</p>
                        <p class="text-slate-900 dark:text-white font-semibold text-xs">{{ $detail->waktu_masuk->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Waktu Keluar</p>
                        <p class="text-slate-900 dark:text-white font-semibold text-xs">{{ $detail->waktu_keluar?->format('d M Y, H:i') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 dark:text-white/40 text-xs mb-0.5">Diproses oleh</p>
                        <p class="text-slate-900 dark:text-white font-semibold text-xs">{{ $detail->user?->nama_lengkap ?? 'Sistem' }}</p>
                    </div>
                </div>

                {{-- Biaya --}}
                <div class="pt-3 border-t border-slate-200 dark:border-white/5 flex justify-between items-center">
                    <p class="text-slate-500 dark:text-white/50 text-sm">Total Biaya</p>
                    @if($isKaryawan)
                        <p class="text-indigo-400 font-black text-xl">GRATIS</p>
                    @else
                        <p class="text-emerald-400 font-black text-xl">Rp {{ number_format($detail->biaya_total ?? 0, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>

            <button wire:click="closeDetail" class="btn-ghost w-full justify-center py-2.5">Tutup</button>
        </div>
    </div>
    @endif
</div>
