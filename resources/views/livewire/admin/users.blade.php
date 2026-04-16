<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Manajemen <span class="g-text">User</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Kelola akun pengguna sistem FastTrack</p>
        </div>
        <button wire:click="openCreate" class="btn-primary w-full sm:w-auto justify-center" id="btn-add-user">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah User
        </button>
    </div>

    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 dark:text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input wire:model.live.debounce.300ms="search" type="text" autocomplete="off" spellcheck="false" placeholder="Cari nama atau username..." class="ft-input pl-9">
    </div>

    <div class="ft-card overflow-hidden">
        <table class="ft-table ft-table-responsive">
            <thead>
                <tr><th>Pengguna</th><th>Username</th><th>Role</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr wire:key="user-{{ $user->id }}">
                    <td data-label="Pengguna">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold" style="background: rgba(99,102,241,0.15); color: #a5b4fc;">{{ $user->initials() }}</div>
                            <p class="font-semibold text-slate-500 dark:text-white/90">{{ $user->nama_lengkap }}</p>
                        </div>
                    </td>
                    <td data-label="Username" class="font-mono text-sm">{{ $user->username }}</td>
                    <td data-label="Role"><span class="role-badge-{{ $user->role }} px-2.5 py-1 rounded-full text-xs font-semibold">{{ ucfirst($user->role) }}</span></td>
                    <td data-label="Status"><span class="{{ $user->status_aktif ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td data-label="Aksi">
                        <div class="flex gap-2">
                            <button wire:click="openEdit({{ $user->id }})" class="btn-ghost text-xs py-1 px-3">Edit</button>
                            @if($user->id !== auth()->id())
                            <button wire:click="$set('confirmDelete', {{ $user->id }})" class="btn-danger text-xs py-1 px-3">Hapus</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-slate-500 dark:text-white/30 py-12">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($showModal)
    <div class="ft-modal-overlay" x-data @click.self="$wire.set('showModal', false)">
        <div class="ft-modal">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-slate-900 dark:text-white font-bold text-lg">{{ $editId ? 'Edit User' : 'Tambah User' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-slate-500 dark:text-white/30 hover:text-slate-500 dark:text-white/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="ft-label">Nama Lengkap</label>
                    <input wire:model="nama_lengkap" type="text" class="ft-input">
                    @error('nama_lengkap')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="ft-label">Username</label>
                    <input wire:model="username" type="text" class="ft-input">
                    @error('username')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="ft-label">Password {{ $editId ? '(kosongkan jika tidak diubah)' : '' }}</label>
                    <input wire:model="password" type="password" class="ft-input">
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="ft-label">Role</label>
                        <select wire:model="role" class="ft-input ft-select">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div>
                        <label class="ft-label">Status</label>
                        <select wire:model="status_aktif" class="ft-input ft-select">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button wire:click="save" class="btn-primary flex-1 justify-center">Simpan</button>
                    <button wire:click="$set('showModal', false)" class="btn-ghost flex-1 text-center">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($confirmDelete)
    <div class="ft-modal-overlay">
        <div class="ft-modal" style="max-width: 360px; text-align: center;">
            <h3 class="text-slate-900 dark:text-white font-bold mb-2">Hapus User?</h3>
            <p class="text-slate-500 dark:text-white/50 text-sm mb-5">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button wire:click="deleteUser({{ $confirmDelete }})" class="btn-danger flex-1 text-center">Hapus</button>
                <button wire:click="$set('confirmDelete', null)" class="btn-ghost flex-1 text-center">Batal</button>
            </div>
        </div>
    </div>
    @endif
</div>






