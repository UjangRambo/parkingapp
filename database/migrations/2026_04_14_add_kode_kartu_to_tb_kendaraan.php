<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_kendaraan', function (Blueprint $table) {
            $table->string('kode_kartu', 50)->nullable()->unique()->after('pemilik')
                  ->comment('Kode QR statis pada kartu parkir karyawan (format: KRY-XXXXX)');
        });
    }

    public function down(): void
    {
        Schema::table('tb_kendaraan', function (Blueprint $table) {
            $table->dropColumn('kode_kartu');
        });
    }
};
