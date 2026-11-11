<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('conversacion_id');
            $table->unsignedInteger('remitente_id');
            $table->string('contenido', 1000);
            $table->timestamp('fecha_envio')->useCurrent();
            $table->foreign('conversacion_id')->references('id')->on('conversaciones')->onDelete('cascade');
            $table->foreign('remitente_id')->references('id')->on('usuarios');
            $table->index(['conversacion_id', 'fecha_envio'], 'idx_msg_orden');
        });
    }
    public function down(): void {
        Schema::dropIfExists('mensajes');
    }
};