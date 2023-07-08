<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\EventosModel;
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
    private $eventos_model;

    public function __construct() {
        parent:: __construct();

        $this->principal_model = new PrincipalModel();
        $this->base_model = new BaseModel();
        $this->participantes_model = new ParticipantesModel();
        $this->eventos_model = new EventosModel();

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

        $botones[3] = '<button disabled="disabled" style="margin-right: 5px;" class="btn btn-default btn-sm" id="ver-eventos"><img style="width: 19px; height: 20px;" src="'.URL::asset('images/iconos/lupa.png').'"><br>Ver Eventos</button>';
        $data["botones"] = $botones;

        $data["scripts"] = $this->cargar_js(["participantes.js?version=030720231208"]);
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
            $mail->addAddress($datos->registro_correo, $datos->participante_apellidos.", ".$datos->participante_nombres);
            $mail->Subject = utf8_decode("Notificación de Generación de Código QR");
            $mail->isHTML(true);

            $mail->addAttachment("../public/PDF/".$datos->de_codigoqr.'.pdf',$datos->de_codigoqr.'.pdf');



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

            $data["evento_id"] = (isset($data["evento_id"])) ? $data["evento_id"] : array();

            if(isset($data["usuario_user"])) {
                session(['usuario_user' => $data["usuario_user"]]);
            }


            // print_r($data); exit;
            $_POST = $this->toUpper($_POST, ["registro_correo"]);
            $_POST["participante_fecha_nacimiento"] = (isset($_REQUEST["participante_fecha_nacimiento"])) ? $this->FormatoFecha($_REQUEST["participante_fecha_nacimiento"], "server") : "";
            $_POST["usuario_id"] = session("usuario_id");

            $_POST["registro_fecha_llegada"] = (isset($_REQUEST["registro_fecha_llegada"])) ? $this->FormatoFecha($_REQUEST["registro_fecha_llegada"], "server") : "";
            $_POST["registro_fecha_retorno"] = (isset($_REQUEST["registro_fecha_retorno"])) ? $this->FormatoFecha($_REQUEST["registro_fecha_retorno"], "server") : "";


            if(!empty($data["idtipodoc"]) && $data["idtipodoc"] != "0" && !empty($data["participante_nrodoc"]) && !empty($data["idpais"])) {
                $sql_validacion = "SELECT * FROM eventos.participantes WHERE idtipodoc={$data["idtipodoc"]} AND participante_nrodoc='{$data["participante_nrodoc"]}' AND idpais={$data["idpais"]}";
                // die($sql_validacion);
                $validacion = DB::select($sql_validacion);

                if($request->input("participante_id") == '' && count($validacion) > 0) {
                    $response["validacion"] = "EP"; //EXISTE DOCUMENTO
                    throw new Exception("¡Ya existe un participante registrado con estos datos!");
                }

            }


            if ($request->input("participante_id") == '' && $data["operacion"] == "NUEVO") {

                $result = $this->base_model->insertar($this->preparar_datos("eventos.participantes", $_POST));
                // print_r($result);
                $_POST["participante_id"] = $result["id"];
                $r = $this->base_model->insertar($this->preparar_datos("eventos.registros", $_POST));
                // print_r($r);
                $_POST["registro_id"] = $r["id"];

                $data_update = array();
                $data_update["participante_id"] = $_POST["participante_id"];
                $data_update["registro_id_ultimo"] = $_POST["registro_id"];
                $this->base_model->modificar($this->preparar_datos("eventos.participantes", $data_update));

                // $_POST["evento_id"] = 1;
                // $this->base_model->insertar($this->preparar_datos("eventos.detalle_eventos", $_POST));
            }else{
                //
                if(count($data["evento_id"]) > 0) {
                    DB::table("eventos.detalle_eventos")->where("participante_id", $data["participante_id"])->where("registro_id", $_POST["registro_id_ultimo"])->whereNotIn('evento_id', $data["evento_id"])->delete();
                }

                // print_r($this->preparar_datos("eventos.participantes", $_POST)); exit;
                $result = $this->base_model->modificar($this->preparar_datos("eventos.participantes", $_POST));
                $this->base_model->modificar($this->preparar_datos("eventos.registros", $_POST));
                $_POST["registro_id"] = $_POST["registro_id_ultimo"];
            }




            if (!file_exists(base_path("public/QR/"))) {
                mkdir(base_path("public/QR/"), 0777, true);
            }


            for ($i=0; $i < count($data["evento_id"]); $i++) {

                // validacion si ya existe el evento en la tabla detalle_eventos
                $evento = $this->participantes_model->obtener_participante_segun_evento($result["id"], $data["evento_id"][$i], $_POST["registro_id"]);
                if(count($evento) > 0) {
                    continue;
                }

                $data_detalle = array();

                $string_qr = $data["evento_id"][$i]."-" . $result["id"]."-". mt_rand(1000, 9999);


                $data_detalle["evento_id"] = $data["evento_id"][$i];
                $data_detalle["participante_id"] = $result["id"];
                $data_detalle["registro_id"] = $_POST["registro_id"];
                $data_detalle["de_codigoqr"] = $string_qr;
                $data_detalle["de_codigoqr_ruta"] = $string_qr.".png";
                $this->base_model->insertar($this->preparar_datos("eventos.detalle_eventos", $data_detalle));


                // GUARDAMOS IMAGEN DEL CODIGO QR
                // referencia: https://www.desarrollolibre.net/blog/laravel/generar-simples-codigos-qrs-con-laravel

                QrCode::format('png')->margin(0)->size(300)->color(0, 0, 0)->generate($string_qr, '../public/QR/'.$string_qr.".png");

                $this->generar_pdf_qr($result["id"], $data["evento_id"][$i], $_POST["registro_id"]);

                if ($request->input("participante_id") == '' && $data["operacion"] == "NUEVO") {
                    $participante = $this->participantes_model->obtener_participante_segun_evento($result["id"], $data["evento_id"][$i], $_POST["registro_id"]);

                    if($_ENV["DB_DATABASE"] == "smisystem_eventos") {
                        $response = $this->enviar_correo($participante[0]);
                        if($response["result"] == "N") {

                            throw new Exception($response["msg"]);
                        }
                    }
                }

            }

            DB::commit();
            $result["registro_id_ultimo"] = $_POST["registro_id"];
            $result["participante_id"] = $result["id"];
            echo json_encode($result);
        } catch (Exception $e) {
            DB::rollBack();
            $response["status"] = "ei";
            $response["msg"] = $e->getMessage();
            echo json_encode($response);
        }
    }

    public function eliminar_participantes(Request $request) {


        try {
            $data = $request->all();
            // $sql_asociados = "SELECT * FROM participantes.miembro WHERE participante_id=".$_REQUEST["id"];
            // $asociados = DB::select($sql_asociados);

            // if(count($asociados) > 0) {
            //     throw new Exception(traducir("traductor.eliminar_iglesia_asociado"));
            // }

            $participante = $this->participantes_model->obtener_participante($data["id"]);

            DB::table("eventos.detalle_eventos")->where("participante_id", $data["id"])->where("registro_id", $participante[0]->registro_id_ultimo)->delete();

            DB::table("eventos.registros")->where("participante_id", $data["id"])->where("registro_id", $participante[0]->registro_id_ultimo)->delete();

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
        $data["evento_id[]"] = $this->eventos_model->obtener_eventos();

        echo json_encode($data);
    }


    public function get_participantes(Request $request) {

        $sql = "SELECT e.*, de.*, r.*, p.* FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
        INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
        INNER JOIN eventos.registros AS r ON(r.participante_id=p.participante_id)

        WHERE p.participante_id=".$request->input("id")." AND r.registro_id=p.registro_id_ultimo";
        $one = DB::select($sql);
        echo json_encode($one);
    }

    public function obtener_participantes(Request $request) {

        $result = $this->participantes_model->obtener_participantes($request);
        echo json_encode($result);
    }



    public function generar_pdf_qr($participante_id, $evento_id, $registro_id) {
        if (!file_exists(base_path("public/PDF/"))) {
            mkdir(base_path("public/PDF/"), 0777, true);
        }

        $datos["participante"] = $this->participantes_model->obtener_participante_segun_evento($participante_id, $evento_id, $registro_id);



        $pdf = PDF::loadView("participantes.pdf_qr", $datos)->setPaper('A4', "portrait");


        $pdf->save('../public/PDF/'.$datos["participante"][0]->de_codigoqr.".pdf"); // guardar
        // return $pdf->download("ficha_asociado.pdf"); // descargar
        // return $pdf->stream("pdf_qr.pdf"); // ver
    }


    public function enviar_qr(Request $request) {

        $data = $request->all();
        try {
            $participante = $this->participantes_model->obtener_participante_segun_evento($data["participante_id"], $data["evento_id"], $data["registro_id"]);
            $response = $this->enviar_correo($participante[0]);
            if($response["result"] == "N") {

                throw new Exception($response["msg"]);
            }
            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode(array("status" => "ee", "msg" => $e->getMessage()));
        }

    }

    public function validar_participante_segun_nrodoc(Request $request) {
        $data = $request->all();
        $sql = "SELECT * FROM eventos.participantes WHERE idtipodoc={$data["idtipodoc"]} AND idpais={$data["idpais"]} AND participante_nrodoc='{$data["participante_nrodoc"]}' AND estado='A'";
        $result["participante"] = DB::select($sql);
        $result["eventos"] = array();

        if(count($result["participante"]) > 0) {
            $sql_eventos = "SELECT * FROM eventos.participantes AS p
            INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id)
            INNER JOIN eventos.eventos AS e ON(e.evento_id=de.evento_id)
            WHERE e.estado='A' AND p.participante_id={$result["participante"][0]->participante_id}";

            $result["eventos"] = DB::select($sql_eventos);
        }


        // die($sql);
        echo json_encode($result);
    }

    public function obtener_participante_segun_codigoqr(Request $request) {
        $data = $request->all();
        $sql = "SELECT * FROM eventos.participantes AS p
        INNER JOIN eventos.detalle_eventos AS de ON(p.participante_id=de.participante_id AND p.registro_id_ultimo=de.registro_id)
        WHERE de_codigoqr='{$data["codigo_qr"]}' AND p.estado='A'";
        $result["participante"] = DB::select($sql);


        // die($sql);
        echo json_encode($result);
    }

    public function obtener_participante_segun_evento(Request $request) {
        $data = $request->all();
        $result = $this->participantes_model->obtener_participante_segun_evento($data["participante_id"], $data["evento_id"], $data["registro_id"]);

        echo json_encode($result);
    }

    public function procesar() {
        $sql = "SELECT * FROM eventos.participantes ORDER BY participante_id ASC";
        $participantes = DB::select($sql);

        foreach ($participantes as $key => $value) {
            $data_registro = array();
            $data_registro["participante_id"] = $value->participante_id;
            $data_registro["registro_ciudad_procedencia"] = $value->participante_ciudad_procedencia;
            $data_registro["registro_celular"] = $value->participante_celular;
            $data_registro["registro_celular_emergencia"] = $value->participante_celular_emergencia;
            $data_registro["registro_correo"] = $value->participante_correo;
            $data_registro["registro_apoderado"] = $value->participante_apoderado;
            $data_registro["registro_iglesia"] = $value->participante_iglesia;
            $data_registro["registro_edad"] = $value->participante_edad;
            $data_registro["registro_delegado"] = $value->participante_delegado;
            $data_registro["registro_aerolinea"] = $value->participante_aerolinea;
            $data_registro["registro_nrovuelo"] = $value->participante_nrovuelo;
            $data_registro["registro_fecha_llegada"] = $value->participante_fecha_llegada;
            $data_registro["registro_hora_llegada"] = $value->participante_hora_llegada;
            $data_registro["registro_fecha_retorno"] = $value->participante_fecha_retorno;
            $data_registro["registro_hora_retorno"] = $value->participante_hora_retorno;
            $data_registro["registro_destino_llegada"] = $value->participante_destino_llegada;

            $result = $this->base_model->insertar($this->preparar_datos("eventos.registros", $data_registro));

            $data_update = array();
            $data_update["participante_id"] = $value->participante_id;
            $data_update["registro_id_ultimo"] = $result["id"];
            $this->base_model->modificar($this->preparar_datos("eventos.participantes", $data_update));

            DB::statement("UPDATE eventos.detalle_eventos SET registro_id={$result["id"]}, de_codigoqr='{$value->participante_codigoqr}', de_codigoqr_ruta='{$value->participante_codigoqr_ruta}' WHERE participante_id={$value->participante_id}");

            echo $value->participante_nombres." ".$value->participante_apellidos." registro_id => ".$result["id"]."<br>\n";
        }
    }
}
