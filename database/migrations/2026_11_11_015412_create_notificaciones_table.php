<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('usuario_id');
            $table->unsignedBigInteger('mensaje_id');
            $table->boolean('leida')->default(0);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('mensaje_id')->references('id')->on('mensajes')->onDelete('cascade');
            $table->index(['usuario_id', 'leida'], 'idx_not_pendientes');
        });
    }
    public function down(): void {
        Schema::dropIfExists('notificaciones');
    }
};