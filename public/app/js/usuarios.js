
var usuarios = new BASE_JS('usuarios', 'usuarios');





document.addEventListener("DOMContentLoaded", function () {
    usuarios.select_init({
        placeholder: seleccione
    })
    var eventClick = new Event('click');


    usuarios.TablaListado({
        tablaID: '#tabla-usuarios',
        url: "/buscar_datos",
    });

    ;

    usuarios.enter("usuario_nombres", "usuario_user");
    usuarios.enter("usuario_user", "pass1");
    usuarios.enter("pass1", "pass2");
    usuarios.enter("pass2", "perfil_id");


    document.getElementById("nuevo-usuario").addEventListener("click", function (event) {
        event.preventDefault();

        usuarios.abrirModal();
        document.getElementById("buscar_asociado").disabled = false;
    })

    document.getElementById("modificar-usuario").addEventListener("click", function (event) {
        event.preventDefault();
        var datos = usuarios.datatable.row('.selected').data();
        if (typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });
            return false;
        }
        var promise = usuarios.get(datos.usuario_id);
        promise.then(function (response) {
            asociados.ajax({
                url: '/get_asociados',
                datos: { id: response.idmiembro }
            }).then(function (datos) {
                datos.idmiembro = datos[0].idmiembro;
                datos.asociado = datos[0].apellidos + ", " + datos[0].nombres;

                usuarios.asignarDatos(datos);
                document.getElementById("buscar_asociado").disabled = true;
            });

        })
    })

    document.getElementById("ver-usuario").addEventListener("click", function (event) {
        event.preventDefault();
        var datos = usuarios.datatable.row('.selected').data();
        if (typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });
            return false;
        }
        var promise = usuarios.ver(datos.usuario_id);
        promise.then(function (response) {
            asociados.ajax({
                url: '/get',
                datos: { id: response.idmiembro }
            }).then(function (datos) {
                datos.idmiembro = datos.idmiembro;
                datos.asociado = datos.apellidos + ", " + datos.nombres;

                usuarios.asignarDatos(datos);
            });

        })

    })


    document.getElementById("eliminar-usuario").addEventListener("click", function (event) {
        event.preventDefault();
        var datos = usuarios.datatable.row('.selected').data();
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
                usuarios.Operacion(datos.usuario_id, 'E');

            }
        });
    })

    document.getElementById("guardar-usuario").addEventListener("click", function (event) {
        event.preventDefault();
        var usuario_id = document.getElementsByName("usuario_id")[0].value;
        // alert(usuario_id);
        var required = true;
        // required = required && usuarios.required("usuario_nombres");
        // required = required && usuarios.required("asociado");
        required = required && usuarios.required("usuario_user");
        if (usuario_id == "") {
            required = required && usuarios.required("pass1");
            // required = required && usuarios.required("pass2");
        }

        required = required && usuarios.required("perfil_id");
        // required = required && usuarios.required("usuario_referencia");


        if (required) {
            usuarios.guardar();
            usuarios.CerrarModal();

        }
    })


    // $(document).on('change', 'input[name=usuario_user]', function() {
    //     usuarios.validarvalueexist("usuario_user","usuarios",$(this).val(),"Usuario");
    // });
    //
    // document.getElementsByName("pass1")[0].addEventListener("change", function(event) {
    //     var pass2 = document.getElementsByName("pass2")[0].value;

    //     var required = true;
    //     required = required && usuarios.required("pass1");
    //     required = required && usuarios.required("pass2");
    //     if(required) {
    //         if(this.value != pass2) {
    //             BASE_JS.notificacion({
    //                 msg: 'LAS CONTRASEÑAS NO COINCIDEN',
    //                 type: 'warning',
    //             });

    //             document.getElementById("guardar-usuario").disabled = true;
    //         } else {
    //             document.getElementById("guardar-usuario").disabled = false;
    //         }
    //     }

    // })

    // document.getElementsByName("pass2")[0].addEventListener("change", function(event) {
    //     var pass1 = document.getElementsByName("pass1")[0].value;
    //     var required = true;
    //     required = required && usuarios.required("pass1");
    //     required = required && usuarios.required("pass2");
    //     //alert(required);
    //     if(required) {
    //         if(this.value != pass1) {
    //             BASE_JS.notificacion({
    //                 type: 'warning',
    //                 msg: 'LAS CONTRASEÑAS NO COINCIDEN'
    //             });
    //             document.getElementById("guardar-usuario").disabled = true;
    //         } else {
    //             document.getElementById("guardar-usuario").disabled = false;
    //         }
    //     }
    // })


    document.addEventListener("keydown", function (event) {
        // alert(modulo_controlador);
        if (modulo_controlador == "usuarios/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if (!$('#modal-usuarios').is(':visible')) {
                var botones = document.getElementsByTagName("button");
                for (let index = 0; index < botones.length; index++) {
                    if (botones[index].getAttribute("tecla_rapida") != null) {
                        if (botones[index].getAttribute("tecla_rapida") == event.code) {
                            document.getElementById(botones[index].getAttribute("id")).dispatchEvent(eventClick);
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                    //console.log(botones[index].getAttribute("tecla_rapida"));
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

                if ($('#modal-usuarios').is(':visible')) {
                    document.getElementById('guardar-usuario').dispatchEvent(eventClick);
                }


                event.preventDefault();
                event.stopPropagation();
            }






        }


    })

    document.getElementById("cancelar-usuario").addEventListener("click", function (event) {
        event.preventDefault();
        usuarios.CerrarModal();
    })



    document.getElementById("buscar_asociado").addEventListener("click", function (event) {
        event.preventDefault();
        $("#modal-lista-asociados").modal("show");
    })


    function cargar_datos_asociado(datos) {
        usuarios.limpiarDatos("datos-asociado");
        //console.log(datos);
        usuarios.asignarDatos({
            idmiembro: datos.idmiembro,
            asociado: datos.nombres

        });
        $("#modal-lista-asociados").modal("hide");


    }

    $("#tabla-asociados").on('key.dt', function (e, datatable, key, cell, originalEvent) {
        if (key === 13) {
            var datos = asociados.datatable.row(cell.index().row).data();
            cargar_datos_asociado(datos);
        }
    });

    $('#tabla-asociados').on('dblclick', 'tr', function () {
        var datos = asociados.datatable.row(this).data();
        cargar_datos_asociado(datos);
    });


})
