<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Users extends Component
{
    public $showModal     = false;
    public $editId        = null;
    public $nama_lengkap  = '';
    public $username      = '';
    public $password      = '';
    public $role          = 'petugas';
    public $status_aktif  = true;
    public string $search        = '';
    public ?int   $confirmDelete = null;


    public function openCreate(): void
    {
        $this->reset(['editId', 'nama_lengkap', 'username', 'password']);
        $this->role        = 'petugas';
        $this->status_aktif = true;
        $this->showModal   = true;
    }

    public function openEdit($id): void
    {
        $user = User::findOrFail($id);
        $this->editId       = $id;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->username     = $user->username;
        $this->role         = $user->role;
        $this->status_aktif = $user->status_aktif ? 1 : 0;
        $this->password     = '';
        $this->showModal    = true;
    }

    public function save(): void
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:50',
            'role'         => 'required|in:admin,petugas,owner',
            'status_aktif' => 'boolean',
        ];

        if ($this->editId) {
            $rules['username'] = 'required|string|max:50|unique:users,username,' . $this->editId;
            $rules['password'] = 'nullable|string|min:6';
        } else {
            $rules['username'] = 'required|string|max:50|unique:users,username';
            $rules['password'] = 'required|string|min:6';
        }

        $this->validate($rules);

        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'username'     => $this->username,
            'role'         => $this->role,
            'status_aktif' => $this->status_aktif,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editId) {
            User::findOrFail($this->editId)->update($data);
            LogAktivitas::catat(auth()->id(), 'Update user: ' . $this->username);
            session()->flash('success', 'User berhasil diperbarui.');
        } else {
            User::create($data);
            LogAktivitas::catat(auth()->id(), 'Buat user baru: ' . $this->username);
            session()->flash('success', 'User berhasil ditambahkan.');
        }

        $this->showModal = false;
    }

    public function deleteUser($id): void
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Tidak dapat menghapus akun sendiri.');
            return;
        }

        $name = $user->username;
        $user->delete();
        LogAktivitas::catat(auth()->id(), 'Hapus user: ' . $name);
        session()->flash('success', 'User berhasil dihapus.');
        $this->confirmDelete = null;
    }

    public function render()
    {
        $users = User::when(
            $this->search,
            fn($q) => $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
        )->latest()->get();

        return view('livewire.admin.users', compact('users'))
            ->layout('layouts.app.sidebar', ['title' => 'Manajemen User']);
    }
}
