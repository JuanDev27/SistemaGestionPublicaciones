<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('fotografias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('publicacion_id');
            $table->string('url_imagen', 500);
            $table->unsignedTinyInteger('orden')->default(1);
            $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade');
            $table->unique(['publicacion_id', 'orden'], 'uq_foto_orden');
        });
        DB::statement("ALTER TABLE fotografias ADD CONSTRAINT chk_foto_orden CHECK (orden BETWEEN 1 AND 3)");
    }
    public function down(): void {
        Schema::dropIfExists('fotografias');
    }
};