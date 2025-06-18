<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->enum('type', [
                'pkk',
                'karang_taruna',
                'gallery',
                'kegiatan',
                'infrastruktur',
                'wisata'
            ])->default('gallery');
            $table->json('path');
            $table->date('event_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['type', 'is_featured']);
            $table->index('event_date');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
