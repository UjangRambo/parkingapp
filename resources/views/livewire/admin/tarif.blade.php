<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Tarif <span class="g-text">Parkir</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Kelola tarif per jam berdasarkan jenis kendaraan</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Tarif
        </button>
    </div>

    <div class="grid sm:grid-cols-3 gap-4">
        @php $colorMap = ['motor'=>['bg'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.25)','text'=>'#60a5fa'],'mobil'=>['bg'=>'rgba(167,139,250,0.1)','border'=>'rgba(167,139,250,0.25)','text'=>'#a78bfa'],'lainnya'=>['bg'=>'rgba(251,146,60,0.1)','border'=>'rgba(251,146,60,0.25)','text'=>'#fb923c']]; @endphp
        @foreach($tarifs as $t)
        @php $c = $colorMap[$t->jenis_kendaraan] ?? $colorMap['lainnya']; @endphp
        <div class="ft-card p-5" wire:key="tarif-{{ $t->id_tarif }}">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background: {{ $c['bg'] }}; border: 1px solid {{ $c['border'] }};"></div>
            <p class="text-xs text-slate-500 dark:text-white/40 uppercase tracking-widest font-semibold mb-1">{{ ucfirst($t->jenis_kendaraan) }}</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">Rp {{ number_format($t->tarif_per_jam,0,',','.') }}</p>
            <p class="text-slate-500 dark:text-white/30 text-xs mt-1">per jam</p>
            <div class="flex gap-2 mt-4">
                <button wire:click="openEdit({{ $t->id_tarif }})" class="btn-ghost text-xs py-1 flex-1 text-center">Edit</button>
                <button wire:click="$set('confirmDelete', {{ $t->id_tarif }})" class="btn-danger text-xs py-1 flex-1 text-center">Hapus</button>
            </div>
        </div>
        @endforeach
    </div>

    @if($showModal)
    <div class="ft-modal-overlay" x-data @click.self="$wire.set('showModal',false)">
        <div class="ft-modal" style="max-width: 380px;">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg">{{ $editId ? 'Edit Tarif' : 'Tambah Tarif' }}</h3>
                <button wire:click="$set('showModal',false)" class="text-slate-500 dark:text-white/30 hover:text-slate-500 dark:text-white/60"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="ft-label">Jenis Kendaraan</label>
                    <input wire:model="jenis_kendaraan" type="text" class="ft-input" placeholder="Contoh: Truk, Minibus...">
                    @error('jenis_kendaraan')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="ft-label">Tarif per Jam (Rp)</label>
                    <input wire:model="tarif_per_jam" type="number" class="ft-input" placeholder="2000">
                    @error('tarif_per_jam')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-1">
                    <button wire:click="save" class="btn-primary flex-1 justify-center">Simpan</button>
                    <button wire:click="$set('showModal',false)" class="btn-ghost flex-1 text-center">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($confirmDelete)
    <div class="ft-modal-overlay">
        <div class="ft-modal" style="max-width: 340px; text-align: center;">
            <h3 class="text-slate-900 dark:text-white font-bold mb-2">Hapus Tarif?</h3>
            <p class="text-slate-500 dark:text-white/50 text-sm mb-5">Tarif ini akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button wire:click="deleteTarif({{ $confirmDelete }})" class="btn-danger flex-1 text-center">Hapus</button>
                <button wire:click="$set('confirmDelete',null)" class="btn-ghost flex-1 text-center">Batal</button>
            </div>
        </div>
    </div>
    @endif
</div>






