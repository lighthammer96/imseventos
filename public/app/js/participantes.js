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

    $("input[name=participante_fecha_nacimiento], input[name=registro_fecha_llegada], input[name=registro_fecha_retorno]").attr("data-inputmask", "'alias': 'dd/mm/yyyy'");
    $("input[name=participante_fecha_nacimiento]").inputmask();
    $("input[name=registro_fecha_llegada]").inputmask();
    $("input[name=registro_fecha_retorno]").inputmask();

    jQuery("input[name=participante_fecha_nacimiento]").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
        endDate: "now()",

    });

    jQuery("input[name=registro_fecha_llegada], input[name=registro_fecha_retorno]").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,


    });


    $('input[name=registro_hora_llegada], input[name=registro_hora_retorno]').inputmask("hh:mm", {
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

    document.addEventListener("click", function (event) {
        var id = event.srcElement.id;
        if (id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nuevo-participante':
                event.preventDefault();

                // modal_eventos();

                // document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/images/camara.png");
                // document.getElementsByClassName("qr")[0].style.display = "none";
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




        // document.getElementsByClassName("qr")[0].style.display = "block";
        document.getElementsByName("operacion")[0].setAttribute("default-value", "MODIFICAR");
        var datos = participantes.datatable.row('.selected').data();
        if (typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        var promise = participantes.get(datos.participante_id);
        promise.then(function (response) {


            // document.getElementById("evento-texto").innerText = response.evento_descripcion;
            // $("#evento_id").selectize()[0].selectize.lock();
            eventos.ajax({
                url: '/obtener_eventos_segun_participante_registro',
                datos: { participante_id: response.participante_id, registro_id: response.registro_id_ultimo }
            }).then(function(res) {
                var array = [];
                for(let i = 0; i < res.length; i++){
                    array.push(res[i].evento_id);
                }

                eventos.select({
                    name: 'evento_id[]',
                    url: '/obtener_todos_eventos',
                    placeholder: "Seleccione ...",

                }).then(function() {
                    $("#evento_id")[0].selectize.setValue(array);
                });

            })
        })
    }

    function guardar_participante() {
        var registro_correo = document.getElementsByName("registro_correo")[0].value;
        var required = true;

        var url = window.location;
        var array_url = url.pathname.split("/");

        if(array_url[array_url.length - 1] == "formulario_vuelos" && participantes.buscarEnFormulario("participante_id").value == "") {
            BASE_JS.sweet({
                text: "Por medio de este formulario no se permiten realizar nuevos registros, solo modificar datos de vuelo de participantes registrados!"
            });
            return false;
        } else {

            required = required && participantes.required("evento_id[]");


        }



        required = required && participantes.required("participante_nombres");
        required = required && participantes.required("participante_apellidos");

        // required = required && participantes.required("idtipodoc");
        // required = required && participantes.required("participante_nrodoc");
        required = required && participantes.required("registro_celular");

        if (registro_correo != "") {
            required = required && participantes.validar_email("registro_correo");
        } else {
            required = required && participantes.required("registro_correo");
        }





        if (required) {
            var promise = participantes.guardar();
            promise.then(function (response) {
                if (typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                    return false;
                }

                obtener_eventos_segun_participante_registro(response);

            })

        }
    }

    function eliminar_participante() {
        var datos = participantes.datatable.row('.selected').data();
        // console.log(datos);
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
                        // document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/images/camara.png");
                        // document.getElementsByClassName("qr")[0].style.display = "none";

                        participantes.abrirModal();
                        // modal_eventos();
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

    $(document).on("click", "#cancelar-participante", function (event) {
        event.preventDefault();
        participantes.CerrarModal();
    });

    $(document).on("click", "#cerrar-evento", function (event) {
        event.preventDefault();
        $("#modal-eventos").modal("hide");
    });


    $(document).on("click", "#cancelar-ver-evento", function (event) {
        event.preventDefault();
        $("#modal-ver-evento").modal("hide");
    });

    $(document).on("click", "#cancelar-eventos-participante", function (event) {
        event.preventDefault();
        $("#modal-eventos-participante").modal("hide");
    });


    // document.getElementById("cancelar-participante").addEventListener("click", function (event) {
    //     event.preventDefault();
    //     participantes.CerrarModal();
    // })
    // document.getElementById("cerrar-evento").addEventListener("click", function (event) {
    //     event.preventDefault();
    //     $("#modal-eventos").modal("hide");
    // })

    // document.getElementById("cancelar-ver-evento").addEventListener("click", function (event) {
    //     event.preventDefault();
    //     $("#modal-ver-evento").modal("hide");
    // })

    // document.getElementById("cancelar-eventos-participante").addEventListener("click", function (event) {
    //     event.preventDefault();
    //     $("#modal-eventos-participante").modal("hide");
    // })




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
    $(document).on("click", "#enviar_qr", function (event) {
        var participante_id = $(this).attr("participante_id");
        var evento_id = $(this).attr("evento_id");
        var registro_id = $(this).attr("registro_id");
        var promise = participantes.ajax({
            url: '/enviar_qr',
            datos: { participante_id: participante_id, evento_id: evento_id, registro_id: registro_id }
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

    // document.getElementById("enviar_qr").addEventListener("click", function (e) {

    // })

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

    $(document).on("click", "#time-registro_hora_llegada", function (event) {
        event.preventDefault();

        if($("input[name=registro_hora_llegada]").hasClass("focus-time")) {

            $("input[name=registro_hora_llegada]").blur();
            $("input[name=registro_hora_llegada]").removeClass("focus-time");
        } else {

            $("input[name=registro_hora_llegada]").focus();
            $("input[name=registro_hora_llegada]").addClass("focus-time");
        }
    })

    $(document).on("click", "#time-registro_hora_retorno", function (event) {
        event.preventDefault();

        if($("input[name=registro_hora_retorno]").hasClass("focus-time")) {

            $("input[name=registro_hora_retorno]").blur();
            $("input[name=registro_hora_retorno]").removeClass("focus-time");
        } else {

            $("input[name=registro_hora_retorno]").focus();
            $("input[name=registro_hora_retorno]").addClass("focus-time");
        }

    })


    function validar_duplicacidad() {
        var url = window.location;
        var array_url = url.pathname.split("/")
        // console.log(url.pathname.split("/"));
        var idpais = participantes.buscarEnFormulario("idpais").value;
        var idtipodoc = participantes.buscarEnFormulario("idtipodoc").value;
        var participante_nrodoc = participantes.buscarEnFormulario("participante_nrodoc").value;
        var required = true;
        required = required && participantes.required("idpais");
        required = required && participantes.required("idtipodoc");
        if(required) {
            var promise = participantes.ajax({
                url: '/validar_participante_segun_nrodoc',
                datos: { idpais: idpais, idtipodoc: idtipodoc, participante_nrodoc: participante_nrodoc }
            }).then(function (response) {
                if(response.participante.length > 0) {

                    var promise = participantes.get(response.participante[0].participante_id);
                    if(array_url[array_url.length - 1] == "formulario_vuelos") {
                        eventos.ajax({
                            url: '/obtener_eventos_segun_participante_registro',
                            datos: { participante_id: response.participante[0].participante_id, registro_id: response.participante[0].registro_id_ultimo }
                        }).then(function(res) {
                            var array = [];
                            for(let i = 0; i < res.length; i++){
                                array.push(res[i].evento_id);
                            }

                            eventos.select({
                                name: 'evento_id[]',
                                url: '/obtener_todos_eventos',
                                placeholder: "Seleccione ...",

                            }).then(function() {
                                $("#evento_id")[0].selectize.setValue(array);
                                $('#evento_id')[0].selectize.disable();
                            });

                        })
                        return false;
                    }
                    promise.then(function() {
                        if(response.eventos.length > 0) {
                            BASE_JS.sweet({
                                text: '¡AUN TIENE EVENTOS ASIGNADOS ACTIVOS!'
                            });
                            // document.getElementById("guardar-participante").disabled = true;
                            $("#guardar-participante").prop("disabled", true);
                            // console.log(document.getElementById("guardar-participante").disabled)
                        } else {
                            // document.getElementById("guardar-participante").disabled = false;
                            $("#guardar-participante").prop("disabled", false);
                        }
                    })
                }




            //    console.log(response);

            })
        }
    }

    document.getElementsByName("participante_nrodoc")[0].addEventListener("keydown", function(e) {
        // e.preventDefault();
        if(e.key == "Enter") {
            validar_duplicacidad();
        }

    })

    document.getElementsByName("participante_nrodoc")[0].addEventListener("change", function(e) {
        // e.preventDefault();
        validar_duplicacidad();

    })

    function obtener_eventos_segun_participante_registro(datos) {
        eventos.ajax({
            url: '/obtener_eventos_segun_participante_registro',
            datos: { participante_id: datos.participante_id, registro_id: datos.registro_id_ultimo }
        }).then(function(response) {
            var html = "";
            var participante = "";
            if(response.length > 0) {
                for (let index = 0; index < response.length; index++) {
                    participante = response[index].participante_apellidos +", "+response[index].participante_nombres;
                    html += '<tr>';
                    html += '   <td>'+response[index].evento_descripcion+'</td>';
                    html += '   <td>'+response[index].evento_fecha_inicio+'</td>';
                    html += '   <td>'+response[index].evento_fecha_fin+'</td>';
                    html += '   <td><center><button evento_id="'+response[index].evento_id+'" registro_id="'+response[index].registro_id+'" participante_id="'+response[index].participante_id+'" type="button" title="Ver Evento" class="btn btn-xs btn-primary ver-evento" ><i class="fa fa-eye" aria-hidden="true"></i></button></center></td>';
                    html += '</tr>';

                }
                document.getElementById("participante").innerText = participante;
                document.getElementById("detalle-eventos").getElementsByTagName("tbody")[0].innerHTML = html;
            }
            $("#modal-eventos-participante").modal("show");
        })
    }

    $(document).on("click", "#ver-eventos", function (e) {
        e.preventDefault();

        var datos = participantes.datatable.row('.selected').data();
        if (typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        obtener_eventos_segun_participante_registro(datos);


    })



    $(document).on("click", ".ver-evento", function (e) {
        e.preventDefault();
        var evento_id = $(this).attr("evento_id");
        var registro_id = $(this).attr("registro_id");
        var participante_id = $(this).attr("participante_id");
        participantes.ajax({
            url: '/obtener_participante_segun_evento',
            datos: { evento_id: evento_id, registro_id: registro_id, participante_id: participante_id }
        }).then(function(response) {
            console.log(response);
            if(response.length > 0) {
                if (response[0].de_codigoqr_ruta != null) {
                    document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/QR/" + response[0].de_codigoqr_ruta);
                } else {
                    document.getElementById("cargar_qr").setAttribute("src", BaseUrl + "/images/camara.png");
                }

                document.getElementById("descargar_pdf").setAttribute("download", response[0].participante_apellidos + " " + response[0].participante_nombres + ".pdf");
                document.getElementById("descargar_pdf").setAttribute("href", BaseUrl + "/PDF/" + response[0].de_codigoqr + ".pdf");

                document.getElementById("evento").innerText = response[0].evento_descripcion;
                document.getElementById("enviar_qr").setAttribute("evento_id", evento_id);
                document.getElementById("enviar_qr").setAttribute("registro_id", registro_id);
                document.getElementById("enviar_qr").setAttribute("participante_id", participante_id);
            }
            $("#modal-ver-evento").modal("show");
        })

    });



})
