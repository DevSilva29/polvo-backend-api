<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('depoimentos', function (Blueprint $table) {
            // Adiciona a coluna de 'cargo' depois da coluna de nome
            $table->string('depoimentos_role')->nullable()->after('depoimentos_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('depoimentos', function (Blueprint $table) {
            //
        });
    }
};
