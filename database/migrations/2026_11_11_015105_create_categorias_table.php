<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->tinyIncrements('id'); // Equivale a TINYINT UNSIGNED AUTO_INCREMENT
            $table->string('nombre', 50)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};