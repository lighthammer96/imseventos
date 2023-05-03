var programas = new BASE_JS('programas', 'programas');
var principal = new BASE_JS('principal', 'principal');


document.addEventListener("DOMContentLoaded", function() {


    programas.TablaListado({
        tablaID: '#tabla-programas',
        url: "/buscar_datos",
    });

    programas.select_init({
        placeholder: seleccione,
    })


    $("input[name=programa_fecha]").attr("data-inputmask", "'alias': 'dd/mm/yyyy'");
    $("input[name=programa_fecha]").inputmask();

    jQuery( "input[name=programa_fecha]" ).datepicker({
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
            case 'nuevo-programa':
                event.preventDefault();

                programas.abrirModal();
            break;

            case 'modificar-programa':
                event.preventDefault();

                modificar_programa();
            break;

            case 'eliminar-programa':
                event.preventDefault();
                eliminar_programa();
            break;

            case 'guardar-programa':
                event.preventDefault();
                guardar_programa();
            break;

        }

    })



    function modificar_programa() {

        var datos = programas.datatable.row('.selected').data();
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        var promise = programas.get(datos.programa_id);
        promise.then(function(response) {



        })
    }

    function guardar_programa() {


        var required = true;

        required = required && programas.required("evento_id");
        required = required && programas.required("programa_descripcion");
        required = required && programas.required("tp_id");
        required = required && programas.required("programa_fecha");

        if(required) {
            var promise = programas.guardar();
            programas.CerrarModal();
            promise.then(function(response) {
                if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                    return false;
                }

            })

        }
    }

    function eliminar_programa() {
        var datos = programas.datatable.row('.selected').data();
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
                programas.Operacion(datos.programa_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function(event) {
            // alert(modulo_controlador);
        if(modulo_controlador == "programas/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-programas').is(':visible')) {

                switch (event.code) {
                    case 'F1':

                        programas.abrirModal();
                        event.preventDefault();
                        event.stopPropagation();
                        break;
                    case 'F2':
                        modificar_programa();
                        event.preventDefault();
                        event.stopPropagation();
                        break;

                    case 'F7':
                        eliminar_programa();
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

                if($('#modal-programas').is(':visible')) {
                    guardar_programa();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-programa").addEventListener("click", function(event) {
        event.preventDefault();
        programas.CerrarModal();
    })



    document.getElementById("calendar-programa_fecha").addEventListener("click", function(e) {
        e.preventDefault();


        if($("input[name=programa_fecha]").hasClass("focus-datepicker")) {

            $("input[name=programa_fecha]").blur();
            $("input[name=programa_fecha]").removeClass("focus-datepicker");
        } else {

            $("input[name=programa_fecha]").focus();
            $("input[name=fechanacimiento]").addClass("focus-datepicker");
        }

    });





})
