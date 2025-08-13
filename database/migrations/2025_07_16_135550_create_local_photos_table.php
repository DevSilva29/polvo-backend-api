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
        Schema::create('local_photos', function (Blueprint $table) {
            $table->id();
            $table->string('path'); // Caminho para o ficheiro da imagem
            $table->string('caption')->nullable(); // Legenda opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_photos');
    }
};
