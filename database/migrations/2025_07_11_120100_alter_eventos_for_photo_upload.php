<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('eventos_icon'); // Apaga a coluna antiga de ícones
            $table->string('eventos_photo')->nullable()->after('eventos_date'); // Adiciona a nova coluna para fotos
        });
    }

    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('eventos_photo'); // Desfaz a alteração
            $table->string('eventos_icon')->after('eventos_date'); // Adiciona a coluna antiga de volta
        });
    }
};
