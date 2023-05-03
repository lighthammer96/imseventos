var participantes = new BASE_JS('participantes', 'participantes');
var principal = new BASE_JS('principal', 'principal');
var eventos = new BASE_JS('eventos', 'eventos');

// console.log(session['iddivision']);
document.addEventListener("DOMContentLoaded", function () {
    // participantes.buscarEnFormulario("descripcion").solo_letras();
    // participantes.buscarEnFormulario("tipoestructura").solo_letras();
    // participantes.buscarEnFormulario("telefono").solo_numeros();

    // $(function() {
    //     $('input[type="radio"], input[type="checkbox"]').iCheck({
    //         checkboxClass: 'icheckbox_minimal-blue',
    //         radioClass   : 'iradio_minimal-blue'
    //     })
    // })

    $('input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
    })

    participantes.TablaListado({
        tablaID: '#tabla-participantes',
        url: "/buscar_datos",
    });

    participantes.select_init({
        placeholder: seleccione,
    })

    $("input[name=participante_fecha_nacimiento], input[name=participante_fecha_llegada], input[name=participante_fecha_retorno]").attr("data-inputmask", "'alias': 'dd/mm/yyyy'");
    $("input[name=participante_fecha_nacimiento]").inputmask();
    $("input[name=participante_fecha_llegada]").inputmask();
    $("input[name=participante_fecha_retorno]").inputmask();

    jQuery("input[name=participante_fecha_nacimiento], input[name=participante_fecha_llegada], input[name=participante_fecha_retorno]").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
        endDate: "now()",

    });


    $('input[name=participante_hora_llegada], input[name=participante_hora_retorno]').inputmask("hh:mm", {
        placeholder: "HH:MM",
        insertMode: false,
        showMaskOnHover: false,
        hourFormat: 12
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

    $(document).on("click", ".evento", function (event) {
        var evento_id = $(this).attr("evento_id");
        var evento = $(this).attr("evento");

        $("#modal-eventos").modal("hide");
        participantes.abrirModal();
        participantes.buscarEnFormulario("evento_id").value = evento_id;
        document.getElementById("evento-texto").innerText = evento;
    });

    document.addEventListener("click", function (event) {
        var id = event.srcElement.id;
        if (id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nuevo-participante':
                event.preventDefault();

                modal_eventos();

                // document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/images/camara.png");
                // document.getElementsByClassName("qr")[0].style.display = "none";
                // participantes.abrirModal();
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
        if (typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        var promise = participantes.get(datos.participante_id);
        promise.then(function (response) {

            if (response.participante_codigoqr_ruta != null) {
                document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/QR/" + response.participante_codigoqr_ruta);
            } else {
                document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/images/camara.png");
            }

            document.getElementById("descargar_pdf").setAttribute("download", response.participante_codigoqr + ".pdf");
            document.getElementById("descargar_pdf").setAttribute("href", BaseUrl + "/PDF/" + response.participante_codigoqr + ".pdf");
            document.getElementById("evento-texto").innerText = response.evento_descripcion;
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

        if (participante_correo != "") {
            required = required && participantes.validar_email("participante_correo");
        }


        if (required) {
            var promise = participantes.guardar();
            promise.then(function (response) {
                if (typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                    return false;
                }

            })

        }
    }

    function eliminar_participante() {
        var datos = participantes.datatable.row('.selected').data();
        if (typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });
            return false;
        }
        BASE_JS.sweet({
            confirm: true,
            text: eliminar_registro,
            callbackConfirm: function () {
                participantes.Operacion(datos.participante_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function (event) {
        // alert(modulo_controlador);
        if (modulo_controlador == "participantes/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if (!$('#modal-participantes').is(':visible')) {

                switch (event.code) {
                    case 'F1':

                        // participantes.abrirModal();
                        modal_eventos();
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
                if (event.code == "F4" || event.code == "F5") {
                    event.preventDefault();
                    event.stopPropagation();
                }
            }

            if (event.code == "F3") {
                //PARA LOS BUSCADORES DE LOS DATATABLES
                var inputs = document.getElementsByTagName("input");
                for (let index = 0; index < inputs.length; index++) {
                    // console.log(inputs[index].getAttribute("type"));
                    if (inputs[index].getAttribute("type") == "search") {
                        inputs[index].focus();

                    }
                    //console.log(botones[index].getAttribute("tecla_rapida"));
                }
                event.preventDefault();
                event.stopPropagation();

            }

            if (event.code == "F9") {

                if ($('#modal-participantes').is(':visible')) {
                    guardar_participante();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-participante").addEventListener("click", function (event) {
        event.preventDefault();
        participantes.CerrarModal();
    })
    document.getElementById("cerrar-evento").addEventListener("click", function (event) {
        event.preventDefault();
        $("#modal-eventos").modal("hide");
    })




    document.getElementById("calendar-participante_fecha_nacimiento").addEventListener("click", function (e) {
        e.preventDefault();


        if ($("input[name=participante_fecha_nacimiento]").hasClass("focus-datepicker")) {

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


    document.getElementById("enviar_qr").addEventListener("click", function (e) {
        var participante_id = document.getElementsByName("participante_id")[0].value;
        var promise = participantes.ajax({
            url: '/enviar_qr',
            datos: { participante_id: participante_id }
        }).then(function (response) {
            if (response.result == "S") {
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

    // function calcular_edad(dateString) {
    //     let hoy = new Date()
    //     let fechaNacimiento = new Date(dateString)
    //     let edad = hoy.getFullYear() - fechaNacimiento.getFullYear()
    //     let diferenciaMeses = hoy.getMonth() - fechaNacimiento.getMonth()
    //     if (
    //         diferenciaMeses < 0 ||
    //         (diferenciaMeses === 0 && hoy.getDate() < fechaNacimiento.getDate())
    //     ) {
    //         edad--
    //     }
    //     return edad
    // }


    // function setear_edad(fecha_nacimiento) {
    //     var array = fecha_nacimiento.toString().split("/");
    //     // console.log(array[2]+"/"+array[1]+"/"+array[0]);
    //     // console.log(calcular_edad(array[2]+"/"+array[1]+"/"+array[0]));
    //     document.getElementsByName("participante_edad")[0].value =  calcular_edad(array[2]+"/"+array[1]+"/"+array[0]);
    //     document.getElementsByName("participante_edad")[0].select();
    // }
    // //
    // $(document).on("keydown", "input[name=participante_fecha_nacimiento]", function () {
    //     var participante_fecha_nacimiento = $(this).val();
    //     setear_edad(participante_fecha_nacimiento);
    // });


    // $(document).on("change", "input[name=participante_fecha_nacimiento]", function () {
    //     var participante_fecha_nacimiento = $(this).val();
    //     setear_edad(participante_fecha_nacimiento);
    // });
    document.getElementById("time-participante_hora_llegada").addEventListener("click", function(e) {
        e.preventDefault();

        if($("input[name=participante_hora_llegada]").hasClass("focus-time")) {

            $("input[name=participante_hora_llegada]").blur();
            $("input[name=participante_hora_llegada]").removeClass("focus-time");
        } else {

            $("input[name=participante_hora_llegada]").focus();
            $("input[name=participante_hora_llegada]").addClass("focus-time");
        }

    });

    document.getElementById("time-participante_hora_retorno").addEventListener("click", function(e) {
        e.preventDefault();

        if($("input[name=participante_hora_retorno]").hasClass("focus-time")) {

            $("input[name=participante_hora_retorno]").blur();
            $("input[name=participante_hora_retorno]").removeClass("focus-time");
        } else {

            $("input[name=participante_hora_retorno]").focus();
            $("input[name=participante_hora_retorno]").addClass("focus-time");
        }

    });


})
