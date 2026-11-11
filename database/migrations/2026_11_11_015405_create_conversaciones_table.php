<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('publicacion_id');
            $table->unsignedInteger('iniciador_id');
            $table->enum('estado', ['ACTIVA', 'SOLO_LECTURA'])->default('ACTIVA');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade');
            $table->foreign('iniciador_id')->references('id')->on('usuarios');
            $table->unique(['publicacion_id', 'iniciador_id'], 'uq_conv');
        });
    }
    public function down(): void {
        Schema::dropIfExists('conversaciones');
    }
};