var participantes = new BASE_JS('participantes', 'participantes');
var principal = new BASE_JS('principal', 'principal');
var divisiones = new BASE_JS('divisiones', 'divisiones');
var paises = new BASE_JS('paises', 'paises');
var uniones = new BASE_JS('uniones', 'uniones');
var misiones = new BASE_JS('misiones', 'misiones');
var distritos_misioneros = new BASE_JS('distritos_misioneros', 'distritos_misioneros');
// console.log(session['iddivision']);
document.addEventListener("DOMContentLoaded", function() {
    // participantes.buscarEnFormulario("descripcion").solo_letras();
    // participantes.buscarEnFormulario("tipoestructura").solo_letras();
    // participantes.buscarEnFormulario("telefono").solo_numeros();

    participantes.TablaListado({
        tablaID: '#tabla-participantes',
        url: "/buscar_datos",
    });

    participantes.select_init({
        placeholder: seleccione,
    })

    $("input[name=participante_fecha_nacimiento]").attr("data-inputmask", "'alias': 'dd/mm/yyyy'");
    $("input[name=participante_fecha_nacimiento]").inputmask();

    jQuery( "input[name=participante_fecha_nacimiento]" ).datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
        endDate: "now()",

    });

    document.addEventListener("click", function(event) {
        var id = event.srcElement.id;
        if(id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nuevo-participante':
                event.preventDefault();
                document.getElementById("cargar_qr").setAttribute("src", BaseUrl+"/images/camara.png");
                document.getElementsByClassName("qr")[0].style.display = "none";
                participantes.abrirModal();
            break;

            case 'modificar-participante':
                event.preventDefault();

                modificar_participante();
            break;

            case 'eliminar-participante':
                event.preventDefault();
                eliminar_participante();
            break;

            case 'guardar-participante':
                event.preventDefault();
                guardar_participante();
            break;

        }

    })



    function modificar_participante() {
        document.getElementsByClassName("qr")[0].style.display = "block";
        var datos = participantes.datatable.row('.selected').data();
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        var promise = participantes.get(datos.participante_id);
        promise.then(function(response) {

            if(response.participante_codigoqr_ruta != null) {
                document.getElementById("cargar_qr").setAttribute("src", BaseUrl+"/QR/"+response.participante_codigoqr_ruta);
            } else {
                document.getElementById("cargar_qr").setAttribute("src", BaseUrl+"/images/camara.png");
            }

            document.getElementById("descargar_pdf").setAttribute("download", response.participante_codigoqr +".pdf");
            document.getElementById("descargar_pdf").setAttribute("href", BaseUrl+"/PDF/"+response.participante_codigoqr +".pdf");

        })
    }

    function guardar_participante() {


        var participante_correo = document.getElementsByName("participante_correo")[0].value;


        var required = true;

        required = required && participantes.required("participante_nombres");
        required = required && participantes.required("participante_apellidos");

        // required = required && participantes.required("idtipodoc");
        // required = required && participantes.required("participante_nrodoc");
        required = required && participantes.required("participante_celular");

        if(participante_correo != "") {
            required = required && participantes.validar_email("participante_correo");
        }


        if(required) {
            var promise = participantes.guardar();
            promise.then(function(response) {
                if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                    return false;
                }

            })

        }
    }

    function eliminar_participante() {
        var datos = participantes.datatable.row('.selected').data();
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
                participantes.Operacion(datos.participante_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function(event) {
            // alert(modulo_controlador);
        if(modulo_controlador == "participantes/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-participantes').is(':visible')) {

                switch (event.code) {
                    case 'F1':

                        participantes.abrirModal();
                        event.preventDefault();
                        event.stopPropagation();
                        break;
                    case 'F2':
                        modificar_participante();
                        event.preventDefault();
                        event.stopPropagation();
                        break;

                    case 'F7':
                        eliminar_participante();
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

                if($('#modal-participantes').is(':visible')) {
                    guardar_participante();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-participante").addEventListener("click", function(event) {
        event.preventDefault();
        participantes.CerrarModal();
    })



    document.getElementById("calendar-participante_fecha_nacimiento").addEventListener("click", function(e) {
        e.preventDefault();


        if($("input[name=participante_fecha_nacimiento]").hasClass("focus-datepicker")) {

            $("input[name=participante_fecha_nacimiento]").blur();
            $("input[name=participante_fecha_nacimiento]").removeClass("focus-datepicker");
        } else {

            $("input[name=participante_fecha_nacimiento]").focus();
            $("input[name=fechanacimiento]").addClass("focus-datepicker");
        }

    });

    // document.getElementById("descargar_pdf").addEventListener("click", function(e) {
    //     e.preventDefault();
    //     $("#formulario-participantes").attr("action", BaseUrl + "/participantes/generar_pdf_qr");
    //     $("#formulario-participantes").attr("method", "GET");
    //     $("#formulario-participantes").attr("target", "participantes");


    //     window.open('', 'participantes');
    //     document.getElementById('formulario-participantes').submit();



    // });


    document.getElementById("enviar_qr").addEventListener("click", function(e) {
        var participante_id = document.getElementsByName("participante_id")[0].value;
        var promise = participantes.ajax({
            url: '/enviar_qr',
            datos: { participante_id: participante_id }
        }).then(function(response) {
            if(response.result == "S") {
                BASE_JS.sweet({
                    text: "¡El correo se envió correctamente!"
                });
            } else {
                BASE_JS.sweet({
                    text: response.msg
                });
            }

            // console.log(response);
        })
    })



})
