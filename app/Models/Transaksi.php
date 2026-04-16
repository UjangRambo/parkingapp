<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_parkir';

    protected $fillable = [
        'kode_qr',
        'id_kendaraan',
        'id_area',
        'waktu_masuk',
        'waktu_keluar',
        'id_tarif',
        'durasi_jam',
        'biaya_total',
        'foto_masuk',
        'foto_keluar',
        'status',
        'id_user',
    ];

    protected function casts(): array
    {
        return [
            'waktu_masuk'  => 'datetime',
            'waktu_keluar' => 'datetime',
            'biaya_total'  => 'decimal:0',
        ];
    }

    /**
     * Calculate fee based on tarif and duration (rounds up to full hour)
     */
    public static function hitungBiaya(\Carbon\CarbonInterface $masuk, \Carbon\CarbonInterface $keluar, float $tarifPerJam): array
    {
        $durasiJam = (int) ceil($masuk->diffInMinutes($keluar) / 60);
        if ($durasiJam < 1) $durasiJam = 1;
        $biaya = $durasiJam * $tarifPerJam;
        
        $denda = 0;
        if ($durasiJam > 12) {
            // Denda progresif: Rp 10.000 dipukul rata untuk SETIAP jam kelebihan setelah lewat batas 12 jam.
            // Bisa juga diubah jadi proporsi base tarif: ($durasiJam - 12) * ($tarifPerJam * 1.5) jika dibutuhkan.
            $kelebihanJam = $durasiJam - 12;
            $denda = $kelebihanJam * 10000; 
            $biaya += $denda;
        }

        return [
            'durasi_jam'  => $durasiJam,
            'biaya_total' => $biaya,
            'denda'       => $denda,
        ];
    }

    /* ── Relationships ─────────────────────────────── */

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }

    public function areaParkir()
    {
        return $this->belongsTo(AreaParkir::class, 'id_area', 'id_area');
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
