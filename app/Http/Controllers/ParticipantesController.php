<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\ParticipantesModel;
use App\Models\PrincipalModel;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class ParticipantesController extends Controller
{
    //

    private $base_model;
    private $participantes_model;
    private $principal_model;

    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();
        $this->base_model = new BaseModel();
        $this->participantes_model = new ParticipantesModel();

    }

    public function index() {

        $view = "participantes.index";
        $data["title"] = "Administración de Participantes";
        $data["subtitle"] = "";
        $data["tabla"] = $this->participantes_model->tabla()->HTML();

        $botones = array();
        $botones[0] = '<button disabled="disabled" tecla_rapida="F1" style="margin-right: 5px;" class="btn btn-default btn-sm" id="nuevo-participante"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/agregar-archivo.png').'"><br>Nuevo [F1]</button>';
        $botones[1] = '<button disabled="disabled" tecla_rapida="F2" style="margin-right: 5px;" class="btn btn-default btn-sm" id="modificar-participante"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/editar-documento.png').'"><br>Modificar [F2]</button>';
        $botones[2] = '<button disabled="disabled" tecla_rapida="F7" style="margin-right: 5px;" class="btn btn-default btn-sm" id="eliminar-participante"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/delete.png').'"><br>Eliminar [F7]</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["participantes.js"]);
        return parent::init($view, $data);



    }

    public function buscar_datos() {
        $json_data = $this->participantes_model->tabla()->obtenerDatos();
        echo json_encode($json_data);
    }

    public function enviar_correo($datos) {
        ini_set('max_execution_time', 6000);
        $response["result"] = "S";
        $response["msg"] = "";
        // echo $value->email."<br>";
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
        try {
            $mail->SMTPDebug  = SMTP::DEBUG_OFF; // SMTP::DEBUG_OFF: No output, SMTP::DEBUG_SERVER: Client and server messages
            $mail->isSMTP();
            // cuando es gmail indistintamente si es para tu maquina local o cpanel
            // $mail->Host       = "smtp.gmail.com";
            // $mail->SMTPAuth = true;
            // $mail->Username = "bleonardo.gsinarahua@gmail.com";
            // $mail->Password = "garcia@2004";
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // TLS: ENCRYPTION_STARTTLS, SSL: ENCRYPTION_SMTPS
            // $mail->Port = 587

            // configuracion para cpanel

            if($_ENV["DB_DATABASE"] == "imseventos") {
                // configuracion para tu maquina local
                $mail->Host = 'mail.smisystem.org';
                $mail->SMTPAuth = true;
                $mail->Username = "imssystem@smisystem.org";
                $mail->Password = "imssystem@1235";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // TLS:

                $mail->Port       = 465; // si no quiere con el puerto 25 poner el puerto 587, al parecer en produccion va el puerto 587 y en desarollo el puerto 25,
                // o sino la mejor opcion es con SMTPSecure='ssl' y el puerto 665

            } else {
                $mail->Host = 'localhost';
                $mail->SMTPAuth = false;
                $mail->Username = "imssystem@smisystem.org";
                $mail->Password = "imssystem@1235";
                // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // TLS:

                $mail->Port       = 25; // si no quiere con el puerto 25 poner el puerto 587, al parecer en produccion va el puerto 587 y en desarollo el puerto 25,
                //o sino la mejor opcion es con SMTPSecure='ssl' y el puerto 665
            }






            $mail->setFrom("imssystem@smisystem.org", utf8_decode("Iglesia Adventista del Séptimo Día Movimiento de Reforma"));
            $mail->addAddress($datos->participante_correo, $datos->participante_apellidos.", ".$datos->participante_nombres);
            $mail->Subject = utf8_decode("Notificación de Generación de Código QR");
            $mail->isHTML(true);

            $mail->addAttachment("../public/PDF/".$datos->participante_codigoqr.'.pdf',$datos->participante_codigoqr.'.pdf');



            $Contenido = "Estimado(a): " . $datos->participante_apellidos.", ".$datos->participante_nombres . " se le notifica que se ha generado su codigo QR para el evento: ". utf8_decode($datos->evento_descripcion);
            $Contenido .= "<br> Se adjunta documento con todos los detalles";
            $Contenido .= "<br><br> Atentamente: ".utf8_decode("Iglesia Adventista del Séptimo Día Movimiento de Reforma");

            $mail->Body = $Contenido;



            $mail->send();

        } catch (Exception $e) {
            // echo $e->getMessage()."<br>";
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            $response["result"] = "N";
            $response["msg"] = $e->getMessage(). " Message could not be sent. Mailer Error: {$mail->ErrorInfo} \n";



        }

        return $response;
    }


    public function guardar_participantes(Request $request) {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $_POST = $this->toUpper($_POST, ["participante_correo"]);
            $_POST["participante_fecha_nacimiento"] = (isset($_REQUEST["participante_fecha_nacimiento"])) ? $this->FormatoFecha($_REQUEST["participante_fecha_nacimiento"], "server") : "";
            $_POST["usuario_id"] = session("usuario_id");


            if(!empty($data["idtipodoc"]) && $data["idtipodoc"] != "0" && !empty($data["participante_nrodoc"]) && !empty($data["idpais"])) {
                $sql_validacion = "SELECT * FROM eventos.participantes WHERE idtipodoc={$data["idtipodoc"]} AND participante_nrodoc='{$data["participante_nrodoc"]}' AND idpais={$data["idpais"]}";
                // die($sql_validacion);
                $validacion = DB::select($sql_validacion);

                if($request->input("participante_id") == '' && count($validacion) > 0) {
                    $response["validacion"] = "EP"; //EXISTE DOCUMENTO
                    throw new Exception("¡Ya existe un participante registrado con estos datos!");
                }

            }


            if ($request->input("participante_id") == '') {
                $result = $this->base_model->insertar($this->preparar_datos("eventos.participantes", $_POST));
                $_POST["participante_id"] = $result["id"];
                // $_POST["evento_id"] = 1;
                $this->base_model->insertar($this->preparar_datos("eventos.detalle_eventos", $_POST));
            }else{
                $result = $this->base_model->modificar($this->preparar_datos("eventos.participantes", $_POST));
            }

            $string_qr = $data["evento_id"]."-" . $result["id"]."-". mt_rand(1000, 9999);

            $data_update = array();
            $data_update["participante_id"] = $result["id"];
            $data_update["participante_codigoqr"] = $string_qr;
            $data_update["participante_codigoqr_ruta"] = $string_qr.".png";
            $this->base_model->modificar($this->preparar_datos("eventos.participantes", $data_update));


            // GUARDAMOS IMAGEN DEL CODIGO QR
            // referencia: https://www.desarrollolibre.net/blog/laravel/generar-simples-codigos-qrs-con-laravel
            if (!file_exists(base_path("public/QR/"))) {
                mkdir(base_path("public/QR/"), 0777, true);
            }

            QrCode::format('png')->margin(0)->size(300)->color(0, 0, 0)->generate($string_qr, '../public/QR/'.$string_qr.".png");

            $this->generar_pdf_qr($result["id"], 1);

            if ($request->input("participante_id") == '') {
                $participante = $this->participantes_model->obtener_participante_segun_evento($result["id"], 1);
                $response = $this->enviar_correo($participante[0]);
                if($response["result"] == "N") {

                    throw new Exception($response["msg"]);
                }
            }

            DB::commit();
            echo json_encode($result);
        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei";
            $response["msg"] = $e->getMessage();
            echo json_encode($response);
        }
    }

    public function eliminar_participantes() {


        try {
            // $sql_asociados = "SELECT * FROM participantes.miembro WHERE participante_id=".$_REQUEST["id"];
            // $asociados = DB::select($sql_asociados);

            // if(count($asociados) > 0) {
            //     throw new Exception(traducir("traductor.eliminar_iglesia_asociado"));
            // }

            $result = $this->base_model->eliminar(["eventos.participantes","participante_id"]);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }
    }

    public function select_init(Request $request) {

        $data = array();

        $data["idtipodoc"] = $this->principal_model->obtener_tipos_documento();
        $data["idpais"] = $this->principal_model->obtener_paises();

        echo json_encode($data);
    }


    public function get_participantes(Request $request) {

        $sql = "SELECT * FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)

        WHERE p.participante_id=".$request->input("id");
        $one = DB::select($sql);



        echo json_encode($one);
    }

    public function obtener_participantes(Request $request) {

        $result = $this->participantes_model->obtener_participantes($request);
        echo json_encode($result);
    }



    public function generar_pdf_qr($participante_id, $evento_id) {
        if (!file_exists(base_path("public/PDF/"))) {
            mkdir(base_path("public/PDF/"), 0777, true);
        }

        $datos["participante"] = $this->participantes_model->obtener_participante_segun_evento($participante_id, $evento_id);
        // print_r($datos); exit;


        $pdf = PDF::loadView("participantes.pdf_qr", $datos)->setPaper('A4', "portrait");


        $pdf->save('../public/PDF/'.$datos["participante"][0]->participante_codigoqr.".pdf"); // guardar
        // return $pdf->download("ficha_asociado.pdf"); // descargar
        // return $pdf->stream("pdf_qr.pdf"); // ver
    }


    public function enviar_qr(Request $request) {

        $data = $request->all();
        try {
            $participante = $this->participantes_model->obtener_participante_segun_evento($data["participante_id"], 1);
            $response = $this->enviar_correo($participante[0]);
            if($response["result"] == "N") {

                throw new Exception($response["msg"]);
            }
            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }

    }


}
