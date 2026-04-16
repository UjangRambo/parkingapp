<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_parkir');
            $table->string('kode_qr', 100)->unique();
            $table->integer('id_kendaraan')->nullable();
            $table->integer('id_area');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->integer('id_tarif')->nullable();
            $table->integer('durasi_jam')->nullable();
            $table->decimal('biaya_total', 10, 0)->nullable();
            $table->string('status', 20)->default('masuk'); // masuk, keluar
            $table->integer('id_user')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi');
    }
};
