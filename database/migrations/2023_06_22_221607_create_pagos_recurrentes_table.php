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
        if (!Schema::hasTable('pagos_recurrentes')) {
            Schema::create('pagos_recurrentes', function (Blueprint $table) {
                $table->id();
                $table->string('concepto');
                $table->integer('idtarjeta');
                $table->tinyInteger('dia_pago');
                $table->double('monto');
                $table->tinyInteger('estado');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_recurrentes');
    }
};
