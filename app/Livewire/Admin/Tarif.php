<?php

namespace App\Livewire\Admin;

use App\Models\Tarif as TarifModel;
use App\Models\LogAktivitas;
use Livewire\Component;

class Tarif extends Component
{
    public $showModal       = false;
    public $editId          = null;
    public $jenis_kendaraan = 'motor';
    public $tarif_per_jam   = '';
    public $confirmDelete   = null;

    public function openCreate(): void
    {
        $this->reset(['editId', 'jenis_kendaraan', 'tarif_per_jam']);
        $this->jenis_kendaraan = '';
        $this->showModal = true;
    }

    public function openEdit($id): void
    {
        $t = TarifModel::findOrFail($id);
        $this->editId          = $id;
        $this->jenis_kendaraan = $t->jenis_kendaraan;
        $this->tarif_per_jam   = (string) $t->tarif_per_jam;
        $this->showModal       = true;
    }

    public function save(): void
    {
        $this->validate([
            'jenis_kendaraan' => 'required|string|max:20',
            'tarif_per_jam'   => 'required|numeric|min:0',
        ]);

        $data = ['jenis_kendaraan' => $this->jenis_kendaraan, 'tarif_per_jam' => $this->tarif_per_jam];

        if ($this->editId) {
            TarifModel::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Tarif diperbarui.');
        } else {
            TarifModel::create($data);
            session()->flash('success', 'Tarif ditambahkan.');
        }

        LogAktivitas::catat(auth()->id(), 'Kelola tarif: ' . $this->jenis_kendaraan);
        $this->showModal = false;
    }

    public function deleteTarif($id): void
    {
        TarifModel::findOrFail($id)->delete();
        LogAktivitas::catat(auth()->id(), 'Hapus tarif ID: ' . $id);
        session()->flash('success', 'Tarif dihapus.');
        $this->confirmDelete = null;
    }

    public function render()
    {
        $tarifs = TarifModel::latest()->get();
        return view('livewire.admin.tarif', compact('tarifs'))
            ->layout('layouts.app.sidebar', ['title' => 'Tarif Parkir']);
    }
}
