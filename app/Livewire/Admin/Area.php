<?php

namespace App\Livewire\Admin;

use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use Livewire\Component;

class Area extends Component
{
    public $showModal     = false;
    public $editId        = null;
    public $nama_area     = '';
    public $kapasitas     = 0;
    public $terisi        = 0;
    public $confirmDelete = null;

    public function openCreate(): void
    {
        $this->reset(['editId', 'nama_area', 'kapasitas', 'terisi']);
        $this->showModal = true;
    }

    public function openEdit($id): void
    {
        $a = AreaParkir::findOrFail($id);
        $this->editId    = $id;
        $this->nama_area = $a->nama_area;
        $this->kapasitas = $a->kapasitas;
        $this->terisi    = $a->terisi;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1',
        ]);

        if ($this->editId) {
            $data = ['nama_area' => $this->nama_area, 'kapasitas' => $this->kapasitas];
            AreaParkir::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Area diperbarui.');
        } else {
            $data = ['nama_area' => $this->nama_area, 'kapasitas' => $this->kapasitas, 'terisi' => 0];
            AreaParkir::create($data);
            session()->flash('success', 'Area ditambahkan.');
        }

        LogAktivitas::catat(auth()->id(), 'Kelola area: ' . $this->nama_area);
        $this->showModal = false;
    }

    public function deleteArea($id): void
    {
        AreaParkir::findOrFail($id)->delete();
        LogAktivitas::catat(auth()->id(), 'Hapus area ID: ' . $id);
        session()->flash('success', 'Area dihapus.');
        $this->confirmDelete = null;
    }

    public function render()
    {
        $areas = AreaParkir::all();
        return view('livewire.admin.area', compact('areas'))
            ->layout('layouts.app.sidebar', ['title' => 'Area Parkir']);
    }
}
