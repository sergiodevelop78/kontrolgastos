<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\consumos;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class NuevoConsumoController extends Controller
{
    const DIA_CORTE = 19;
    const DIA_INICIO = 20;
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('nuevoconsumo');
    }


    public function listado()
    {
        return view('verconsumo_periodo');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'consumo_soles' => ['required', 'string', 'max:255'],
            'concepto' => ['required', 'string', 'max:255'],
            'fecha_consumo' => ['required', 'string', 'min:8'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function store(Request $request)
    {
        $consumo = new consumos();
        $consumo->concepto = $request->concepto;
        $consumo->total = $request->consumo_soles;

        $fechaConsumo = $request->fecha_consumo;
        $consumo->fecha_consumo = $fechaConsumo;

        $data = self::getIdPeriodo($fechaConsumo);
        //print_r($data);

        extract($data);
        $consumo->idperiodo = $idperiodo;
        $consumo->iduser = auth()->id();
        $consumo->save();

        $mensajeEmail = "Se registró un nuevo gasto de <b> S/." . $consumo->total . " soles</b>.";
        $mensajeEmail .= "<br>Por concepto de: " . $consumo->concepto;
        $mensajeEmail .= "<br>Fecha de registro: " . $consumo->fecha_consumo;

        self::enviarCorreoAlerta($mensajeEmail);

        return redirect('nuevoconsumo')->with('status', 'El nuevo registro ha sido guardado correctamente.');
    }

    public static function getFechasPeriodo()
    {
        $query = "select idperiodo, idtarjeta, periodo, mesIni, diaIni, mesFin, diaFin,
        concat(lpad(mesIni,2, '0'), '-', diaIni) as mesDiaIni, concat(lpad(mesFin,2, '0'), '-', diaFin) as mesDiaFin
        FROM periodos 
        WHERE date_format(now(), '%m-%d')>=CONCAT(lpad(mesIni,2, '0'), '-', diaIni)
        and date_format(now(), '%m-%d')<=CONCAT(lpad(mesFin,2, '0'), '-', diaFin)";

        //echo "<pre>$query</pre>";
        $res = DB::select($query);

        $res = array_map(function ($value) {
            return (array)$value;
        }, $res);

        $year = date("Y-");
        $mesActual = date("m");


        if ($mesActual == 12) {
            $mesFin = "01";
            $year = $year + 1;
        }


        $formatFecIni = $year . $res[0]['mesDiaIni'];
        $formatFecFin = $year . $res[0]['mesDiaFin'];
        $idperiodo = $res[0]["idperiodo"];
        /*$fecIni = $formatFecIni . " 00:00:01";
        $fecFin = $formatFecFin . " 23:59:59";
        */
        $fecIni = $formatFecIni;
        $fecFin = $formatFecFin;


        //$arrRes = array($fecIni, $fecFin);
        return compact("fecIni", "fecFin", "formatFecIni", "formatFecFin", "idperiodo");
    }

    public static function getIdPeriodo($fecha)
    {
        echo $fecha;
        //die();
        $query = "select idperiodo, idtarjeta, periodo, mesIni, diaIni, mesFin, diaFin,
        concat(lpad(mesIni,2, '0'), '-', diaIni) as mesDiaIni, concat(lpad(mesFin,2, '0'), '-', diaFin) as mesDiaFin
        FROM periodos 
        WHERE date_format('$fecha', '%m-%d')>=concat(lpad(mesIni,2, '0'), '-', diaIni)
        and date_format('$fecha', '%m-%d')<=concat(lpad(mesFin,2, '0'), '-', diaFin)";


        //echo $query;
        //die();
        $res = DB::select($query);

        $res = array_map(function ($value) {
            return (array)$value;
        }, $res);

        $year = date("Y-");
        $mesActual = date("m");

        if ($mesActual == 12) {
            $mesFin = "01";
            $year = $year + 1;
        }
        //print_r($res);
        //die();
        $idperiodo = $res[0]["idperiodo"];

        return compact("idperiodo");
    }


    public static function showPeriodo()
    {
        $data = self::getFechasPeriodo();
        //print_r($data);

        extract($data);
        $fecIni = $formatFecIni;
        $fecFin = $formatFecFin;
        $resultado = " del $fecIni al $fecFin / idperiodo = $idperiodo";
        
        return $resultado;

    }


    public static function getConsumidoPeriodo()
    {

        $data = self::getFechasPeriodo();
        extract($data);


        $query = "select sum(total) as sumaTotal 
        from consumos where fecha_consumo between '" . $fecIni . "' AND '" . $fecFin . "'";
        //echo $query;
        $res = DB::select($query);

        $res = array_map(function ($value) {
            return (array)$value;
        }, $res);

        //var_dump($res);
        return $res[0]['sumaTotal'];
    }

    public static function getConsumidoPeriodoFiltrado($idperiodo, $anyo)
    {

        $query = "SELECT SUM(total) AS sumaTotal 
        FROM consumos WHERE YEAR(fecha_consumo)=" . $anyo . " AND idperiodo=" . $idperiodo . " ; ";

        //echo $query;
        $res = DB::select($query);

        $res = array_map(function ($value) {
            return (array)$value;
        }, $res);

        //var_dump($res);
        return $res[0]['sumaTotal'];
    }


    public static function verPeriodos(Request $request)
    {
        if ($request->has('comboYear')) {
            $year = $request->comboYear;
            $filtroYear = " AND YEAR(c.fecha_consumo)=$year";
        } else {
            $year = "";
            $filtroYear = "";
        }



        $query = "SELECT c.idperiodo, YEAR(c.`fecha_consumo`) as anyo, 
        CONCAT(LPAD(diaIni,2,'0'), '-',LPAD(mesIni,2,'0')) AS fecIni, CONCAT(LPAD(diaFin,2,'0'), '-',LPAD(mesFin,2,'0')) AS fecFin, SUM(c.`total`) AS consumoPeriodo
        FROM periodos p, consumos c
        WHERE p.`idperiodo`=c.`idperiodo` $filtroYear GROUP BY 1,2,3,4";

        //echo $query;
        $listadoPeriodos = DB::select($query);

        return view('ver_periodos', compact('listadoPeriodos'));
    }


    public static function verPeriodos_old()
    {
        /*$data = self::getFechasPeriodo();
        extract($data);
        */
        $query = "SELECT c.idperiodo, periodo, CONCAT(LPAD(diaIni,2,'0'), '-',LPAD(mesIni,2,'0')) AS fecIni, CONCAT(LPAD(diaFin,2,'0'), '-',LPAD(mesFin,2,'0')) AS fecFin, SUM(c.`total`) AS consumoPeriodo
        FROM periodos p, consumos c
        WHERE p.`idperiodo`=c.`idperiodo` GROUP BY 1,2,3,4";

        //echo $query;
        $listadoPeriodos = DB::select($query);

        return view('ver_periodos', compact('listadoPeriodos'));
    }



    public static function listadoPeriodo()
    {
        $data = self::getFechasPeriodo();
        extract($data);

        $query = "select concepto, total, FORMAT(total, 2) AS total2, 
        fecha_consumo, u.name, date_format(fecha_consumo, '%d-%m-%Y') as fechaConsumo
            FROM consumos c, users u WHERE c.iduser=u.id 
            AND fecha_consumo between '" . $fecIni . "' AND '" . $fecFin .
        "'
            ORDER by fecha_consumo desc";
        //echo $query;
        //
        $registrosPeriodo = DB::select($query);
        //var_dump($registrosPeriodo);


        $totalConsumoPeriodo = self::getConsumidoPeriodo();

        return view('verconsumo_periodo', compact('registrosPeriodo', 'totalConsumoPeriodo'));
    }


    public static function listadoPeriodoFiltrado(Request $request)
    {
        $anyo = $request->anyo;
        $idperiodo = $request->idperiodo;

        $query = "select concepto, total, total as total2, fecha_consumo, u.name, date_format(fecha_consumo, '%d-%m-%Y') as fechaConsumo
            FROM consumos c, users u WHERE c.iduser=u.id 
            AND idperiodo=" . $idperiodo . " ORDER by fecha_consumo ASC";
        //echo $query;
        $registrosPeriodo = DB::select($query);
        //var_dump($registrosPeriodo);


        $totalConsumoPeriodo = self::getConsumidoPeriodoFiltrado($idperiodo, $anyo);

        return view('verconsumo_periodo', compact('registrosPeriodo', 'totalConsumoPeriodo'));
    }

    public static function getEmailsTo()
    {
        $query = "select email FROM users ";
        $res = DB::select($query);

        $res = array_map(function ($value) {
            return (array)$value;
        }, $res);

        return $res;
    }


    public static function enviarCorreoAlerta($mensaje)
    {
        $arrEmails = self::getEmailsTo();
        //var_dump($arrEmails);

        $mail = new PHPMailer;
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = "localhost";                    // Set the SMTP server to send through
        $mail->SMTPAuth   = false;
        $mail->SMTPAutoTLS = false;                               // Enable SMTP authentication
        //$mail->Username   = 'YOUREMAIL@gmail.com';                     // SMTP username
        //$mail->Password   = 'YOUREMAILPASSWORD';                               // SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 25;         

        //Recipients
        $mail->From = 'sergio@sybpruebas.com';
        $mail->FromName = 'Control Gastos Web - Alertas';
        $mail->addReplyTo('sergio@sybpruebas.com'); 
        //$mail->setFrom('sergio@sybpruebas.com', 'Control Gastos Web - Alertas');

        foreach ($arrEmails as $resEmail) {
            $mail->addAddress($resEmail["email"]);
            echo "<br>" . $resEmail["email"];
        }
        // Content
        $mail->isHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Subject = 'Alerta de nuevo gasto ingresado';

        //$mensaje = 'Se registró el gasto de <b>100 soles</b>.';
        if ($mensaje == "")
            $mensajeEnviar = 'Se registró un movimiento desconocido.';
        else
            $mensajeEnviar = $mensaje;

        $mail->Body    = $mensajeEnviar; 

        /** Para que use el lenguaje español **/
        //$mail->setLanguage('es');
        
        /** Enviar mensaje... **/
        if (!$mail->send()) {
            echo 'El mensaje no pudo ser enviado.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Mensaje enviado correctamente';
        }
        
    }



}
