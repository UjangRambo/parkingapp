<div class="space-y-5">
    <div>
        <h1 class="text-2xl font-black text-slate-900 dark:text-white">Log <span class="g-text">Aktivitas</span></h1>
        <p class="text-slate-500 dark:text-white/40 text-sm mt-0.5">Rekam jejak seluruh aktivitas pengguna sistem</p>
    </div>

    <div class="flex gap-3 flex-wrap">
        <div class="relative flex-1 min-w-48">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 dark:text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari pengguna atau aktivitas..." class="ft-input pl-9">
        </div>
        <select wire:model.live="filterRole" class="ft-input ft-select w-40">
            <option value="">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="owner">Owner</option>
        </select>
    </div>

    <div class="ft-card overflow-hidden">
        <table class="ft-table ft-table-responsive w-full">
            <thead><tr><th>#</th><th>Pengguna</th><th>Role</th><th>Aktivitas</th><th>Waktu</th></tr></thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr wire:key="{{ $log->id_log }}">
                    <td data-label="#" class="text-slate-500 dark:text-white/30 text-xs">{{ $logs->firstItem() + $i }}</td>
                    <td data-label="Pengguna">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold" style="background: rgba(99,102,241,0.15); color: #a5b4fc;">{{ $log->user?->initials() ?? '?' }}</div>
                            <span class="font-medium text-slate-500 dark:text-white/80">{{ $log->user?->nama_lengkap ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td data-label="Role" class="mobile-hidden">@if($log->user)<span class="role-badge-{{ $log->user->role }} px-2 py-0.5 rounded-full text-xs font-semibold">{{ ucfirst($log->user->role) }}</span>@endif</td>
                    <td data-label="Aktivitas" class="text-slate-500 dark:text-white/60">{{ $log->aktivitas }}</td>
                    <td data-label="Waktu">
                        <p class="text-slate-500 dark:text-white/60 text-xs">{{ $log->waktu_aktivitas->format('d M Y, H:i') }}</p>
                        <p class="text-slate-500 dark:text-white/30 text-xs">{{ $log->waktu_aktivitas->diffForHumans() }}</p>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-slate-500 dark:text-white/30 py-12">Belum ada log</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-slate-200 dark:border-white/5">{{ $logs->links() }}</div>
    </div>
</div>






