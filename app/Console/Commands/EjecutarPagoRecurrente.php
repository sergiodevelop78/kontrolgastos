<?php

namespace App\Console\Commands;

use App\Http\Controllers\NuevoConsumoController;
use App\Http\Controllers\PagosRecurrentesController;
use App\Http\Controllers\PagosRecurrentesLogsController;
use App\Models\consumos;
use Illuminate\Console\Command;

use PHPMailer\PHPMailer\PHPMailer;

class EjecutarPagoRecurrente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ejecutar-pago-recurrente';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecutar pagos recurrentes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $res = PagosRecurrentesController::listarPagosRecurrentesPorEjecutar();

        foreach ($res as $row) {
            $id_pago_recurrente = $row["idpago_recurrente"];
            $concepto = $row["concepto"];
            $total = $row["monto"];
            $fecha_consumo = date("Y-m-d");

            echo "\n## " . $id_pago_recurrente . ", concepto=" . $concepto . ", total=" . $total . ", fechaconsumo=" . $fecha_consumo;
            PagosRecurrentesController::insertarPagoRecurrenteConsumo($concepto, $total, $fecha_consumo);
            PagosRecurrentesLogsController::insertarLog($id_pago_recurrente);
        }


    }
}
