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
        Schema::table('depoimentos', function (Blueprint $table) {
            // Comando para apagar a coluna
            $table->dropColumn('depoimentos_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('depoimentos', function (Blueprint $table) {
            // Comando para recriar a coluna, caso precisemos reverter
            $table->string('depoimentos_role')->nullable()->after('depoimentos_name');
        });
    }
};