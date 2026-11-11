<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->enum('tipo', ['PERDIDO', 'ENCONTRADO']);
            $table->string('titulo', 80);
            $table->text('descripcion');
            $table->unsignedTinyInteger('categoria_id');
            $table->unsignedSmallInteger('lugar_id');
            $table->string('lugar_detalle', 150)->nullable();
            $table->date('fecha_evento');
            $table->time('hora_evento');
            $table->string('custodia_actual', 100)->nullable();
            $table->enum('estado', ['ACTIVA', 'RESUELTA', 'INACTIVA', 'RETIRADA'])->default('ACTIVA');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_estado')->useCurrent();
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('lugar_id')->references('id')->on('lugares');
            $table->index(['estado', 'tipo', 'fecha_creacion'], 'idx_pub_listado');
            $table->index('fecha_evento', 'idx_pub_fecha_evento');
        });
        DB::statement("ALTER TABLE publicaciones ADD CONSTRAINT chk_custodia_hallazgo CHECK (tipo = 'PERDIDO' OR custodia_actual IS NOT NULL)");
    }
    public function down(): void {
        Schema::dropIfExists('publicaciones');
    }
};