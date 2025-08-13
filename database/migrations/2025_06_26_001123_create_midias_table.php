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
        Schema::create('midias', function (Blueprint $table) {
            $table->id('midia_id');
            $table->string('midia_title');
            $table->string('midia_link');
            $table->enum('midia_platform', ['youtube', 'vimeo']);
            $table->text('midia_description')->nullable();
            // Laravel adicionará 'created_at' e 'updated_at' automaticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midias');
    }
};
