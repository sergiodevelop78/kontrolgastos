<?php

namespace App\Http\Controllers;

use App\Models\PagosRecurrentes;
use App\Models\consumos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PagosRecurrentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public static function listarPagosRecurrentesPorEjecutar()
    {
        $query = "SELECT idpago_recurrente, dia_pago, monto, concepto, MONTH(NOW()) AS mes FROM pagos_recurrentes a
        WHERE  dia_pago <= DAY(NOW())
        AND (SELECT COUNT(*) FROM `pagos_recurrentes_logs` WHERE idpago_recurrente=a.idpago_recurrente AND YEAR(fechamov)=YEAR(NOW())
        AND MONTH(fechamov)=MONTH(NOW()))=0";

        //echo "<pre>$query</pre>";
        $res = DB::select($query);

        $res = array_map(function ($value) {
            return (array)$value;
        }, $res);

        return $res;
    }

    public static function insertarPagoRecurrenteConsumo($concepto, $total, $fecha_consumo)
    {
        $consumo = new consumos();
        $consumo->concepto = $concepto;
        $consumo->total = $total;

        $fechaConsumo = $fecha_consumo;
        $consumo->fecha_consumo = $fechaConsumo;

        $data = NuevoConsumoController::getIdPeriodo($fechaConsumo);
        extract($data);

        $consumo->idperiodo = $idperiodo;
        $consumo->iduser = 3;  // Usuario Sistema 
        $consumo->save();

        $mensajeEmail = "Se registró un PAGO RECURRENTE de <b> S/." . $consumo->total . " soles</b>.";
        $mensajeEmail .= "<br>Por concepto de: " . $consumo->concepto;
        $mensajeEmail .= "<br>Fecha de registro: " . $consumo->fecha_consumo;

        NuevoConsumoController::enviarCorreoAlerta($mensajeEmail);


    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PagosRecurrentes $pagosRecurrentes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PagosRecurrentes $pagosRecurrentes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PagosRecurrentes $pagosRecurrentes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PagosRecurrentes $pagosRecurrentes)
    {
        //
    }
}
