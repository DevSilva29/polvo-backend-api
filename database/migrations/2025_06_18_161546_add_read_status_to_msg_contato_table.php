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
        Schema::table('msgContato', function (Blueprint $table) {
            // Adiciona uma coluna booleana chamada 'msgContato_read', com valor padrão 'false' (não lida)
            $table->boolean('msgContato_read')->default(false)->after('msgContato_msg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('msgContato', function (Blueprint $table) {
            //
        });
    }
};
