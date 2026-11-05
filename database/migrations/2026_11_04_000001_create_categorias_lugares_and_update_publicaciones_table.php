<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::create('lugares', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        $now = now();

        DB::table('categorias')->insert(array_map(fn ($nombre) => [
            'nombre' => $nombre,
            'created_at' => $now,
            'updated_at' => $now,
        ], [
            'Electrónica',
            'Documentos',
            'Llaves',
            'Ropa y accesorios',
            'Mochilas y bolsos',
            'Otros',
        ]));

        DB::table('lugares')->insert(array_map(fn ($nombre) => [
            'nombre' => $nombre,
            'created_at' => $now,
            'updated_at' => $now,
        ], [
            'Biblioteca',
            'Cafetería',
            'Bloques académicos',
            'Laboratorios',
            'Zonas deportivas',
            'Parqueadero',
            'Otra',
        ]));

        Schema::table('publicaciones', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('titulo');
            $table->foreignId('categoria_id')->nullable()->after('descripcion')->constrained('categorias')->nullOnDelete();
            $table->foreignId('lugar_id')->nullable()->after('categoria_id')->constrained('lugares')->nullOnDelete();
            $table->date('fecha_evento')->nullable()->after('lugar_id');
            $table->time('hora')->nullable()->after('fecha_evento');
            $table->string('detalle_lugar')->nullable()->after('hora');
            $table->string('custodia')->nullable()->after('detalle_lugar');
        });

        if (Schema::hasColumn('publicaciones', 'contenido')) {
            DB::table('publicaciones')->update([
                'descripcion' => DB::raw('contenido'),
            ]);

            Schema::table('publicaciones', function (Blueprint $table) {
                $table->dropColumn('contenido');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publicaciones', function (Blueprint $table) {
            $table->text('contenido')->nullable()->after('titulo');
        });

        DB::table('publicaciones')->update([
            'contenido' => DB::raw('descripcion'),
        ]);

        Schema::table('publicaciones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('categoria_id');
            $table->dropConstrainedForeignId('lugar_id');
            $table->dropColumn([
                'descripcion',
                'fecha_evento',
                'hora',
                'detalle_lugar',
                'custodia',
            ]);
        });

        Schema::dropIfExists('lugares');
        Schema::dropIfExists('categorias');
    }
};
