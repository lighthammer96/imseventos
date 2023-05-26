var llegadas = new BASE_JS('llegadas', 'llegadas');

var principal = new BASE_JS('principal', 'principal');
var eventos = new BASE_JS('eventos', 'eventos');
var permisos = new BASE_JS('permisos', 'permisos');


document.addEventListener("DOMContentLoaded", function() {


    llegadas.TablaListado({
        tablaID: '#tabla-llegadas',
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




        llegadas.abrirModal();
        llegadas.buscarEnFormulario("evento_id").value = evento_id;


    });


    $(document).on("click", "#cerrar-evento", function (event) {
        event.preventDefault();
        $("#modal-eventos").modal("hide");
    });



    document.addEventListener("click", function(event) {
        var id = event.srcElement.id;
        if(id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nueva-llegada':
                event.preventDefault();
                modal_eventos();
                // llegadas.abrirModal();
            break;



            case 'eliminar-llegada':
                event.preventDefault();
                eliminar_llegada();
            break;

            case 'guardar-llegada':
                event.preventDefault();
                guardar_llegada();
            break;

        }

    })



    function guardar_llegada() {


        var required = true;

        required = required && llegadas.required("codigo_qr");


        if(required) {

            var promise = llegadas.guardar();
            llegadas.CerrarModal();
            promise.then(function(response) {
                // if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                //     return false;
                // }

                if(response.status == "i") {
                    if(response.delegado == "S") {
                        document.getElementById("delegado").innerText = "Delegado";
                    }
                    document.getElementById("participante").innerText = response.participante.participante_nombres+" "+response.participante.participante_apellidos;
                    document.getElementById("aerolinea").innerText = response.participante.registro_aerolinea;
                    document.getElementById("vuelo").innerText = response.participante.registro_nrovuelo;
                    document.getElementById("celular").innerText = response.participante.registro_celular;
                    document.getElementById("fecha-llegada").innerText = response.participante.registro_fecha_llegada;
                    document.getElementById("destino-llegada").innerText = response.participante.registro_destino_llegada;

                    $("#modal-registro").modal("show");
                }



                if(response.code == "asistencia_registrada") {

                    if(response.delegado == "S") {
                        document.getElementById("delegado_r").innerText = "(Delegado)";
                    }
                    document.getElementById("participante_r").innerText = response.participante.participante_nombres+" "+response.participante.participante_apellidos;
                    document.getElementById("aerolinea_r").innerText = response.participante.registro_aerolinea;
                    document.getElementById("vuelo_r").innerText = response.participante.registro_nrovuelo;
                    document.getElementById("celular_r").innerText = response.participante.registro_celular;
                    document.getElementById("fecha-llegada_r").innerText = response.participante.registro_fecha_llegada;
                    document.getElementById("destino-llegada_r").innerText = response.participante.registro_destino_llegada;
                    document.getElementById("usuario").innerText = response.asistencia.usuario_registro;
                    document.getElementById("fecha-hora").innerText = response.asistencia.fecha_registro;
                    $("#modal-registrado").modal("show");




                }

            })

        }
    }

    function eliminar_llegada() {
        var datos = llegadas.datatable.row('.selected').data();
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
                llegadas.Operacion(datos.asistencia_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function(event) {
            // alert(modulo_controlador);
        if(modulo_controlador == "llegadas/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-llegadas').is(':visible')) {

                switch (event.code) {
                    case 'F1':

                        llegadas.abrirModal();
                        event.preventDefault();
                        event.stopPropagation();
                        break;
                    // case 'F2':
                    //     modificar_evento();
                    //     event.preventDefault();
                    //     event.stopPropagation();
                    //     break;

                    case 'F7':
                        eliminar_llegada();
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

                if($('#modal-llegadas').is(':visible')) {
                    guardar_llegada();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-llegada").addEventListener("click", function(event) {
        event.preventDefault();
        llegadas.CerrarModal();
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


    // referencia https://github.com/schmich/instascan
    // console.log(BaseUrl);
    var sound = new Audio(BaseUrl+"/instascan/barcode.wav");
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
    scanner.addListener('scan', function (content, image) {
        // console.log(content);
        // console.log(image);
        sound.play();
        llegadas.buscarEnFormulario("codigo_qr").value = content;
        $("#modal-leer-qr").modal("hide");

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

    document.getElementById("volver-registro").addEventListener("click", function(event) {
        event.preventDefault();

        $("#modal-registro").modal("hide");
    })

    document.getElementById("volver-registrado").addEventListener("click", function(event) {
        event.preventDefault();
        $("#modal-registrado").modal("hide");
    })


})
