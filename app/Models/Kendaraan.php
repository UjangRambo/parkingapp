<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'tb_kendaraan';
    protected $primaryKey = 'id_kendaraan';

    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
        'kode_kartu',
    ];

    /** True jika kendaraan ini milik karyawan (memiliki kartu parkir) */
    public function isKaryawan(): bool
    {
        return !empty($this->kode_kartu);
    }

    /** Generate kode kartu unik format KRY-XXXXX */
    public static function generateKodeKartu(): string
    {
        do {
            $kode = 'KRY-' . strtoupper(Str::random(5));
        } while (self::where('kode_kartu', $kode)->exists());

        return $kode;
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_kendaraan', 'id_kendaraan');
    }
}
