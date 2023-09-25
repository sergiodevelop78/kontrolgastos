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
        if (!Schema::hasTable('periodos')) {
            Schema::create('periodos', function (Blueprint $table) {
                $table->id();
                $table->integer('idperiodo');
                $table->integer('idtarjeta');
                $table->string('periodo', 100);
                $table->integer('mesIni');
                $table->integer('diaIni');
                $table->integer('mesFin');
                $table->integer('diaFin');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
