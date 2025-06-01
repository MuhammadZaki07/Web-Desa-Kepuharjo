<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pkk', 'karang_taruna']);
            $table->text('content');
            $table->json('structure');
            $table->json('programs');
            $table->json('activities');
            $table->string('contact_phone')->nullable();
            $table->index('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
