<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('contenido');
            $table->string('imagen')->nullable()->after('categoria');
            $table->string('lugar')->nullable()->after('imagen');
            $table->date('fecha_hallazgo')->nullable()->after('lugar');
            $table->boolean('encontrado')->default(true)->after('fecha_hallazgo');
        });
    }

    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            $table->dropColumn([
                'categoria',
                'imagen',
                'lugar',
                'fecha_hallazgo',
                'encontrado',
            ]);
        });
    }
};
