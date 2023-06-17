<?php


use App\Http\Controllers\ApiController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\PerfilesController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\ImportarController;
use App\Http\Controllers\LlegadasController;
use App\Http\Controllers\ProgramasController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return "hola";
    return view('login');
});

// LOGIN
Route::post('login/loguearse', [LoginController::class, "loguearse"]);
Route::get('login/logout', [LoginController::class, "logout"]);

Route::get('/formulario', function () {
    // return "hola";
    return view('formulario');
});

Route::get('/formulario_vuelos', function () {
    // return "hola";
    return view('formulario_vuelos');
});

//PRINCIPAL
Route::get('principal/index', [PrincipalController::class, "index"]);
Route::post('principal/obtener_departamentos', [PrincipalController::class, "obtener_departamentos"]);
Route::post('principal/obtener_provincias', [PrincipalController::class, "obtener_provincias"]);
Route::post('principal/obtener_distritos', [PrincipalController::class, "obtener_distritos"]);
Route::post('principal/obtener_divisiones', [PrincipalController::class, "obtener_divisiones"]);
Route::post('principal/obtener_tipos_documento', [PrincipalController::class, "obtener_tipos_documento"]);
Route::post('principal/obtener_tipos_acceso', [PrincipalController::class, "obtener_tipos_acceso"]);
Route::post('principal/obtener_categorias_iglesia', [PrincipalController::class, "obtener_categorias_iglesia"]);
Route::post('principal/obtener_tipos_construccion', [PrincipalController::class, "obtener_tipos_construccion"]);
Route::post('principal/obtener_tipos_documentacion', [PrincipalController::class, "obtener_tipos_documentacion"]);
Route::post('principal/obtener_tipos_inmueble', [PrincipalController::class, "obtener_tipos_inmueble"]);
Route::post('principal/obtener_condicion_inmueble', [PrincipalController::class, "obtener_condicion_inmueble"]);
Route::post('principal/cambiar_idioma', [PrincipalController::class, "cambiar_idioma"]);
Route::post('principal/obtener_motivos_baja', [PrincipalController::class, "obtener_motivos_baja"]);
Route::post('principal/obtener_condicion_eclesiastica', [PrincipalController::class, "obtener_condicion_eclesiastica"]);
Route::post('principal/obtener_condicion_eclesiastica_all', [PrincipalController::class, "obtener_condicion_eclesiastica_all"]);
Route::post('principal/obtener_religiones', [PrincipalController::class, "obtener_religiones"]);
Route::post('principal/obtener_tipos_cargo', [PrincipalController::class, "obtener_tipos_cargo"]);
Route::post('principal/obtener_cargos', [PrincipalController::class, "obtener_cargos"]);
Route::post('principal/obtener_instituciones', [PrincipalController::class, "obtener_instituciones"]);
Route::post('principal/obtener_parentesco', [PrincipalController::class, "obtener_parentesco"]);

Route::post('principal/consultar_modulo', [PrincipalController::class, "consultar_modulo"]);
Route::post('principal/EliminarProceso', [PrincipalController::class, "EliminarProceso"]);


/*************
 * MODULO SEGURIDAD *
 *************/
// PERFILES
Route::get('perfiles/index', [PerfilesController::class, "index"]);
Route::post('perfiles/buscar_datos', [PerfilesController::class, "buscar_datos"]);
Route::post('perfiles/guardar_perfiles', [PerfilesController::class, "guardar_perfiles"]);
Route::post('perfiles/get_perfiles', [PerfilesController::class, "get_perfiles"]);
Route::post('perfiles/eliminar_perfiles', [PerfilesController::class, "eliminar_perfiles"]);
Route::post('perfiles/obtener_perfiles', [PerfilesController::class, "obtener_perfiles"]);
Route::post('perfiles/obtener_traducciones', [PerfilesController::class, "obtener_traducciones"]);

// MODULOS
Route::get('modulos/index', [ModulosController::class, "index"]);
Route::post('modulos/buscar_datos', [ModulosController::class, "buscar_datos"]);
Route::post('modulos/guardar_modulos', [ModulosController::class, "guardar_modulos"]);
Route::post('modulos/guardar_padres', [ModulosController::class, "guardar_padres"]);
Route::post('modulos/get_modulos', [ModulosController::class, "get_modulos"]);
Route::post('modulos/eliminar_modulos', [ModulosController::class, "eliminar_modulos"]);
Route::post('modulos/obtener_padres', [ModulosController::class, "obtener_padres"]);
Route::post('modulos/obtener_modulos', [ModulosController::class, "obtener_modulos"]);
Route::post('modulos/obtener_traducciones', [ModulosController::class, "obtener_traducciones"]);
Route::post('modulos/select_init', [ModulosController::class, "select_init"]);

//USUARIOS
Route::get('usuarios/index', [UsuariosController::class, "index"]);
Route::post('usuarios/buscar_datos', [UsuariosController::class, "buscar_datos"]);
Route::post('usuarios/guardar_usuarios', [UsuariosController::class, "guardar_usuarios"]);
Route::post('usuarios/get_usuarios', [UsuariosController::class, "get_usuarios"]);
Route::post('usuarios/eliminar_usuarios', [UsuariosController::class, "eliminar_usuarios"]);
Route::get('usuarios/cambiar_password', [UsuariosController::class, "cambiar_password"]);
Route::post('usuarios/select_init', [UsuariosController::class, "select_init"]);

// PERMISOS

Route::get('permisos/index', [PermisosController::class, "index"]);
Route::post('permisos/guardar_permisos', [PermisosController::class, "guardar_permisos"]);
Route::post('permisos/get', [PermisosController::class, "get"]);


