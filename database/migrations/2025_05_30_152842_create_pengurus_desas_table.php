<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengurus_desas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('jabatan', [
                'kepala_desa',
                'sekretaris_desa',
                'bendahara_desa',
                'kaur_keuangan',
                'kaur_umum',
                'kaur_pembangunan',
                'kasi_pemerintahan',
                'kasi_kesejahteraan',
                'kasi_pelayanan'
            ]);
            $table->boolean('is_wakil')->default(false)->comment('True jika jabatan wakil, false jika jabatan utama');
            $table->date('mulai_jabatan');
            $table->date('selesai_jabatan')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->text('tugas_pokok')->nullable();
            $table->timestamps();

            $table->index(['jabatan', 'is_wakil', 'is_aktif']);
            $table->index(['is_aktif', 'is_wakil']);
            $table->index('mulai_jabatan');

            $table->unique(['user_id', 'is_aktif'], 'unique_active_user');
            $table->unique(['jabatan', 'is_wakil', 'is_aktif'], 'unique_active_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus_desas');
    }
};
