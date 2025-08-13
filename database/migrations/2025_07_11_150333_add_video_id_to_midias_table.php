<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('midias', function (Blueprint $table) {
            // Nova coluna para guardar apenas o ID do vídeo (ex: dQw4w9WgXcQ)
            $table->string('midia_video_id', 20)->nullable()->after('midia_platform');
        });
    }
    public function down(): void {
        Schema::table('midias', function (Blueprint $table) {
            $table->dropColumn('midia_video_id');
        });
    }
};