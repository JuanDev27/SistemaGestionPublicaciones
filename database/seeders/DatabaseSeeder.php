<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Datos de categorías
        DB::table('categorias')->insert([
            ['nombre' => 'Ropa'], ['nombre' => 'Llaves'], 
            ['nombre' => 'Electrónicos'], ['nombre' => 'Accesorios'],
            ['nombre' => 'Mochilas'], ['nombre' => 'Documentos'], 
            ['nombre' => 'Otros']
        ]);

        // Datos de lugares
        DB::table('lugares')->insert([
            ['nombre' => 'Biblioteca Central'], ['nombre' => 'Cafetería Central'],
            ['nombre' => 'Pabellón de Ingeniería'], ['nombre' => 'Gimnasio'], 
            ['nombre' => 'Otro']
        ]);
    }
}