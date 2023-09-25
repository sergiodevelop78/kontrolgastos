<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tarjetas')) {
            Schema::create('tarjetas', function (Blueprint $table) {
                $table->id();
                $table->integer('idtarjeta');
                $table->string('tarjeta', 80);
                $table->integer('dia_corte', 30);
                $table->tinyInteger('activo');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas');
    }
};
