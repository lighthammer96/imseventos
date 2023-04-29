var modulos = new BASE_JS('modulos', 'modulos');
var padres = new BASE_JS('padres', 'modulos');


document.addEventListener("DOMContentLoaded", function() {

    modulos.select_init({
        placeholder: seleccione
    })

    var eventClick = new Event('click');

    padres.enter("modulo_nombre|padre","modulo_icono|padre");
    padres.enter("modulo_icono|padre","modulo_orden|padre");

    // modulos.enter("modulo_nombre","modulo_controlador");
    modulos.enter("modulo_controlador","modulo_icono");
    modulos.enter("modulo_icono","modulo_orden");
    modulos.enter("modulo_orden","modulo_padre");
    // modulos.enter("accion","ide");
    // modulos.enter("ide","accion", function() {
    //     var accion = document.getElementsByName("accion")[0];
    //     var id = document.getElementsByName("ide")[0];

    //     var objeto = {
    //         accion_id: accion.value,
    //         accion_descripcion: accion.options[accion.selectedIndex].text,
    //         id: id.value
    //     }

    //     // theParent = document.getElementById("theParent");
    //     // theKid = document.createElement("div");
    //     // theKid.innerHTML = 'Are we there yet?';

    //     // // append theKid to the end of theParent
    //     // theParent.appendChild(theKid);

    //     // // prepend theKid to the beginning of theParent
    //     // theParent.insertBefore(theKid, theParent.firstChild);

    //     document.getElementById("detalleAcciones").getElementsByTagName("tbody")[0].appendChild(HTMLDetallemodulos(objeto));
    //     //$("#detalleAcciones > tbody").append(HTMLDetallemodulos(objeto));
    //     modulos.limpiarDatos("limpiar");
    // });


    modulos.enter("estado", "idioma");



    modulos.TablaListado({
        tablaID: '#tabla-modulos',
        url: "/buscar_datos",
    });


    document.getElementById("nuevo-modulo").addEventListener("click", function(event) {
        event.preventDefault();

        modulos.abrirModal();
    })


    document.getElementById("modificar-modulo").addEventListener("click", function(event) {
        event.preventDefault();
        var datos = modulos.datatable.row('.selected').data();
        // console.log(datos);
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });
            return false;
        }

        var promise = modulos.get(datos.modulo_id);
        promise.then(function(response) {
            modulos.ajax({
                url: '/obtener_traducciones',
                datos: { modulo_id: response.modulo_id }
            }).then(function(response) {

            })
        })

    })

    document.getElementById("eliminar-modulo").addEventListener("click", function(event) {
        event.preventDefault();
        var datos = modulos.datatable.row('.selected').data();
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
            modulos.Operacion(datos.modulo_id, "E");

        }
    });
    })

    document.getElementById("ver-modulo").addEventListener("click", function(event) {
        event.preventDefault();

        var datos = modulos.datatable.row('.selected').data();
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;

        }
        var promise = modulos.ver(datos.modulo_id);
        promise.then(function(response) {

        })
    })

    document.getElementById("guardar-modulo").addEventListener("click", function(event) {
        event.preventDefault();

        var required = true;
        // required = required && modulos.required("modulo_nombre");
        required = required && modulos.required("modulo_controlador");
        required = required && modulos.required("modulo_icono");
        required = required && modulos.required("modulo_orden");
        required = required && modulos.required("modulo_padre");

        if(required) {
            var promise = modulos.guardar();
            modulos.CerrarModal();


            promise.then(function() {
                modulos.select({
                    name: "modulo_padre",
                    url:  '/obtener_padres',
                });
            })




        }
    })

    document.getElementById("guardar-padre").addEventListener("click", function(event) {
        event.preventDefault();

        var required = true;
        required = required && padres.required("modulo_nombre|padre");
        required = required && padres.required("modulo_icono|padre");
        required = required && padres.required("modulo_orden|padre");
        if(required) {
            var promise = padres.guardar();
            padres.CerrarModal();

            // modulos.datatable.destroy();
            //     modulos.TablaListado({
            //     tablaID: '#tabla-modulos',
            //     url: "/buscar_datos",
            // });

            promise.then(function(response) {
                //console.log(response);
                if(response.datos.length > 0) {
                    // $("select[name=modulo_padre]").chosen("destroy");
                    modulos.select({
                        name: "modulo_padre",
                        url:  '/obtener_padres',
                        selected: response.id
                    });
                }
            });

        }
    })

    // function HTMLDetallemodulos(objeto, disabled) {
    //     var attr = '';
    //     var html = '';
    //     if(typeof disabled != "undefined") {
    //         attr = 'disabled="disabled"';
    //     }
    //     var tr = document.createElement("tr");

    //     html = '  <input type="hidden" name="accion_id[]" value="'+objeto.accion_id+'" >';
    //     html += '  <input type="hidden" name="id[]" value="'+objeto.id+'" >';
    //     html += '  <td>'+objeto.accion_descripcion+'</td>';
    //     html += '  <td>'+objeto.id+'</td>';
    //     html += '  <td><center><button '+attr+' type="button" class="btn btn-danger btn-xs eliminarAccion"><i class="fa fa-trash-o" aria-hidden="true"></i></button></center></td>';

    //     tr.innerHTML = html;
    //     return tr;
    // }

  

    // document.addEventListener("click", function(event) {

    //     // console.log(event.target.classList);
    //     // console.log(event.srcElement.parentNode.parentNode.parentNode.parentNode);
    //     if(event.target.classList.value.indexOf("eliminarAccion") != -1) {
    //         event.preventDefault();
    //         event.srcElement.parentNode.parentNode.parentNode.remove();

    //     }

    //     if(event.srcElement.parentNode.classList.value.indexOf("eliminarAccion") != -1 && !event.srcElement.parentNode.disabled) {
    //         event.preventDefault();
    //         ///console.log(event.srcElement.parentNode);
    //         event.srcElement.parentNode.parentNode.parentNode.parentNode.remove();
    //     }

    // })


    document.addEventListener("click", function(event) {

        // console.log(event.target.classList);
        // console.log(event.srcElement.parentNode.parentNode.parentNode.parentNode);
        if(event.target.classList.value.indexOf("eliminar-traduccion") != -1) {
            event.preventDefault();
            event.srcElement.parentNode.parentNode.parentNode.remove();

        }

        if(event.srcElement.parentNode.classList.value.indexOf("eliminar-traduccion") != -1 && !event.srcElement.parentNode.disabled) {
            event.preventDefault();
            ///console.log(event.srcElement.parentNode);
            event.srcElement.parentNode.parentNode.parentNode.parentNode.remove();
        }

    })


    document.getElementsByName("modulo_icono")[0].addEventListener("keydown", function(event) {
        if(event.keyCode == 13 && this.value == "") {
            $("#modal-iconos").modal("show");
            event.preventDefault();
        }
    })

    document.getElementsByName("modulo_icono|padre")[0].addEventListener("keydown", function(event) {
        if(event.keyCode == 13 && this.value == "") {
            $("#modal-iconos").modal("show");
            event.preventDefault();
        }
    })

    var elementos = document.getElementsByClassName("icon");
    for(let i = 0; i < elementos.length; i++){
        elementos[i].addEventListener("click", function(event) {
            event.preventDefault();
            // console.log(this.getElementsByTagName("p")[0].getElementsByTagName("i"));
            //var icon = this.getElementsByTagName("p")[0].getElementsByTagName("i")[0].getAttribute("class");
            var icon = this.getElementsByTagName("i")[0].getAttribute("class");
            // console.log(icon);
            // var array = icon.split(" ");
            document.getElementsByName("modulo_icono")[0].value = icon;
            document.getElementsByName("modulo_icono|padre")[0].value = icon;

            $("#modal-iconos").modal("hide");
            document.getElementsByName("modulo_orden")[0].focus();
            document.getElementsByName("modulo_orden|padre")[0].focus();
        })
    }




    document.addEventListener("keydown", function(event) {
        // alert(modulo_controlador);
        if(modulo_controlador == "modulos/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-modulos').is(':visible')) {
                var botones = document.getElementsByTagName("button");
                for (let index = 0; index < botones.length; index++) {
                    if(botones[index].getAttribute("tecla_rapida") != null) {
                        if(botones[index].getAttribute("tecla_rapida") == event.code) {
                            document.getElementById(botones[index].getAttribute("id")).dispatchEvent(eventClick);
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                    //console.log(botones[index].getAttribute("tecla_rapida"));
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

                if($('#modal-modulos').is(':visible') && !$("#modal-padres").is(":visible")) {
                    document.getElementById('guardar-modulo').dispatchEvent(eventClick);
                }

                if($('#modal-modulos').is(':visible') && $("#modal-padres").is(":visible")) {
                    document.getElementById('guardar-moduloPadre').dispatchEvent(eventClick);
                }
                event.preventDefault();
                event.stopPropagation();
            }


            if(event.code == "Escape") {
                // alert("olas");
                if($('#modal-modulos').is(':visible') && !$("#modal-padres").is(":visible") && !$("#modal-iconos").is(":visible")) {
                    modulos.CerrarModal();
                }

                if($('#modal-modulos').is(':visible') && $("#modal-padres").is(":visible") && !$("#modal-iconos").is(":visible")) {
                    // alert("ola");
                    padres.CerrarModal();
                }

                if($('#modal-modulos').is(':visible') && !$("#modal-padres").is(":visible") && $("#modal-iconos").is(":visible")) {
                    // alert("ola");
                    $("#modal-iconos").modal("hide");
                }
                event.preventDefault();
                event.stopPropagation();

            }



        }


    })

    document.getElementById("cancelar-modulo").addEventListener("click", function(event) {
        event.preventDefault();
        modulos.CerrarModal();
    })



    document.getElementById("cancelar-padre").addEventListener("click", function(event) {
        event.preventDefault();
        padres.CerrarModal();
    })


})
