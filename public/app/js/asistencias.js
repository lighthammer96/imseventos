var asistencias = new BASE_JS('asistencias', 'asistencias');
var programas = new BASE_JS('programas', 'programas');
var principal = new BASE_JS('principal', 'principal');
var eventos = new BASE_JS('eventos', 'eventos');
var permisos = new BASE_JS('permisos', 'permisos');


document.addEventListener("DOMContentLoaded", function() {


    asistencias.TablaListado({
        tablaID: '#tabla-asistencias',
        url: "/buscar_datos",
    });


    function modal_eventos() {
        var promise = eventos.ajax({
            url: '/obtener_eventos',
            datos: {}
        }).then(function (response) {
            var html = '';
            for (let index = 0; index < response.length; index++) {
                html += '<div class="col-md-4"><div class="evento" evento_id="' + response[index].id + '" evento="' + response[index].descripcion + '">' + response[index].descripcion + '</div></div>';


            }
            $("#eventos").html(html);
            $("#modal-eventos").modal("show");

        })
    }

    $(document).on("click", ".evento", function (e) {
        var evento_id = $(this).attr("evento_id");

        var promise = programas.ajax({
            url: '/obtener_programas_segun_tipo',
            datos: { evento_id: evento_id }
        }).then(function (response) {
            // console.log(response);
            var html_coliseo = '';
            var html_alimentos = '';
            document.getElementById("evento").innerText = response['evento'][0].evento_descripcion;

            for (let index = 0; index < response["coliseo"].length; index++) {
                html_coliseo += '<div class="col-md-12"><div class="programa" evento_id="' + response["coliseo"][index].evento_id + '" programa_id="' + response["coliseo"][index].programa_id + '" programa="' + response["coliseo"][index].programa_descripcion + '">' + response["coliseo"][index].programa_descripcion + '</div></div>';


            }

            for (let index = 0; index < response["alimentos"].length; index++) {
                html_alimentos += '<div class="col-md-12"><div class="programa" evento_id="' + response["alimentos"][index].evento_id + '" programa_id="' + response["alimentos"][index].programa_id + '" programa="' + response["alimentos"][index].programa_descripcion + '">' + response["alimentos"][index].programa_descripcion + '</div></div>';


            }
            $("#coliseo").html(html_coliseo);
            $("#alimentos").html(html_alimentos);
            $("#modal-programas").modal("show");

        })

    });

    $(document).on("click", ".programa", function (e) {
        var evento_id = $(this).attr("evento_id");
        var programa_id = $(this).attr("programa_id");

        asistencias.abrirModal();
        asistencias.buscarEnFormulario("evento_id").value = evento_id;
        asistencias.buscarEnFormulario("programa_id").value = programa_id;
    })

    $(document).on("click", "#cerrar-evento", function (event) {
        event.preventDefault();
        $("#modal-eventos").modal("hide");
    });

    $(document).on("click", "#cerrar-programa", function (event) {
        event.preventDefault();
        $("#modal-programas").modal("hide");
    });

    document.addEventListener("click", function(event) {
        var id = event.srcElement.id;
        if(id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nueva-asistencia':
                event.preventDefault();
                modal_eventos();
                // asistencias.abrirModal();
            break;



            case 'eliminar-asistencia':
                event.preventDefault();
                eliminar_evento();
            break;

            case 'guardar-asistencia':
                event.preventDefault();
                guardar_asistencia();
            break;

        }

    })



    function guardar_asistencia() {


        var required = true;

        required = required && asistencias.required("codigo_qr");


        if(required) {
            // var evento_id = asistencias.buscarEnFormulario("evento_id").value;
            // var programa_id = asistencias.buscarEnFormulario("programa_id").value;
            // var codigo_qr = asistencias.buscarEnFormulario("codigo_qr").value;
            // var promise = asistencias.ajax({
            //     url: '/guardar_asistencias',
            //     datos: { evento_id: evento_id, programa_id: programa_id, codigo_qr: codigo_qr }
            // }).then(function (response) {

            // })
            var promise = asistencias.guardar();
            asistencias.CerrarModal();
            promise.then(function(response) {
                // if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                //     return false;
                // }

                msg = "Asistencia Registrada \n"+response["participante"].participante_nombres+" "+response["participante"].participante_apellidos;

                if(response.delegado == "S") {
                    msg = "Asistencia Registrada \n"+response["participante"].participante_nombres+" "+response["participante"].participante_apellidos+"\n Delegado: SI"
                }

                if(response.status == "i") {
                    BASE_JS.sweet({
                        text: msg
                    });
                }

                if(response.code == "asistencia_registrada") {
                    permisos.buscarEnFormulario("participante").value = response["participante"].participante_nombres+" "+response["participante"].participante_apellidos;
                    permisos.buscarEnFormulario("celular").value = response["participante"].registro_celular;
                    permisos.buscarEnFormulario("celular_emergencia").value = response["participante"].registro_celular_emergencia;
                    permisos.buscarEnFormulario("apoderado").value = response["participante"].registro_apoderado;
                    permisos.buscarEnFormulario("evento_id").value = response["participante"].evento_id;
                    permisos.buscarEnFormulario("programa_id").value = response["participante"].programa_id;
                    permisos.buscarEnFormulario("participante_id").value = response["participante"].participante_id;
                    html_detalle_permisos(response.permisos);
                    $("#modal-permisos").modal("show");

                }

            })

        }
    }

    function eliminar_evento() {
        var datos = asistencias.datatable.row('.selected').data();
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });
            return false;
        }
        BASE_JS.sweet({
            confirm: true,
            text: eliminar_registro,
            callbackConfirm: function() {
                asistencias.Operacion(datos.asistencia_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function(event) {
            // alert(modulo_controlador);
        if(modulo_controlador == "asistencias/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-asistencias').is(':visible')) {

                switch (event.code) {
                    case 'F1':

                        asistencias.abrirModal();
                        event.preventDefault();
                        event.stopPropagation();
                        break;
                    case 'F2':
                        modificar_evento();
                        event.preventDefault();
                        event.stopPropagation();
                        break;

                    case 'F7':
                        eliminar_evento();
                        event.preventDefault();
                        event.stopPropagation();

                        break;
                }

            } else {
                //NO HACER NADA EN CASO DE LAS TECLAS F4 ES QUE USUALMENTE ES PARA CERRAR EL NAVEGADOR Y EL F5 QUE ES PARA RECARGAR
                if(event.code == "F4" || event.code == "F5") {
                    event.preventDefault();
                    event.stopPropagation();
                }
            }

            if(event.code == "F3") {
                //PARA LOS BUSCADORES DE LOS DATATABLES
                var inputs = document.getElementsByTagName("input");
                for (let index = 0; index < inputs.length; index++) {
                    // console.log(inputs[index].getAttribute("type"));
                    if(inputs[index].getAttribute("type") == "search") {
                        inputs[index].focus();

                    }
                    //console.log(botones[index].getAttribute("tecla_rapida"));
                }
                event.preventDefault();
                event.stopPropagation();

            }

            if(event.code == "F9") {

                if($('#modal-asistencias').is(':visible')) {
                    guardar_asistencia();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-asistencia").addEventListener("click", function(event) {
        event.preventDefault();
        asistencias.CerrarModal();
    })

    document.getElementById("volver").addEventListener("click", function(event) {
        event.preventDefault();
        $("#modal-permisos").modal("hide");
    })

    function html_detalle_permisos(datos) {
        var html = '';
        for (let index = 0; index < datos.length; index++) {
           html += '<tr>';
           html += '    <td>'+datos[index].tipo_permiso+'</td>';
           html += '    <td>'+datos[index].fecha_registro+'</td>';
           html += '</tr>';

        }

        document.getElementById("detalle-permisos").getElementsByTagName("tbody")[0].innerHTML = html;
    }

    document.getElementById("permiso-salida").addEventListener("click", function(event) {
        event.preventDefault();
        var evento_id = permisos.buscarEnFormulario("evento_id").value;
        var programa_id = permisos.buscarEnFormulario("programa_id").value;
        var participante_id = permisos.buscarEnFormulario("participante_id").value;
        var tipo = "S";
        var promise = asistencias.ajax({
            url: '/guardar_permisos',
            datos: { evento_id:evento_id, programa_id: programa_id, participante_id: participante_id, tipo: tipo }
        }).then(function (response) {
            if(response.status == "i") {
                BASE_JS.sweet({
                    text: 'Permiso de SALIDA registrado'
                })
                html_detalle_permisos(response.permisos);
            } else {
                BASE_JS.sweet({
                    text: response.msg
                })
            }

        })

    })

    document.getElementById("permiso-entrada").addEventListener("click", function(event) {
        event.preventDefault();
        var evento_id = permisos.buscarEnFormulario("evento_id").value;
        var programa_id = permisos.buscarEnFormulario("programa_id").value;
        var participante_id = permisos.buscarEnFormulario("participante_id").value;
        var tipo = "E";
        var promise = asistencias.ajax({
            url: '/guardar_permisos',
            datos: { evento_id:evento_id, programa_id: programa_id, participante_id: participante_id, tipo: tipo }
        }).then(function (response) {
            if(response.status == "i") {
                BASE_JS.sweet({
                    text: 'Permiso de ENTRADA registrado'
                })
                html_detalle_permisos(response.permisos);
            } else {
                BASE_JS.sweet({
                    text: response.msg
                })
            }

        })
    })

    document.getElementById("leer-qr").addEventListener("click", function(event) {
        event.preventDefault();
        // alert("hola");
        $("#modal-leer-qr").modal("show");
    })

    document.getElementsByName("codigo_qr")[0].addEventListener("keydown", function(event) {

        if(event.code == "Enter") {

            event.preventDefault();
        }
    })

    document.getElementById("cancelar-leer-qr").addEventListener("click", function(event) {
        event.preventDefault();
        $("#modal-leer-qr").modal("hide");
    })


    var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
    scanner.addListener('scan', function (content, image) {
        console.log(content);
        console.log(image);

    });

    var camaras = [];
    Instascan.Camera.getCameras().then(function (cameras) {
        // console.log(cameras);
        camaras = cameras;
        var options = '';
        for (let index = 0; index < cameras.length; index++) {
            options += '<option value="'+index+'">'+cameras[index].name+'</option>';

        }
        document.getElementById("camara").innerHTML = options;
        if (cameras.length > 0) {

            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });

    document.getElementById("camara").addEventListener("change", function(e) {
        scanner.start(camaras[this.value]);
    })


})
