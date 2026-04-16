<div class="max-w-2xl mx-auto space-y-5">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(234,88,12,0.1); border: 1px solid rgba(234,88,12,0.25);">
            <svg class="w-5 h-5 text-orange-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Gate <span class="g-text">Masuk</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm">Scan kartu karyawan atau tekan tombol untuk cetak tiket pengunjung</p>
        </div>
    </div>

    @if(session()->has('error'))
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl text-center font-bold">
            {{ session('error') }}
        </div>
    @endif

    @if($step === 1)
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <div x-data="{
        tab: 'pengunjung',
        scanning: false,
        _qr: null,

        async startScanner() {
            if (this.scanning) return;
            const el = document.getElementById('qr-masuk-reader');
            if (!el) return;
            if (typeof Html5Qrcode === 'undefined') {
                setTimeout(() => this.startScanner(), 500);
                return;
            }
            try {
                if (!this._qr) this._qr = new Html5Qrcode('qr-masuk-reader');
                await this._qr.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 220, height: 220 } },
                    async (kode) => {
                        await this.stopScanner();
                        await $wire.scanDariKamera(kode);
                    },
                    () => {}
                );
                this.scanning = true;
            } catch (err) {
                try {
                    await this._qr.start(
                        { facingMode: 'user' },
                        { fps: 10, qrbox: { width: 220, height: 220 } },
                        async (kode) => {
                            await this.stopScanner();
                            await $wire.scanDariKamera(kode);
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
                try { await this._qr.stop(); } catch(e) {}
                this.scanning = false;
            }
        },

        async capture(jenis) {
            const base64 = window.ftWebcam && this.$refs.video ? window.ftWebcam.capture(this.$refs.video) : null;
            await $wire.set('foto_capture', base64);
            await $wire.submitKendaraan(jenis);
        },

        async initWebcam() {
            if (window.ftWebcam && this.$refs.video) {
                await window.ftWebcam.start(this.$refs.video);
            }
        }
    }"
    x-init="
        initWebcam();
        $watch('tab', async (val) => {
            if (val === 'karyawan') {
                await stopScanner();
                setTimeout(() => startScanner(), 300);
            } else {
                await stopScanner();
                initWebcam();
            }
        });
    ">
    <div class="ft-card p-6 space-y-5">

        {{-- Tab Selector --}}
        <div class="flex gap-2 p-1.5 rounded-xl bg-slate-100 dark:bg-white/5 overflow-x-auto">
            <button @click="tab = 'pengunjung'"
                    :class="tab === 'pengunjung' ? 'bg-white dark:bg-[#12121e] shadow-sm text-slate-900 dark:text-white font-semibold' : 'text-slate-500 dark:text-white/50 hover:text-slate-700 dark:hover:text-white/80'"
                    class="flex-1 py-2 px-3 rounded-lg text-sm transition-all focus:outline-none min-w-max">
                🎫 Pengunjung
            </button>
            <button @click="tab = 'karyawan'"
                    :class="tab === 'karyawan' ? 'bg-white dark:bg-[#12121e] shadow-sm text-slate-900 dark:text-white font-semibold' : 'text-slate-500 dark:text-white/50 hover:text-slate-700 dark:hover:text-white/80'"
                    class="flex-1 py-2 px-3 rounded-lg text-sm transition-all focus:outline-none min-w-max">
                🪪 Kartu Karyawan
            </button>
        </div>

        {{-- Tab: Kartu Karyawan (QR Scanner) --}}
        <div x-show="tab === 'karyawan'" style="display:none;" class="space-y-4">
            <div class="text-center mb-2">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3"
                     style="background:rgba(99,102,241,0.1);border:1.5px dashed rgba(99,102,241,0.35);">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 18.75h.75v.75h-.75v-.75zM18.75 13.5h.75v.75h-.75v-.75zM18.75 18.75h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                    </svg>
                </div>
                <p class="text-slate-900 dark:text-white font-bold text-sm">Scan Kartu Parkir Karyawan</p>
                <p class="text-slate-500 dark:text-white/40 text-xs mt-0.5">Arahkan kamera ke QR Code pada kartu fisik karyawan</p>
            </div>
            <div class="relative">
                <div id="qr-masuk-reader" class="rounded-xl overflow-hidden bg-slate-900" style="min-height:220px;"></div>
                <div x-show="scanning" class="absolute top-2 right-2 flex items-center gap-1.5 bg-black/60 rounded-full px-2 py-1" x-cloak>
                    <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-white text-[9px] font-bold uppercase tracking-wider">Scanning…</span>
                </div>
            </div>
            <p x-show="!scanning && tab === 'karyawan'" class="text-amber-400 text-xs text-center" x-cloak>Memulai kamera…</p>
            <div x-show="scanning" class="flex items-center gap-2 justify-center pt-1" x-cloak>
                <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                <p class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Scanner Aktif</p>
            </div>
        </div>

        {{-- Tab: Pengunjung (Webcam + Tombol) --}}
        <div x-show="tab === 'pengunjung'" class="space-y-4">
            {{-- Webcam Preview --}}
            <div class="ft-card overflow-hidden relative w-full h-56 md:h-64 bg-slate-800 flex items-center justify-center group">
                <video x-ref="video" autoplay playsinline class="w-full h-full object-cover"></video>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent pointer-events-none"></div>
                <div class="absolute bottom-3 left-3 flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-white/80 text-[10px] font-bold tracking-widest uppercase">Live Security Feed</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-{{ count($tarifs) > 1 ? count($tarifs) : 1 }} gap-4">
                @foreach($tarifs as $t)
                @php
                    $j = strtolower($t->jenis_kendaraan);
                    $isMotor = $j === 'motor';
                    $isMobil = $j === 'mobil';
                    $tersedia = $isMotor ? $totalMotorTersedia : $totalUmumTersedia;
                    if ($isMotor) {
                        $c_text='text-indigo-400'; $c_bg1='rgba(99,102,241,0.05)'; $c_bg2='rgba(99,102,241,0.15)';
                        $c_border='rgba(99,102,241,0.2)'; $c_circle='rgba(99,102,241,0.2)'; $c_sub='text-indigo-200/60';
                        $svg='<path stroke-linecap="round" stroke-linejoin="round" d="M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.628 2.25 12 12.674h5.25l-2.659 2.849m-2.048 2.194L9.257 13.5m0 0h5.25"/>';
                    } elseif ($isMobil) {
                        $c_text='text-blue-400'; $c_bg1='rgba(59,130,246,0.05)'; $c_bg2='rgba(59,130,246,0.15)';
                        $c_border='rgba(59,130,246,0.2)'; $c_circle='rgba(59,130,246,0.2)'; $c_sub='text-blue-200/60';
                        $svg='<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>';
                    } else {
                        $c_text='text-amber-500'; $c_bg1='rgba(245,158,11,0.05)'; $c_bg2='rgba(245,158,11,0.15)';
                        $c_border='rgba(245,158,11,0.2)'; $c_circle='rgba(245,158,11,0.2)'; $c_sub='text-amber-200/60';
                        $svg='<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>';
                    }
                @endphp
                <button @click="capture('{{ $j }}')" wire:loading.attr="disabled"
                        class="ft-card group text-center flex flex-col items-center justify-center py-10 px-6 transition-all hover:-translate-y-1 hover:shadow-2xl disabled:opacity-50"
                        style="background:linear-gradient(135deg,{{ $c_bg1 }},{{ $c_bg2 }});border-color:{{ $c_border }};">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mb-3 transition-transform group-hover:scale-110" style="background:{{ $c_circle }};">
                        <svg class="w-8 h-8 {{ $c_text }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $svg !!}</svg>
                    </div>
                    <h2 class="text-slate-900 dark:text-white font-black text-xl mb-0.5 uppercase">{{ $t->jenis_kendaraan }}</h2>
                    <p class="text-slate-500 dark:{{ $c_sub }} text-xs font-medium">Tersedia: {{ $tersedia }} Slot</p>
                </button>
                @endforeach
            </div>
        </div>

    </div>{{-- /ft-card --}}
    </div>{{-- /x-data --}}

    @elseif($step === 2 && $newTransaksi)
    <div class="ft-card p-6" style="border-color:rgba(52,211,153,0.3);">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(52,211,153,0.15);border:1px solid rgba(52,211,153,0.3);">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-emerald-400 font-bold">Tiket Berhasil Dibuat!</p>
                <p class="text-slate-500 dark:text-white/40 text-xs">Silakan cetak dan berikan ke pengendara</p>
            </div>
        </div>

        <div class="rounded-2xl p-6 mb-5" id="printable-ticket"
             :style="isDarkMode
                ? 'background:linear-gradient(135deg,#12121e,#0d0d1a);border:1px dashed rgba(255,255,255,0.1);'
                : 'background:#fff7ed;border:1px solid rgba(249,115,22,0.25);'">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                         :style="isDarkMode ? 'background:linear-gradient(135deg,#6366f1,#3b82f6);' : 'background:linear-gradient(135deg,#ea580c,#dc2626);'">
                        <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-white" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <span class="text-slate-900 dark:text-white font-bold text-sm">FastTrack</span>
                </div>
                <span class="badge-masuk">AKTIF</span>
            </div>
            
            <div class="flex justify-center mb-4">
                <div class="bg-white rounded-xl p-3">
                    <div id="qr-code-display" style="width:160px;height:160px;"
                         x-data
                         x-init="
                            setTimeout(() => {
                                if (typeof QRCode !== 'undefined') {
                                    $el.innerHTML = '';
                                    new QRCode($el, {
                                        text: '{{ $newTransaksi->kode_qr }}',
                                        width: 160,
                                        height: 160,
                                        colorDark: '#1e293b',
                                        colorLight: '#ffffff',
                                        correctLevel: QRCode.CorrectLevel.M
                                    });
                                } else {
                                    console.error('QRCode library is not loaded');
                                }
                            }, 50);
                         ">
                    </div>
                </div>
            </div>
            
            <p class="text-center text-slate-900 dark:text-white font-black text-lg font-mono tracking-widest mb-4">{{ $newTransaksi->kode_qr }}</p>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div><p class="text-slate-500 dark:text-white/30 text-xs mb-0.5">Waktu Masuk</p><p class="text-slate-900 dark:text-white font-bold">{{ $newTransaksi->waktu_masuk->format('d M Y - H:i') }} WIB</p></div>
                <div><p class="text-slate-500 dark:text-white/30 text-xs mb-0.5">Jenis</p><p class="text-slate-900 dark:text-white font-semibold capitalize">{{ ucfirst($newTransaksi->jenis_kendaraan_label ?? '—') }}</p></div>
                <div class="col-span-2"><p class="text-slate-500 dark:text-white/30 text-xs mb-0.5">Area Parkir</p><p class="text-slate-900 dark:text-white font-black text-lg">{{ $newTransaksi->areaParkir->nama_area }}</p></div>
            </div>
            <p class="text-center text-slate-500 dark:text-white/30 text-xs mt-4">Simpan tiket ini untuk scan keluar</p>
        </div>

        <div class="flex gap-3">
            <button onclick="window.print()" class="btn-primary flex-1 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659"/></svg>
                Cetak Tiket
            </button>
            <button wire:click="resetForm" class="btn-ghost flex-1 text-center">Kendaraan Berikutnya</button>
        </div>
    </div>

    {{-- ─────── STEP 3: Karyawan Welcome ─────── --}}
    @elseif($step === 3 && $newTransaksi)
    <div class="ft-card p-6 text-center"
         :style="isDarkMode ? 'border-color:rgba(99,102,241,0.4)' : 'border-color:rgba(234,88,12,0.3)'">
        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5 relative"
             :style="isDarkMode
                ? 'background:rgba(99,102,241,0.15);border:2px solid rgba(99,102,241,0.4);'
                : 'background:rgba(234,88,12,0.1);border:2px solid rgba(234,88,12,0.3);'">
            <svg class="w-10 h-10 text-orange-500 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <span class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            </span>
        </div>

        <p class="text-orange-500 dark:text-indigo-400 text-xs font-black uppercase tracking-widest mb-1">Akses Karyawan ✓</p>
        <h2 class="text-slate-900 dark:text-white font-black text-3xl mb-1">{{ $newTransaksi->kendaraan->pemilik ?? 'Karyawan' }}</h2>
        <p class="text-slate-500 dark:text-white/40 text-sm mb-5">Selamat Datang! Parkir gratis untuk Anda.</p>

        <div class="grid grid-cols-3 gap-3 mb-5 text-left">
            <div class="bg-slate-100 dark:bg-white/5 rounded-xl p-3">
                <p class="text-slate-500 dark:text-white/30 text-[10px] uppercase mb-0.5">Plat</p>
                <p class="text-slate-900 dark:text-white font-bold font-mono text-sm">{{ $newTransaksi->kendaraan->plat_nomor ?? '—' }}</p>
            </div>
            <div class="bg-slate-100 dark:bg-white/5 rounded-xl p-3">
                <p class="text-slate-500 dark:text-white/30 text-[10px] uppercase mb-0.5">Jenis</p>
                <p class="text-slate-900 dark:text-white font-bold capitalize text-sm">{{ $newTransaksi->kendaraan->jenis_kendaraan ?? '—' }}</p>
            </div>
            <div class="bg-slate-100 dark:bg-white/5 rounded-xl p-3">
                <p class="text-slate-500 dark:text-white/30 text-[10px] uppercase mb-0.5">Area</p>
                <p class="text-slate-900 dark:text-white font-bold text-sm">{{ $newTransaksi->areaParkir->nama_area }}</p>
            </div>
        </div>

        <div class="rounded-xl p-3 mb-5" style="background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);">
            <p class="text-emerald-500 font-bold text-sm">🎉 Biaya Parkir: <span class="text-lg">GRATIS</span></p>
            <p class="text-white/30 text-[10px] mt-0.5">Tunjukkan kartu karyawan saat keluar</p>
        </div>

        <button wire:click="resetForm" class="btn-primary w-full justify-center">
            Kendaraan Berikutnya ›
        </button>
    </div>
    @endif
</div>
