
<?php
    // echo "<pre>";
    $data = session()->all();
    // print_r($data);
    // exit;
    echo '<script>var session = [];</script>';
    foreach ($data as $key => $value) {
        // print_r($key);
        // print_r($value);

        if($key != "parametros") {
            if(!is_array($value)) {

                echo '<script> session["'.$key.'"] = "'.$value.'"; </script>';
            } else {
                // echo '<script> var arr = [];';
                // foreach ($value as $kv => $vv) {
                //     echo '<script> arr["'.$kv.'"] = "'.$vv.'";  </script>';
                // }

                // echo '<script> session["'.$key.'"] = arr; </script>';
            }
        }

    }
    //echo '<script> console.log(session); </script>';
?>
<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IMS Eventos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- <link rel="stylesheet" href="{{ URL::asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dist/css/jquery.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('sweetalert/dist/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('notifications/notification.css') }}">


    <link rel="stylesheet" href="{{ URL::asset('selectize/selectize.bootstrap2.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('plugins/iCheck/all.css') }}">


    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('bower_components/modal-effect/css/component.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <style>
        textarea {
            resize: none;
        }
        table {
            font-size: 13px;
        }
    </style>
</head>

<body class="">
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">

            <div class="box-body">
                <form id="formulario-participantes" class="form-horizontal" role="form">

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Seleccione Eventos:</label>
                            <select class="selectizejs entrada" multiple="multiple" name="evento_id[]" id="evento_id"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Pais</label>

                            <select name="idpais" id="idpais" class="selectizejs entrada"></select>
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Tipo Documento</label>

                            <select name="idtipodoc" id="idtipodoc" class="selectizejs entrada"></select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Nro Documento</label>

                            <input type="text" class="form-control input-sm entrada" name="participante_nrodoc"  placeholder=""/>

                        </div>

                    </div>

                    <div class="row">
                        <input type="hidden" name="participante_id" class="input-sm entrada">
                        <input type="hidden" name="registro_id_ultimo" class="input-sm entrada">
                        <input type="hidden" name="usuario_user" value="web" class="input-sm entrada">
                        <input type="hidden" name="operacion" value="NUEVO" class="input-sm entrada">
                        <div class="col-md-6">
                            <label class="control-label">Nombres</label>

                            <input autofocus="autofocus" type="text" class="form-control input-sm entrada" name="participante_nombres"  placeholder=""/>

                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Apellidos</label>

                            <input type="text" class="form-control input-sm entrada" name="participante_apellidos"  placeholder=""/>

                        </div>


                    </div>



                    <div class="row">

                        <div class="col-md-3">
                            <label class="control-label">Celular</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_celular"  placeholder=""/>

                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Celular Emergencia</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_celular_emergencia"  placeholder=""/>

                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Correo</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_correo"  placeholder=""/>

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Iglesia</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_iglesia"  placeholder=""/>

                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Apoderado</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_apoderado"  placeholder=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="">
                            <label class="control-label">Fecha Nacimiento</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="participante_fecha_nacimiento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-participante_fecha_nacimiento" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <label class="control-label">Edad</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_edad"  placeholder=""/>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Ciudad Procedencia</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_ciudad_procedencia"  placeholder=""/>
                        </div>
                        <div class="col-md-3" >
                            <label class="control-label"style="margin-bottom: 5px;">Delegado: </label><br>
                            <input type="radio" name="registro_delegado" value="S" class="minimal entrada" >&nbsp;SI&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="registro_delegado" value="N" class="minimal entrada" >&nbsp;NO
                        </div>


                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Aerolinea</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_aerolinea"  placeholder=""/>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Número de Vuelo</label>

                            <input type="text" class="form-control input-sm entrada" name="registro_nrovuelo"  placeholder=""/>
                        </div>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Fecha de Llegada</label>

                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="registro_fecha_llegada" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-registro_fecha_llegada" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Hora de Llegada</label>


                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada limpiar" name="registro_hora_llegada" />
                                <div class="input-group-addon" style="cursor: pointer;">
                                    <i class="fa fa-clock-o" id="time-registro_hora_llegada"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Fecha de Retorno</label>

                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada" name="registro_fecha_retorno" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="" />
                                <div class="input-group-addon"  id="calendar-registro_fecha_retorno" style="cursor: pointer;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Hora de Retorno</label>


                            <div class="input-group">
                                <input type="text" class="form-control input-sm entrada limpiar" name="registro_hora_retorno" />
                                <div class="input-group-addon" style="cursor: pointer;">
                                    <i class="fa fa-clock-o" id="time-registro_hora_retorno"></i>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="row" >

                        <div class="col-md-7" style="padding-right: 0; margin-top: 27px;">
                            <label class="control-label">Destino final de llegada para recepción en aeropuerto</label>
                        </div>
                        <div class="col-md-3" style="margin-top: 27px;">
                            <input type="text" class="form-control input-sm entrada" name="registro_destino_llegada"  placeholder=""/>
                        </div>
                        <div class="col-md-2"  style="padding-left: 0;">
                            <label class="control-label">{{ traducir('traductor.estado')}}</label>
                            <select name="estado" id="estado" class="form-control input-sm entrada">
                                <option value="A">ACTIVO</option>
                                <option value="I">INACTIVO</option>
                            </select>
                        </div>



                    </div> --}}
                    <br>
                    <div class="pull-right">
                        {{-- <button type="button" class="btn btn-default btn-sm" id="cancelar-participante"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/cancelar.png') }}" ><br>[Esc] [{{ traducir('traductor.cancelar') }}]</button> --}}
                        <button type="button" id="guardar-participante" class="btn btn-default btn-sm"><img style="width: 20px; height: 20px;" src="{{ URL::asset('images/iconos/salvar.png') }}" ><br>[F9] [{{ traducir('traductor.guardar') }}]</button>
                    </div>

                </form>
            </div>

            <!-- <div class="box-footer">
                Footer
            </div> -->

        </div>
        <!-- /.box -->

    </section>
    <!-- ./wrapper -->

    <script>
        var BaseUrl = "<?php echo URL::to('/'); ?>";
        var _token = "<?php echo csrf_token() ?>";
        var session_pais_id = "<?php echo session("pais_id"); ?>";
        var datatable_next = "<?php echo traducir('traductor.datatable_next'); ?>";
        var datatable_prev = "<?php echo traducir('traductor.datatable_prev'); ?>";
        var datatable_first = "<?php echo traducir('traductor.datatable_first'); ?>";
        var datatable_last = "<?php echo traducir('traductor.datatable_last'); ?>";
        var datatable_records = "<?php echo traducir('traductor.datatable_records'); ?>";
        var datatable_vacio = "<?php echo traducir('traductor.datatable_vacio'); ?>";
        var datatable_mostrando = "<?php echo traducir('traductor.datatable_mostrando'); ?>";
        var datatable_search = "<?php echo traducir('traductor.buscar'); ?>";
        var datatable_ver = "<?php echo traducir('traductor.datatable_ver'); ?>";
        var datatables_no_match = "<?php echo traducir('traductor.datatables_no_match'); ?>";
        var datatable_from = "<?php echo traducir('traductor.datatable_from'); ?>";
        var datatable_a = "<?php echo traducir('traductor.datatable_a'); ?>";
        var datatable_no_data = "<?php echo traducir('traductor.datatable_no_data'); ?>";
        var jerarquia_traductor = new Array();
        jerarquia_traductor['departamento'] = "<?php echo traducir('traductor.departamento'); ?>";
        jerarquia_traductor['provincia'] = "<?php echo traducir('traductor.provincia'); ?>";
        jerarquia_traductor['distrito'] = "<?php echo traducir('traductor.distrito'); ?>";
        jerarquia_traductor['estado'] = "<?php echo traducir('traductor.estado'); ?>";
        jerarquia_traductor['municipio'] = "<?php echo traducir('traductor.municipio'); ?>";
        jerarquia_traductor['parroquias'] = "<?php echo traducir('traductor.parroquias'); ?>";
        jerarquia_traductor['region'] = "<?php echo traducir('traductor.region'); ?>";
        jerarquia_traductor['comuna'] = "<?php echo traducir('traductor.comuna'); ?>";
        jerarquia_traductor['corregimientos'] = "<?php echo traducir('traductor.corregimientos'); ?>";
        jerarquia_traductor['provincia_comarca'] = "<?php echo traducir('traductor.provincia_comarca'); ?>";
        var seleccione = "<?php echo traducir('traductor.seleccione'); ?>";
        var titulo_grafico_feligresia = "<?php echo traducir('traductor.titulo_grafico_feligresia'); ?>";
        var porcentaje = "<?php echo traducir('traductor.porcentaje'); ?>";
        var seleccionar_registro = "<?php echo traducir('traductor.seleccionar_registro'); ?>";
        var eliminar_registro = "<?php echo traducir('traductor.eliminar_registro'); ?>";
        var elemento_detalle = "<?php echo traducir('traductor.elemento_detalle'); ?>";
        var seleccionar_iglesia = "<?php echo traducir('traductor.seleccionar_iglesia'); ?>";
        var idioma_codigo = "<?php echo trim(session("idioma_codigo")); ?>";
        var valor_t = "<?php echo traducir('traductor.valor'); ?>";
        var cantidad_t = "<?php echo traducir('traductor.cantidad'); ?>";
        var descripcion_t = "<?php echo traducir('traductor.descripcion'); ?>";
        var asistentes_t = "<?php echo traducir('traductor.asistentes'); ?>";
        var interesados_t = "<?php echo traducir('traductor.interesados'); ?>";
        var actividadmisionera = "<?php echo traducir('traductor.actividad_misionera'); ?>";
        var distribucion_externa = "<?php echo traducir('traductor.distribucion_externa'); ?>";
        var distribucion_interna = "<?php echo traducir('traductor.distribucion_interna'); ?>";
        var actividades_masivas = "<?php echo traducir('traductor.actividades_masivas'); ?>";
        var eventos_masivos = "<?php echo traducir('traductor.eventos_masivos'); ?>";
        var material_estudiado = "<?php echo traducir('traductor.material_estudiado'); ?>";
        var actividades_juveniles = "<?php echo traducir('traductor.actividades_juveniles'); ?>";
        var planes = "<?php echo traducir('traductor.planes'); ?>";
        var informe_espiritual = "<?php echo traducir('traductor.informe_espiritual'); ?>";
        var datatable_seleccionado = "<?php echo traducir('traductor.datatable_seleccionado'); ?>";
        var no_registrado_asociado = "<?php echo traducir('traductor.no_registrado_asociado'); ?>";
        var condicion_eclesiastica_bautizado = "<?php echo traducir('traductor.condicion_eclesiastica_bautizado'); ?>";
        var registrado_fecha_bautizo = "<?php echo traducir('traductor.registrado_fecha_bautizo'); ?>";
        var asignado_responsable_bautizo = "<?php echo traducir('traductor.asignado_responsable_bautizo'); ?>";
        var asignado_procedencia_religiosa = "<?php echo traducir('traductor.asignado_procedencia_religiosa'); ?>";
        var remunerado = "<?php echo traducir('traductor.remunerado'); ?>";
        var no_remunerado = "<?php echo traducir('traductor.no_remunerado'); ?>";
        var tiempo_completo = "<?php echo traducir('traductor.tiempo_completo'); ?>";
        var tiempo_parcial = "<?php echo traducir('traductor.tiempo_parcial'); ?>";
        var advertencia = "<?php echo traducir('traductor.advertencia'); ?>";
        var email_invalido = "<?php echo traducir('traductor.email_invalido'); ?>";
        var seguro_cancelar = "<?php echo traducir('traductor.seguro_cancelar'); ?>";
        var finaliza_traslado = "<?php echo traducir('traductor.finaliza_traslado'); ?>";
        var no_hay_datos = "<?php echo traducir('traductor.no_hay_datos'); ?>";
        var seleccionar_campo_mostrar = "<?php echo traducir('traductor.seleccionar_campo_mostrar'); ?>";
        var excede_campos = "<?php echo traducir('traductor.excede_campos'); ?>";
        var traslado_correctamente = "<?php echo traducir('traductor.traslado_correctamente'); ?>";
        var agregar_mas_un_asociado = "<?php echo traducir('traductor.agregar_mas_un_asociado'); ?>";
        var traslado_proceso = "<?php echo traducir('traductor.traslado_proceso'); ?>";
        var no_trasladar_iglesia_origen = "<?php echo traducir('traductor.no_trasladar_iglesia_origen'); ?>";
        var iglesia_origen_destino = "<?php echo traducir('traductor.iglesia_origen_destino'); ?>";
        var imprimir_carta_iglesia = "<?php echo traducir('traductor.imprimir_carta_iglesia'); ?>";
        var mensaje = "<?php echo traducir('traductor.mensaje'); ?>";
        var alerta = "<?php echo traducir('traductor.alerta'); ?>";
        var dar_alta = "<?php echo traducir('traductor.dar_alta'); ?>";
        var dar_baja = "<?php echo traducir('traductor.dar_baja'); ?>";
        var imprimir_ficha = "<?php echo traducir('traductor.imprimir_ficha'); ?>";
        var estado_activo = "<?php echo traducir('traductor.estado_activo'); ?>";
        var estado_inactivo = "<?php echo traducir('traductor.estado_inactivo'); ?>";
        var seleccionar_menos_asociado = "<?php echo traducir('traductor.seleccionar_menos_asociado'); ?>";
        var imprimir_listado_delegados = "<?php echo traducir('asambleas.imprimir_listado_delegados'); ?>";
        var registro_estado_enviado_traduccion = "<?php echo traducir('asambleas.registro_estado_enviado_traduccion'); ?>";
        var registro_estado_terminado = "<?php echo traducir('asambleas.registro_estado_terminado'); ?>";
        var espaniol = "<?php echo traducir('asambleas.espaniol'); ?>";
        var ingles = "<?php echo traducir('asambleas.ingles'); ?>";
        var frances = "<?php echo traducir('asambleas.frances'); ?>";
        var convocatoria = "<?php echo traducir('asambleas.convocatoria'); ?>";
        var idioma = "<?php echo traducir('traductor.idioma'); ?>";
        var correlativo = "<?php echo traducir('asambleas.correlativo'); ?>";
        var de_traducir = "<?php echo traducir('asambleas.de_traducir'); ?>";
        var a = "<?php echo traducir('asambleas.a'); ?>";
        var descripcion = "<?php echo traducir('traductor.descripcion'); ?>";
        var estado = "<?php echo traducir('traductor.estado'); ?>";
        var registro_traduccion_terminado = "<?php echo traducir('asambleas.registro_traduccion_terminado'); ?>";
        var registro_enviado_traduccion = "<?php echo traducir('asambleas.registro_enviado_traduccion'); ?>";
        var notifico_correctamente = "<?php echo traducir('asambleas.notifico_correctamente'); ?>";
        var no_hay_resultados = "<?php echo traducir('asambleas.no_hay_resultados'); ?>";
        var propuesta_inactiva = "<?php echo traducir('asambleas.propuesta_inactiva'); ?>";
        var no_guardar_resolucion_sin_resultados = "<?php echo traducir('asambleas.no_guardar_resolucion_sin_resultados'); ?>";
        var guardar_resolucion = "<?php echo traducir('asambleas.guardar_resolucion'); ?>";
        var votacion_abierta = "<?php echo traducir('asambleas.votacion_abierta'); ?>";
        var votacion_cerrada = "<?php echo traducir('asambleas.votacion_cerrada'); ?>";
        var votacion_fuera_de_fecha = "<?php echo traducir('asambleas.votacion_fuera_de_fecha'); ?>";

        var img_activos = "<?php echo '<img style=\'width: 19px; height: 20px;\' src=\"'.URL::asset('images/iconos/cheque.png').'\"><br>'; ?>";
        var img_inactivos = "<?php echo '<img style=\'width: 19px; height: 20px;\' src=\"'.URL::asset('images/iconos/inactivo.png').'\"><br>'; ?>";
        var img_printer = "<?php echo '<img style=\'width: 20px; height: 20px;\' src=\"'.URL::asset('images/iconos/printer.png').'\"><br>'; ?>";
        var img_print = "<?php echo '<img style=\'width: 20px; height: 20px;\' src=\"'.URL::asset('images/iconos/print.png').'\"><br>'; ?>";
        var img_baja = "<?php echo '<img style=\'width: 20px; height: 20px;\' src=\"'.URL::asset('images/iconos/baja.png').'\"><br>'; ?>";
        var img_alta = "<?php echo '<img style=\'width: 20px; height: 20px;\' src=\"'.URL::asset('images/iconos/alta.png').'\"><br>'; ?>";
    </script>

    <!-- jQuery 3 -->
    <script src="{{ URL::asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->

    <script src="{{ URL::asset('dist/js/demo.js') }}"></script>
     <script src="{{ URL::asset('dist/js/jquery.dataTables.min.js') }}"></script>
    <!-- <script src="{{ URL::asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script> -->
    <script src="{{ URL::asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ URL::asset('sweetalert/dist/sweetalert.min.js') }}"></script>

    <script src="{{ URL::asset('notifyjs/dist/notify.min.js') }}"></script>
    <script src="{{ URL::asset('notifications/notify-metro.js') }}"></script>
    <script src="{{ URL::asset('notifications/notifications.js') }}"></script>


    <script src="{{ URL::asset('selectize/selectize.js') }}"></script>


    <script src="{{ URL::asset('plugins/iCheck/icheck.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ URL::asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ URL::asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ URL::asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ URL::asset('bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('bower_components/modal-effect/js/classie.js') }}"></script>
    <script src="{{ URL::asset('bower_components/modal-effect/js/modalEffects.js') }}"></script>

    <script src="{{ URL::asset('dist/js/highcharts.js') }}"></script>
    <script src="{{ URL::asset('app/js/layout.js') }}"></script>
    <!-- libreria para los sockets -->
    <script src="{{ URL::asset('dist/js/socket.io-2.3.0.js') }}"></script>

    <script src="{{ URL::asset('app/js/BASE_JS.js?version=051020210813') }}"></script>
    <script src="{{ URL::asset('app/js/participantes.js?version=051020210813') }}"></script>


    @isset($scripts)

        @foreach ($scripts as $script)
            <script src="{{ $script }}"></script>
        @endforeach

    @endisset


    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree()
        })
    </script>
</body>


</html>
