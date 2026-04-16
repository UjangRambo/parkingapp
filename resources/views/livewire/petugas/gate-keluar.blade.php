<div class="max-w-3xl mx-auto space-y-5" x-data="qrScanner()">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(52,211,153,0.15);border:1px solid rgba(52,211,153,0.25);">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/></svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Gate <span class="g-text">Keluar</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm">Scan QR tiket dengan kamera</p>
        </div>
    </div>

    @if($step === 1)
    <div class="ft-card p-6 space-y-5">
        <div class="flex gap-2 p-1.5 rounded-xl bg-slate-100 dark:bg-white/5 mb-6 overflow-x-auto">
            <button @click="mode = 'camera'; startScanner()" :class="mode === 'camera' ? 'bg-white dark:bg-[#12121e] shadow-sm text-slate-900 dark:text-white font-semibold' : 'text-slate-500 dark:text-white/50 hover:text-slate-700 dark:hover:text-white/80'" class="flex-1 py-2 px-3 rounded-lg text-sm transition-all focus:outline-none min-w-max">
                📷 Scan QR
            </button>
            <button @click="mode = 'manual'; stopScanner()" :class="mode === 'manual' ? 'bg-white dark:bg-[#12121e] shadow-sm text-slate-900 dark:text-white font-semibold' : 'text-slate-500 dark:text-white/50 hover:text-slate-700 dark:hover:text-white/80'" class="flex-1 py-2 px-3 rounded-lg text-sm transition-all focus:outline-none min-w-max">
                ⌨️ Input Kode
            </button>
            <button @click="mode = 'lost'; stopScanner()" :class="mode === 'lost' ? 'bg-white dark:bg-[#12121e] shadow-sm text-slate-900 dark:text-white font-semibold' : 'text-slate-500 dark:text-white/50 hover:text-slate-700 dark:hover:text-white/80'" class="flex-1 py-2 px-3 rounded-lg text-sm transition-all focus:outline-none min-w-max whitespace-nowrap">
                🔎 Karcis Hilang
            </button>
        </div>

        {{-- Camera Scanner Mode --}}
        <div x-show="mode === 'camera'" class="flex flex-col items-center">
            <div class="relative w-full max-w-sm">
                <div id="reader" class="w-full rounded-2xl overflow-hidden border-2 border-dashed border-emerald-400/30 bg-slate-900" style="min-height:220px;"></div>
                {{-- Scanning indicator --}}
                <div x-show="scanning" class="absolute top-2 right-2 flex items-center gap-1.5 bg-black/60 rounded-full px-2 py-1" x-cloak>
                    <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-white text-[9px] font-bold uppercase tracking-wider">Scanning…</span>
                </div>
            </div>
            <p class="text-slate-500 dark:text-white/40 text-xs mt-3 text-center">Arahkan kamera ke QR Code karcis. Scanner akan mencari otomatis.</p>
            <p x-show="!scanning && mode === 'camera'" class="text-amber-400 text-xs mt-1 text-center" x-cloak>Memulai kamera…</p>
            @error('kode_qr')<p class="text-red-400 text-xs mt-2 text-center bg-red-400/10 py-1.5 px-3 rounded-lg">{{ $message }}</p>@enderror
        </div>

        {{-- Manual Input Mode --}}
        <div x-show="mode === 'manual'" style="display: none;" class="space-y-4">
            <div class="text-center mb-2">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(52,211,153,0.1);border:2px dashed rgba(52,211,153,0.3);">
                    <svg class="w-10 h-10 text-emerald-400/60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/></svg>
                </div>
            </div>
            <div>
                <label class="ft-label">Kode QR / Nomor Tiket</label>
                <input wire:model="kode_qr" id="input-kode-qr" type="text"
                       class="ft-input font-mono text-center" style="padding:14px;letter-spacing:0.05em;"
                       placeholder="FT-XXXX-20241201120000"
                       @keydown.enter="$wire.cariQr()">
                @error('kode_qr')<p class="text-red-400 text-xs mt-1.5 text-center">{{ $message }}</p>@enderror
            </div>
            <button wire:click="cariQr" wire:loading.attr="disabled"
                    class="w-full justify-center py-4 rounded-xl font-bold text-base text-slate-900 dark:text-white flex items-center gap-2"
                    style="background:linear-gradient(135deg,rgba(52,211,153,0.25),rgba(16,185,129,0.15));border:1px solid rgba(52,211,153,0.4);">
                <span wire:loading.remove wire:target="cariQr"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/></svg></span>
                <span wire:loading wire:target="cariQr"><svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg></span>
                Cari Tiket
            </button>
        </div>

        {{-- Visual Search Gallery (Karcis Hilang Mode) --}}
        <div x-show="mode === 'lost'" style="display: none;" class="space-y-4">
            <div class="text-center mb-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3" style="background:rgba(239,68,68,0.1);border:2px dashed rgba(239,68,68,0.3);">
                    <svg class="w-8 h-8 text-red-500/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                </div>
                <h3 class="text-slate-900 dark:text-white font-black text-lg">Pencarian Visual</h3>
                <p class="text-slate-500 dark:text-white/40 text-xs">Cocokkan wajah / kendaraan pengguna yang sedang berada di area parkir.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 overflow-y-auto max-h-[400px] pr-2 custom-scrollbar">
                @forelse($activeTransaksis as $at)
                <button wire:click="pilihVisual('{{ $at->kode_qr }}')" class="group relative text-left rounded-xl overflow-hidden border border-slate-200 dark:border-white/10 shadow-sm hover:border-indigo-500 hover:shadow-indigo-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <div class="aspect-square bg-slate-800 relative z-0">
                        @if($at->foto_masuk)
                            <img src="{{ asset('storage/photos/' . $at->foto_masuk) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-white/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span class="text-xs font-medium">Tanpa Foto</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/30 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-3 z-10">
                        <div class="flex items-center justify-between mb-1">
                            @php
                                $isKaryawan = $at->id_kendaraan && is_null($at->id_tarif);
                            @endphp
                            @if($isKaryawan)
                                <span class="text-indigo-300 font-bold text-sm uppercase">{{ $at->kendaraan?->jenis_kendaraan ?? 'Karyawan' }}</span>
                                <span class="text-[9px] bg-indigo-500/40 text-indigo-200 px-1.5 py-0.5 rounded font-bold uppercase">Karyawan</span>
                            @else
                                <span class="text-white font-bold text-sm uppercase">{{ $at->tarif?->jenis_kendaraan ?? '—' }}</span>
                            @endif
                        </div>
                        @if($isKaryawan && $at->kendaraan?->plat_nomor)
                            <p class="text-white/80 text-[10px] font-mono font-bold">{{ $at->kendaraan->plat_nomor }}</p>
                        @endif
                        <p class="text-white/70 text-[10px] font-mono">Masuk: {{ $at->waktu_masuk->format('H:i') }} WIB</p>
                        <p class="text-white/50 text-[10px] truncate">{{ $at->kode_qr }}</p>
                    </div>
                </button>
                @empty
                <div class="col-span-full border border-dashed border-slate-300 dark:border-white/20 rounded-2xl py-10 flex flex-col items-center justify-center">
                    <svg class="w-10 h-10 text-slate-400 dark:text-white/20 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm3.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75z"/></svg>
                    <p class="text-slate-500 dark:text-white/50 font-medium text-sm">Tidak ada kendaraan di dalam</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function qrScanner() {
            return {
                mode: 'camera',
                scanning: false,
                _qr: null,

                init() {
                    this.$watch('mode', async (val) => {
                        if (val === 'camera') {
                            // Small delay to allow x-show to render the #reader div
                            setTimeout(() => this.startScanner(), 300);
                        } else {
                            await this.stopScanner();
                        }
                    });
                    // Auto-start on load
                    setTimeout(() => this.startScanner(), 800);
                },

                async startScanner() {
                    if (this.scanning) return;
                    if (!document.getElementById('reader')) return;
                    if (typeof Html5Qrcode === 'undefined') {
                        setTimeout(() => this.startScanner(), 500);
                        return;
                    }
                    try {
                        if (!this._qr) {
                            this._qr = new Html5Qrcode('reader');
                        }
                        await this._qr.start(
                            { facingMode: 'environment' },
                            { fps: 10, qrbox: { width: 220, height: 220 } },
                            (text) => {
                                this.stopScanner();
                                @this.call('scanDariKamera', text);
                            },
                            () => { /* continuous scan — ignore failures */ }
                        );
                        this.scanning = true;
                    } catch (err) {
                        // Fallback: try front camera if environment camera fails
                        try {
                            await this._qr.start(
                                { facingMode: 'user' },
                                { fps: 10, qrbox: { width: 220, height: 220 } },
                                (text) => {
                                    this.stopScanner();
                                    @this.call('scanDariKamera', text);
                                },
                                () => {}
                            );
                            this.scanning = true;
                        } catch (e) {
                            console.error('QR camera error:', e);
                        }
                    }
                },

                async stopScanner() {
                    if (this._qr && this.scanning) {
                        try { await this._qr.stop(); } catch (e) {}
                        this.scanning = false;
                    }
                },
            }
        }
    </script>

    @elseif($step === 2 && $transaksi)
    <div x-data="{
        inited: false,
        async init() {
            if (this.inited) return;
            this.inited = true;
            setTimeout(async () => {
                const ok = await window.ftWebcam.start(this.$refs.videoOut);
                if (!ok) console.error('Gagal akses kamera keluar');
            }, 100);
        },
        async bayar() {
            const base64 = window.ftWebcam.capture(this.$refs.videoOut);
            await $wire.set('foto_capture', base64);
            await $wire.prosesBayar();
        }
    }" x-init="init()" class="space-y-4">
        {{-- SECURITY VERIFICATION SECTION --}}
        <div class="grid grid-cols-2 gap-3">
            <div class="space-y-2">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">FOTO SAAT MASUK</p>
                <div class="ft-card aspect-video overflow-hidden bg-slate-800 border-indigo-500/30">
                    @if($transaksi->foto_masuk)
                        <img src="{{ asset('storage/photos/' . $transaksi->foto_masuk) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-500 text-xs italic">Tanpa Foto</div>
                    @endif
                </div>
            </div>
            <div class="space-y-2">
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest text-center">KAMERA LOKET SEKARANG</p>
                <div class="ft-card aspect-video overflow-hidden bg-slate-800 border-emerald-500/30 relative">
                    <video x-ref="videoOut" autoplay playsinline class="w-full h-full object-cover"></video>
                    <div class="absolute bottom-2 left-2 flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                        <span class="text-white/70 text-[8px] font-bold uppercase tracking-tighter">Exit Verify</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECURITY WARNING ALERT --}}
        <div class="bg-amber-500/10 border border-amber-500/30 p-3 rounded-xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <p class="text-amber-500/90 text-xs font-bold leading-tight">PERINGATAN KEAMANAN:<br><span class="text-[10px] font-normal opacity-80 uppercase tracking-wider">Pastikan wajah pengemudi sama dengan foto saat masuk!</span></p>
        </div>

        <div class="ft-card p-6 space-y-4">
            <div class="rounded-xl p-4" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);">
                <p class="text-xs text-slate-500 dark:text-white/30 uppercase tracking-wider mb-3">Detail Transaksi</p>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><p class="text-slate-500 dark:text-white/40">Plat Nomor</p><p class="text-slate-900 dark:text-white font-black font-mono text-lg tracking-widest">{{ $transaksi->kendaraan?->plat_nomor ?? '—' }}</p></div>
                    <div><p class="text-slate-500 dark:text-white/40">Jenis</p><p class="text-slate-900 dark:text-white font-semibold capitalize">{{ ucfirst($transaksi->tarif?->jenis_kendaraan ?? '—') }}</p></div>
                    <div><p class="text-slate-500 dark:text-white/40">Area</p><p class="text-slate-900 dark:text-white font-semibold">{{ $transaksi->areaParkir?->nama_area ?? '—' }}</p></div>
                    <div><p class="text-slate-500 dark:text-white/40">Masuk</p><p class="text-slate-900 dark:text-white font-semibold">{{ $transaksi->waktu_masuk->format('d M - H:i') }}</p></div>
                    <div><p class="text-slate-500 dark:text-white/40">Durasi</p><p class="text-slate-900 dark:text-white font-semibold">{{ $durasi }} Jam</p></div>
                    <div><p class="text-slate-500 dark:text-white/40">Tarif/Jam</p><p class="text-slate-900 dark:text-white font-semibold">Rp {{ number_format($transaksi->tarif?->tarif_per_jam ?? 0,0,',','.') }}</p></div>
                </div>
                @if($denda > 0)
                <div class="mt-3 pt-3 border-t border-red-500/30 flex justify-between items-center text-red-500">
                    <p class="text-xs uppercase font-bold tracking-wider">Denda Inap (>12 Jam)</p>
                    <p class="font-black">Rp {{ number_format($denda, 0, ',', '.') }}</p>
                </div>
                @endif
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-white/5 flex justify-between items-center">
                    <p class="text-slate-500 dark:text-white/60 text-sm">Total Biaya</p>
                    <p class="text-3xl font-black text-emerald-400">Rp {{ number_format($biaya,0,',','.') }}</p>
                </div>
            </div>

            <div>
                <label class="ft-label">Jumlah Dibayar (Rp)</label>
                <input wire:model.live="bayar" type="number" id="input-bayar"
                       class="ft-input text-xl font-bold text-center" style="padding:14px;font-size:1.25rem;"
                       placeholder="0" min="{{ $biaya }}" autofocus>
                @error('bayar')<p class="text-red-400 text-xs mt-1.5 text-center">{{ $message }}</p>@enderror
            </div>

            @if($bayar && (float)$bayar >= $biaya)
            <div class="rounded-xl p-4 text-center" style="background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);">
                <p class="text-slate-500 dark:text-white/50 text-sm">Kembalian</p>
                <p class="text-3xl font-black text-emerald-400">Rp {{ number_format(max(0,(float)$bayar - $biaya),0,',','.') }}</p>
            </div>
            @endif

            <div class="flex gap-3">
                <button @click="bayar()" wire:loading.attr="disabled" id="btn-proses-bayar"
                        class="btn-primary flex-1 justify-center py-3 border-none" style="background:linear-gradient(135deg,#059669,#10b981);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Proses Bayar
                </button>
                <button wire:click="resetForm" onclick="setTimeout(()=> window.location.reload(), 300)" class="btn-ghost py-3 px-5">Batal</button>
            </div>
        </div>
    </div>

    @elseif($step === 3 && $transaksi)
    @php $isKaryawan = $transaksi->id_kendaraan && $biaya == 0; @endphp
    <div class="ft-card p-8 text-center space-y-4">
        @if($isKaryawan)
        {{-- Karyawan farewell --}}
        <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto"
             style="background:rgba(99,102,241,0.15);border:2px solid rgba(99,102,241,0.4);">
            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
        </div>
        <div>
            <p class="text-indigo-400 text-xs font-black uppercase tracking-widest mb-1">Akses Karyawan ✓</p>
            <h2 class="text-slate-900 dark:text-white font-black text-2xl">Selamat Jalan, {{ $transaksi->kendaraan->pemilik ?? 'Karyawan' }}!</h2>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-1">{{ $transaksi->kendaraan->plat_nomor }} · {{ $durasi }} Jam · GRATIS</p>
        </div>
        <div class="rounded-xl p-4" style="background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);">
            <p class="text-emerald-500 font-bold text-lg">🎉 Biaya Parkir: GRATIS</p>
        </div>
        @else
        {{-- Regular payment --}}
        <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto" style="background:rgba(52,211,153,0.15);border:2px solid rgba(52,211,153,0.3);">
            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <h2 class="text-slate-900 dark:text-white font-black text-2xl">Pembayaran Berhasil! 🎉</h2>
            <p class="text-emerald-400 font-bold text-lg mt-1 italic font-mono">{{ $transaksi->kode_qr }}</p>
        </div>
        <div class="rounded-xl p-4 space-y-2" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
            <div class="flex justify-between text-sm"><span class="text-slate-500 dark:text-white/50">Biaya Parkir</span><span class="text-slate-900 dark:text-white font-semibold">Rp {{ number_format($biaya - $denda,0,',','.') }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-slate-500 dark:text-white/50">Durasi</span><span class="text-slate-900 dark:text-white font-semibold">{{ $durasi }} Jam</span></div>
            @if($denda > 0)
            <div class="flex justify-between text-sm text-red-500"><span class="font-semibold">Denda Inap</span><span class="font-bold">+ Rp {{ number_format($denda,0,',','.') }}</span></div>
            @endif
            <div class="flex justify-between text-sm border-t border-slate-200 dark:border-white/5 pt-2"><span class="text-slate-500 dark:text-white/50">Kembalian</span><span class="text-emerald-400 font-black text-lg">Rp {{ number_format($kembalian,0,',','.') }}</span></div>
        </div>
        @endif
        <div class="flex gap-3">
            <button onclick="window.print()" class="btn-ghost flex-1 py-3">Cetak Struk</button>
            <button wire:click="resetForm" onclick="setTimeout(()=> window.location.reload(), 300)" class="btn-primary flex-1 py-3 justify-center">Transaksi Berikutnya</button>
        </div>
    </div>
    @endif
</div>
