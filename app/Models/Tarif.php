<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tb_tarif';
    protected $primaryKey = 'id_tarif';

    protected $fillable = [
        'jenis_kendaraan',
        'tarif_per_jam',
    ];

    protected function casts(): array
    {
        return [
            'tarif_per_jam' => 'decimal:0',
        ];
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_tarif', 'id_tarif');
    }
}
