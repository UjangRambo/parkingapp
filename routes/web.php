<?php

use App\Http\Controllers\Owner\ExportController;
use Illuminate\Support\Facades\Route;

/* ── Public ──────────────────────────────────────────── */
Route::view('/', 'welcome')->name('home');

/* ── Admin ───────────────────────────────────────────── */
Route::middleware(['auth', 'user.active', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::livewire('dashboard', 'admin.dashboard')->name('dashboard');
        Route::livewire('users',     'admin.users')->name('users');
        Route::livewire('tarif',     'admin.tarif')->name('tarif');
        Route::livewire('area',      'admin.area')->name('area');
        Route::livewire('kendaraan', 'admin.kendaraan')->name('kendaraan');
        Route::livewire('logs',      'admin.logs')->name('logs');
    });

/* ── Petugas ─────────────────────────────────────────── */
Route::middleware(['auth', 'user.active', 'role:petugas,admin'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::livewire('dashboard',   'petugas.dashboard')->name('dashboard');
        Route::livewire('gate-masuk',  'petugas.gate-masuk')->name('gate-masuk');
        Route::livewire('gate-keluar', 'petugas.gate-keluar')->name('gate-keluar');
        Route::livewire('kendaraan-aktif',  'petugas.kendaraan-aktif')->name('kendaraan-aktif');
        Route::livewire('kendaraan-keluar', 'petugas.kendaraan-keluar')->name('kendaraan-keluar');
    });

/* ── Owner ───────────────────────────────────────────── */
Route::middleware(['auth', 'user.active', 'role:owner,admin'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::livewire('dashboard', 'owner.dashboard')->name('dashboard');
        Route::livewire('rekap',     'owner.rekap')->name('rekap');
        Route::get('export/csv', [ExportController::class, 'csv'])->name('export.csv');
        Route::get('export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
    });


/* ── Generic Auth Dashboard (redirect by role) ────────── */
Route::middleware(['auth', 'user.active'])->group(function () {
    Route::get('dashboard', function () {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            'owner'   => redirect()->route('owner.dashboard'),
            default   => redirect()->route('home'),
        };
    })->name('dashboard');
});

require __DIR__.'/settings.php';
