<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'tb_log_aktivitas';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'aktivitas',
        'waktu_aktivitas',
    ];

    protected function casts(): array
    {
        return [
            'waktu_aktivitas' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Write a log entry for the currently authenticated user
     */
    public static function catat(int $userId, string $aktivitas): self
    {
        return self::create([
            'id_user'          => $userId,
            'aktivitas'        => $aktivitas,
            'waktu_aktivitas'  => now(),
        ]);
    }
}
