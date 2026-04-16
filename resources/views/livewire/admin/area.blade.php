<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Area <span class="g-text">Parkir</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Kelola zona dan kapasitas area parkir</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Area
        </button>
    </div>

    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($areas as $area)
        @php
            $pct = $area->kapasitas > 0 ? round(($area->terisi/$area->kapasitas)*100) : 0;
            $color = $pct >= 90 ? '#f87171' : ($pct >= 70 ? '#fb923c' : '#34d399');
        @endphp
        <div class="ft-card p-5" wire:key="area-{{ $area->id_area }}">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-slate-900 dark:text-white font-bold">{{ $area->nama_area }}</p>
                    <p class="text-slate-500 dark:text-white/40 text-xs mt-0.5">{{ $area->kapasitas }} slot total</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-black" style="color: {{ $color }}">{{ $pct }}%</p>
                </div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between text-xs mb-1.5">
                    <span class="text-slate-500 dark:text-white/40">{{ $area->terisi }} terisi</span>
                    <span style="color: {{ $color }}">{{ max(0, $area->kapasitas - $area->terisi) }} tersedia</span>
                </div>
                <div class="h-2 rounded-full" style="background: rgba(255,255,255,0.06);">
                    <div class="h-2 rounded-full" style="width: {{ $pct }}%; background: {{ $color }};"></div>
                </div>
            </div>
            <div class="flex gap-2">
                <button wire:click="openEdit({{ $area->id_area }})" class="btn-ghost text-xs py-1 flex-1 text-center">Edit</button>
                <button wire:click="$set('confirmDelete', {{ $area->id_area }})" class="btn-danger text-xs py-1 flex-1 text-center">Hapus</button>
            </div>
        </div>
        @endforeach
    </div>

    @if($showModal)
    <div class="ft-modal-overlay" x-data @click.self="$wire.set('showModal',false)">
        <div class="ft-modal" style="max-width: 400px;">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg">{{ $editId ? 'Edit Area' : 'Tambah Area' }}</h3>
                <button wire:click="$set('showModal',false)" class="text-slate-500 dark:text-white/30 hover:text-slate-500 dark:text-white/60"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="ft-label">Nama Area</label>
                    <input wire:model="nama_area" type="text" class="ft-input" placeholder="Lantai 1 - Blok A">
                    @error('nama_area')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="ft-label">Kapasitas Maksimal Kendaraan</label>
                    <input wire:model="kapasitas" type="number" class="ft-input" min="1">
                    @error('kapasitas')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
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
            <h3 class="text-slate-900 dark:text-white font-bold mb-2">Hapus Area?</h3>
            <p class="text-slate-500 dark:text-white/50 text-sm mb-5">Area ini akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button wire:click="deleteArea({{ $confirmDelete }})" class="btn-danger flex-1 text-center">Hapus</button>
                <button wire:click="$set('confirmDelete',null)" class="btn-ghost flex-1 text-center">Batal</button>
            </div>
        </div>
    </div>
    @endif
</div>






