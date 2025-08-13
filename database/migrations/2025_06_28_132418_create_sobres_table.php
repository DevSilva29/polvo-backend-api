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
        Schema::create('sobre', function (Blueprint $table) {
            $table->id('sobre_id');
            $table->text('sobre_text');
            $table->text('sobre_text2');
            $table->string('sobre_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sobres');
    }
};
