<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 80);
            $table->string('apellidos', 80);
            $table->string('correo', 120)->unique();
            $table->string('telefono', 20);
            $table->string('password', 255);
            $table->string('programa_academico', 100);
            $table->string('codigo_estudiantil', 20)->nullable()->unique();
            $table->enum('rol', ['ESTUDIANTE', 'ADMINISTRADOR'])->default('ESTUDIANTE');
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamp('fecha_registro')->useCurrent();
        });
        DB::statement("ALTER TABLE usuarios ADD CONSTRAINT chk_correo_institucional CHECK (correo LIKE '%@uniautonoma.edu.co')");
    }
    public function down(): void {
        Schema::dropIfExists('usuarios');
    }
};