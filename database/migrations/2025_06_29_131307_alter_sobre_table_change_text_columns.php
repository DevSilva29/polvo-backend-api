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
        Schema::table('sobre', function (Blueprint $table) {
            // Aumenta o tamanho das colunas para MEDIUMTEXT (até 16MB de texto)
            $table->mediumText('sobre_text')->change();
            $table->mediumText('sobre_text2')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sobre', function (Blueprint $table) {
            //
        });
    }
};
