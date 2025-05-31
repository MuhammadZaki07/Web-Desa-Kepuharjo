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
        Schema::create('profile_desas', function (Blueprint $table) {
            $table->id();

            // Identitas Desa
            $table->binary('logo_desa')->nullable(); // Changed from binary to string (file path)
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('no_tlp')->nullable()->unique();
            $table->string('website')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('kode_pos', 10)->nullable();

            // Konten Desa
            $table->longText('sambutan_kepala_desa')->nullable();
            $table->string('motto_desa')->nullable();
            $table->longText('sejarah_desa')->nullable();
            $table->longText('program_unggulan')->nullable();

            // Visi Misi (JSON untuk multiple items)
            $table->json('visi')->nullable();
            $table->json('misi')->nullable();

            // Media Sosial
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('threads')->nullable(); // Fixed typo from 'threeads'

            // Timestamps
            $table->timestamps();

            // Indexes untuk performa
            $table->index(['email']);
            $table->index(['no_tlp']);
            $table->index(['name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_desas');
    }
};