/*************
 * MODULO EVENTOS *
 *************/


// PARTICIPANTES
Route::get('participantes/index', [ParticipantesController::class, "index"]);
Route::post('participantes/buscar_datos', [ParticipantesController::class, "buscar_datos"]);
Route::post('participantes/guardar_participantes', [ParticipantesController::class, "guardar_participantes"]);
Route::post('participantes/get_participantes', [ParticipantesController::class, "get_participantes"]);
Route::post('participantes/eliminar_participantes', [ParticipantesController::class, "eliminar_participantes"]);
Route::post('participantes/obtener_participantes', [ParticipantesController::class, "obtener_participantes"]);
Route::post('participantes/select_init', [ParticipantesController::class, "select_init"]);
Route::post('participantes/enviar_qr', [ParticipantesController::class, "enviar_qr"]);
Route::post('participantes/validar_participante_segun_nrodoc', [ParticipantesController::class, "validar_participante_segun_nrodoc"]);
Route::post('participantes/obtener_participante_segun_codigoqr', [ParticipantesController::class, "obtener_participante_segun_codigoqr"]);
Route::post('participantes/obtener_participante_segun_evento', [ParticipantesController::class, "obtener_participante_segun_evento"]);
Route::get('participantes/procesar', [ParticipantesController::class, "procesar"]);
// Route::get('participantes/generar_pdf_qr', [ParticipantesController::class, "generar_pdf_qr"]);

// EVENTOS
Route::get('eventos/index', [EventosController::class, "index"]);
Route::post('eventos/buscar_datos', [EventosController::class, "buscar_datos"]);
Route::post('eventos/guardar_eventos', [EventosController::class, "guardar_eventos"]);
Route::post('eventos/get_eventos', [EventosController::class, "get_eventos"]);
Route::post('eventos/eliminar_eventos', [EventosController::class, "eliminar_eventos"]);
Route::post('eventos/obtener_eventos', [EventosController::class, "obtener_eventos"]);
Route::post('eventos/obtener_eventos_segun_participante_registro', [EventosController::class, "obtener_eventos_segun_participante_registro"]);
Route::post('eventos/obtener_todos_eventos', [EventosController::class, "obtener_todos_eventos"]);


// PROGRAMAS
Route::get('programas/index', [ProgramasController::class, "index"]);
Route::post('programas/buscar_datos', [ProgramasController::class, "buscar_datos"]);
Route::post('programas/guardar_programas', [ProgramasController::class, "guardar_programas"]);
Route::post('programas/get_programas', [ProgramasController::class, "get_programas"]);
Route::post('programas/eliminar_programas', [ProgramasController::class, "eliminar_programas"]);
Route::post('programas/obtener_programas_segun_tipo', [ProgramasController::class, "obtener_programas_segun_tipo"]);
Route::post('programas/select_init', [ProgramasController::class, "select_init"]);

// ASISTENCIAS
Route::get('asistencias/index', [AsistenciasController::class, "index"]);
Route::post('asistencias/buscar_datos', [AsistenciasController::class, "buscar_datos"]);
Route::post('asistencias/guardar_asistencias', [AsistenciasController::class, "guardar_asistencias"]);
Route::post('asistencias/get_asistencias', [AsistenciasController::class, "get_asistencias"]);
Route::post('asistencias/eliminar_asistencias', [AsistenciasController::class, "eliminar_asistencias"]);
Route::post('asistencias/select_init', [AsistenciasController::class, "select_init"]);
Route::post('asistencias/guardar_permisos', [AsistenciasController::class, "guardar_permisos"]);

// LLEGADAS
Route::get('llegadas/index', [LlegadasController::class, "index"]);
Route::post('llegadas/buscar_datos', [LlegadasController::class, "buscar_datos"]);
Route::post('llegadas/guardar_llegadas', [LlegadasController::class, "guardar_llegadas"]);
Route::post('llegadas/get_llegadas', [LlegadasController::class, "get_llegadas"]);
Route::post('llegadas/eliminar_llegadas', [LlegadasController::class, "eliminar_llegadas"]);
Route::post('llegadas/select_init', [LlegadasController::class, "select_init"]);
Route::post('llegadas/guardar_permisos', [LlegadasController::class, "guardar_permisos"]);


// IMPORTAR

Route::get('importar/importar', [ImportarController::class, "importar"]);
Route::get('importar/datos', [ImportarController::class, "datos"]);
Route::post('importar/guardar_importar', [ImportarController::class, "guardar_importar"]);
Route::post('importar/importar_datos', [ImportarController::class, "importar_datos"]);
Route::post('importar/procesos', [ImportarController::class, "procesos"]);




 // API APP

 Route::get('api/login', [ApiController::class, "login"]);
 Route::get('api/marcar_asistencia', [ApiController::class, "marcar_asistencia"]);

 Route::get('api/guardar_votos', [ApiController::class, "guardar_votos"]);
 Route::get('api/guardar_comentarios', [ApiController::class, "guardar_comentarios"]);
 Route::get('api/obtener_paises', [ApiController::class, "obtener_paises"]);
 Route::get('api/obtener_tipos_documento', [ApiController::class, "obtener_tipos_documento"]);
 Route::get('api/obtener_foros', [ApiController::class, "obtener_foros"]);
 Route::get('api/obtener_comentarios', [ApiController::class, "obtener_comentarios"]);
 Route::get('api/obtener_votacion_activa', [ApiController::class, "obtener_votacion_activa"]);
 Route::get('api/obtener_url', [ApiController::class, "obtener_url"]);
 Route::get('api/obtener_eventos', [ApiController::class, "obtener_eventos"]);
