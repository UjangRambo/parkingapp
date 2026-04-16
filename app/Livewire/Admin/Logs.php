<?php

namespace App\Livewire\Admin;

use App\Models\LogAktivitas as LogModel;
use Livewire\Component;
use Livewire\WithPagination;

class Logs extends Component
{
    use WithPagination;

    public string $search     = '';
    public string $filterRole = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterRole(): void { $this->resetPage(); }

    public function render()
    {
        $logs = LogModel::with('user')
            ->when($this->search, fn($q) =>
                $q->whereHas('user', fn($u) => $u->where('nama_lengkap', 'like', '%' . $this->search . '%'))
                  ->orWhere('aktivitas', 'like', '%' . $this->search . '%')
            )
            ->when($this->filterRole, fn($q) =>
                $q->whereHas('user', fn($u) => $u->where('role', $this->filterRole))
            )
            ->latest('waktu_aktivitas')
            ->paginate(20);

        return view('livewire.admin.logs', compact('logs'))
            ->layout('layouts.app.sidebar', ['title' => 'Log Aktivitas']);
    }
}
