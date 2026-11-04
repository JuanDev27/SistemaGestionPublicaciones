<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->after('name');
            $table->string('codigo_estudiantil', 50)->unique()->after('lastname');
            $table->string('facultad')->after('codigo_estudiantil');
            $table->string('phone', 20)->nullable()->after('facultad');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['codigo_estudiantil']);
            $table->dropColumn(['lastname', 'codigo_estudiantil', 'facultad', 'phone']);
        });
    }
};
