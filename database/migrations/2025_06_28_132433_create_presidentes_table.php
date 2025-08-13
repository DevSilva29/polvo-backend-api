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
    Schema::create('presidentes', function (Blueprint $table) {
        $table->id('presidentes_id');
        $table->string('presidentes_name');
        $table->string('presidentes_role');
        $table->string('presidentes_term');
        $table->string('presidentes_photo');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presidentes');
    }
};
