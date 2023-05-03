var eventos = new BASE_JS('eventos', 'eventos');
var principal = new BASE_JS('principal', 'principal');


document.addEventListener("DOMContentLoaded", function() {


    eventos.TablaListado({
        tablaID: '#tabla-eventos',
        url: "/buscar_datos",
    });

    eventos.select_init({
        placeholder: seleccione,
    })

    $("input[name=evento_fecha_inicio], input[name=evento_fecha_fin]").attr("data-inputmask", "'alias': 'dd/mm/yyyy'");
    $("input[name=evento_fecha_inicio], input[name=evento_fecha_fin]").inputmask();

    jQuery( "input[name=evento_fecha_inicio], input[name=evento_fecha_fin]" ).datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
    });

    document.addEventListener("click", function(event) {
        var id = event.srcElement.id;
        if(id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nuevo-evento':
                event.preventDefault();

                eventos.abrirModal();
            break;

            case 'modificar-evento':
                event.preventDefault();

                modificar_evento();
            break;

            case 'eliminar-evento':
                event.preventDefault();
                eliminar_evento();
            break;

            case 'guardar-evento':
                event.preventDefault();
                guardar_evento();
            break;

        }

    })



    function modificar_evento() {

        var datos = eventos.datatable.row('.selected').data();
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        var promise = eventos.get(datos.evento_id);
        promise.then(function(response) {



        })
    }

    function guardar_evento() {


        var required = true;

        required = required && eventos.required("evento_descripcion");
        required = required && eventos.required("evento_fecha_inicio");
        required = required && eventos.required("evento_fecha_fin");

        if(required) {
            var promise = eventos.guardar();
            eventos.CerrarModal();
            promise.then(function(response) {
                if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                    return false;
                }

            })

        }
    }

    function eliminar_evento() {
        var datos = eventos.datatable.row('.selected').data();
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
                eventos.Operacion(datos.evento_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function(event) {
            // alert(modulo_controlador);
        if(modulo_controlador == "eventos/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-eventos').is(':visible')) {

                switch (event.code) {
                    case 'F1':

                        eventos.abrirModal();
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

                if($('#modal-eventos').is(':visible')) {
                    guardar_evento();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-evento").addEventListener("click", function(event) {
        event.preventDefault();
        eventos.CerrarModal();
    })



    document.getElementById("calendar-evento_fecha_inicio").addEventListener("click", function(e) {
        e.preventDefault();


        if($("input[name=evento_fecha_inicio]").hasClass("focus-datepicker")) {

            $("input[name=evento_fecha_inicio]").blur();
            $("input[name=evento_fecha_inicio]").removeClass("focus-datepicker");
        } else {

            $("input[name=evento_fecha_inicio]").focus();
            $("input[name=fechanacimiento]").addClass("focus-datepicker");
        }

    });

    document.getElementById("calendar-evento_fecha_fin").addEventListener("click", function(e) {
        e.preventDefault();


        if($("input[name=evento_fecha_fin]").hasClass("focus-datepicker")) {

            $("input[name=evento_fecha_fin]").blur();
            $("input[name=evento_fecha_fin]").removeClass("focus-datepicker");
        } else {

            $("input[name=evento_fecha_fin]").focus();
            $("input[name=fechanacimiento]").addClass("focus-datepicker");
        }

    });



})
