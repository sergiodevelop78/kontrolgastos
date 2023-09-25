<?php

namespace App\Http\Controllers;

use App\Models\PagosRecurrentesLogs;
use Illuminate\Http\Request;

class PagosRecurrentesLogsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public static function store(Request $request)
    {
        //
    }

    public static function insertarLog($id_pago_recurrente)
    {
        $prl = new PagosRecurrentesLogs();
        $prl->idpago_recurrente = $id_pago_recurrente;
        $prl->fechamov = date("Y-m-d H:i:s");
        $prl->save();
    }
}
