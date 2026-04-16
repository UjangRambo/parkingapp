<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Kendaraan <span class="g-text">Karyawan</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Registri kendaraan berlangganan & kartu parkir karyawan</p>
        </div>
        <button wire:click="openCreate" class="btn-primary w-full sm:w-auto justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Karyawan
        </button>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 rounded-xl text-sm font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20">
        ✓ {{ session('success') }}
    </div>
    @endif

    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 dark:text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari plat nomor atau nama pemilik..." class="ft-input pl-9">
    </div>

    <div class="ft-card overflow-hidden">
        <table class="ft-table ft-table-responsive w-full">
            <thead><tr><th>Pemilik</th><th>Plat Nomor</th><th>Jenis</th><th>Warna</th><th>Status Kartu</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kendaraans as $k)
                <tr wire:key="{{ $k->id_kendaraan }}">
                    <td data-label="Pemilik" class="font-semibold text-slate-900 dark:text-white">{{ $k->pemilik ?: '—' }}</td>
                    <td data-label="Plat"><span class="font-mono font-bold text-slate-500 dark:text-white/90 tracking-wider">{{ $k->plat_nomor }}</span></td>
                    <td data-label="Jenis">
                        @php $jc=['motor'=>'text-blue-400','mobil'=>'text-violet-400','lainnya'=>'text-orange-400']; @endphp
                        <span class="{{ $jc[$k->jenis_kendaraan]??'text-slate-500 dark:text-white/60' }} font-semibold">{{ ucfirst($k->jenis_kendaraan) }}</span>
                    </td>
                    <td data-label="Warna" class="text-slate-500 dark:text-white/60 capitalize mobile-hidden">{{ $k->warna ?: '—' }}</td>
                    <td data-label="Kartu">
                        @if($k->kode_kartu)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Kartu Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full text-slate-500 dark:text-white/40 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10">
                                Belum Ada Kartu
                            </span>
                        @endif
                    </td>
                    <td data-label="Aksi">
                        <div class="flex gap-2 flex-wrap">
                            <button wire:click="generateKartu({{ $k->id_kendaraan }})"
                                    class="text-xs py-1 px-3 rounded-lg font-semibold transition-all
                                    {{ $k->kode_kartu
                                        ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/20 hover:bg-indigo-100'
                                        : 'text-violet-700 dark:text-violet-400 bg-violet-50 dark:bg-violet-500/10 border border-violet-200 dark:border-violet-500/20 hover:bg-violet-100' }}">
                                {{ $k->kode_kartu ? '🪪 Lihat Kartu' : '✨ Generate Kartu' }}
                            </button>
                            <button wire:click="openEdit({{ $k->id_kendaraan }})" class="btn-ghost text-xs py-1 px-3">Edit</button>
                            @if($k->kode_kartu)
                            <button wire:click="revokeKartu({{ $k->id_kendaraan }})"
                                    wire:confirm="Cabut kartu parkir karyawan ini?"
                                    class="text-xs py-1 px-3 rounded-lg font-semibold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-500/20 hover:bg-orange-100 transition-all">Cabut</button>
                            @endif
                            <button wire:click="$set('confirmDelete', {{ $k->id_kendaraan }})" class="btn-danger text-xs py-1 px-3">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-slate-500 dark:text-white/30 py-10">Belum ada data kendaraan karyawan</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-slate-200 dark:border-white/5">{{ $kendaraans->links() }}</div>
    </div>

    {{-- Modal Tambah/Edit --}}
    @if($showModal)
    <div class="ft-modal-overlay" x-data @click.self="$wire.set('showModal',false)">
        <div class="ft-modal">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg">{{ $editId ? 'Edit Kendaraan' : 'Tambah Kendaraan Karyawan' }}</h3>
                <button wire:click="$set('showModal',false)" class="text-slate-500 dark:text-white/30 hover:text-slate-500 dark:text-white/60"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="ft-label">Nama Pemilik (Karyawan)</label>
                    <input wire:model="pemilik" type="text" class="ft-input" placeholder="Nama Lengkap Karyawan">
                    @error('pemilik')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="ft-label">Plat Nomor</label>
                        <input wire:model="plat_nomor" type="text" class="ft-input font-mono uppercase" placeholder="B 1234 FT">
                        @error('plat_nomor')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="ft-label">Jenis</label>
                        <input wire:model="jenis_kendaraan" type="text" class="ft-input" placeholder="Mobil / Motor / Bus">
                    </div>
                </div>
                <div>
                    <label class="ft-label">Warna</label>
                    <input wire:model="warna" type="text" class="ft-input" placeholder="Hitam">
                </div>
                <div class="flex gap-3 pt-1">
                    <button wire:click="save" class="btn-primary flex-1 justify-center">Simpan</button>
                    <button wire:click="$set('showModal',false)" class="btn-ghost flex-1 text-center">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Preview Kartu Parkir --}}
    @if($showKartuModal)
    <div class="ft-modal-overlay" x-data @click.self="$wire.set('showKartuModal',false)">
        <div class="ft-modal" style="max-width:380px;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg">🪪 Kartu Parkir Karyawan</h3>
                <button wire:click="$set('showKartuModal',false)" class="text-slate-500 dark:text-white/30 hover:text-slate-500 dark:text-white/60"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            {{-- Card Preview --}}
            <div class="rounded-2xl p-6 text-center mb-5" style="background:linear-gradient(135deg,#0d0d1a,#12121e);border:1px solid rgba(99,102,241,0.3);" id="employee-card-print">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,#6366f1,#3b82f6);">
                        <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-white" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <span class="text-white font-bold text-sm">FastTrack</span>
                    <span class="text-white/30 text-xs">|</span>
                    <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Karyawan</span>
                </div>

                {{-- QR Code --}}
                <div class="flex justify-center mb-4">
                    <div class="bg-white rounded-xl p-3">
                        <div id="employee-qr-display" style="width:140px;height:140px;"
                             x-data
                             x-init="
                                setTimeout(() => {
                                    if (typeof QRCode !== 'undefined') {
                                        $el.innerHTML = '';
                                        new QRCode($el, {
                                            text: '{{ $generatedKartu }}',
                                            width: 140,
                                            height: 140,
                                            colorDark: '#1e293b',
                                            colorLight: '#ffffff',
                                            correctLevel: QRCode.CorrectLevel.M
                                        });
                                    }
                                }, 80);
                             ">
                        </div>
                    </div>
                </div>

                <p class="text-white/40 text-[10px] uppercase tracking-widest mb-1">Nama Karyawan</p>
                <p class="text-white font-black text-lg mb-3">{{ $kartuNama }}</p>
                <p class="text-indigo-300 font-mono font-bold text-base tracking-widest">{{ $generatedKartu }}</p>
                <p class="text-white/20 text-[10px] mt-3">Scan kartu ini di Gate Masuk & Gate Keluar</p>
            </div>

            <button onclick="window.print()" class="btn-primary w-full justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.056 48.056 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/></svg>
                Cetak Kartu
            </button>
        </div>
    </div>
    @endif

    @if($confirmDelete)
    <div class="ft-modal-overlay">
        <div class="ft-modal" style="max-width: 340px; text-align: center;">
            <h3 class="text-slate-900 dark:text-white font-bold mb-2">Hapus Kendaraan?</h3>
            <p class="text-slate-500 dark:text-white/50 text-sm mb-5">Data dan kartu parkir karyawan ini akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button wire:click="deleteKendaraan({{ $confirmDelete }})" class="btn-danger flex-1 text-center">Hapus</button>
                <button wire:click="$set('confirmDelete',null)" class="btn-ghost flex-1 text-center">Batal</button>
            </div>
        </div>
    </div>
    @endif
</div>
