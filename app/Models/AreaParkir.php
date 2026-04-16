<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaParkir extends Model
{
    use HasFactory;

    protected $table = 'tb_area_parkir';
    protected $primaryKey = 'id_area';

    protected $fillable = [
        'nama_area',
        'kapasitas',
        'terisi',
        'jenis_khusus',
    ];

    /**
     * Get available slots
     */
    public function getAvailableAttribute(): int
    {
        return max(0, $this->kapasitas - $this->terisi);
    }

    /**
     * Get occupancy percentage
     */
    public function getOccupancyPercentAttribute(): float
    {
        if ($this->kapasitas === 0) return 0;
        return round(($this->terisi / $this->kapasitas) * 100, 1);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_area', 'id_area');
    }
}
