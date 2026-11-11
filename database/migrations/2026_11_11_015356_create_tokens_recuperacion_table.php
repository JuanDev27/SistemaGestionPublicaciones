<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tokens_recuperacion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->char('token_hash', 64)->unique();
            $table->dateTime('fecha_expiracion');
            $table->boolean('usado')->default(0);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('tokens_recuperacion');
    }
};