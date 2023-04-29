var perfiles = new BASE_JS('perfiles', 'perfiles');

document.addEventListener("DOMContentLoaded", function() {


    perfiles.TablaListado({
        tablaID: '#tabla-perfiles',
        url: "/buscar_datos",
    });



    document.addEventListener("click", function(event) {
        var id = event.srcElement.id;
        if(id == "" && !event.srcElement.parentNode.disabled) {
            id = event.srcElement.parentNode.id;
        }
        //console.log(event.srcElement);
        switch (id) {
            case 'nuevo-perfil':
                event.preventDefault();

                perfiles.abrirModal();
            break;

            case 'modificar-perfil':
                event.preventDefault();

                modificar_perfil();
            break;

            case 'eliminar-perfil':
                event.preventDefault();
                eliminar_perfil();
            break;

            case 'guardar-perfil':
                event.preventDefault();
                guardar_perfil();
            break;

        }

    })


    function modificar_perfil() {
        var datos = perfiles.datatable.row('.selected').data();
        if(typeof datos == "undefined") {
            BASE_JS.sweet({
                text: seleccionar_registro
            });

            return false;
        }

        var promise = perfiles.get(datos.perfil_id);

        promise.then(function(response) {

        })
    }

    function guardar_perfil() {
        var required = true;
        // required = required && perfiles.required("perfil_descripcion");

       
        if(required) {
            var promise = perfiles.guardar();
            perfiles.CerrarModal();


            promise.then(function(response) {
                if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                    return false;
                }

            })

        }
    }

    function eliminar_perfil() {
        var datos = perfiles.datatable.row('.selected').data();
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
                perfiles.Operacion(datos.perfil_id, "E");

            }
        });
    }



    document.addEventListener("keydown", function(event) {
            // alert(modulo_controlador);
        if(modulo_controlador == "perfiles/index") {
            //ESTOS EVENTOS SE ACTIVAN SUS TECLAS RAPIDAS CUANDO EL MODAL DEL FORMULARIO ESTE CERRADO
            if(!$('#modal-perfiles').is(':visible')) {

                switch (event.code) {
                    case 'F1':
                        perfiles.abrirModal();
                        event.preventDefault();
                        event.stopPropagation();
                        break;
                    case 'F2':
                        modificar_perfil();
                        event.preventDefault();
                        event.stopPropagation();
                        break;
                    // case 'F4':
                    // 	VerPrecio();
                    // 	event.preventDefault();
                    // 	event.stopPropagation();

                    //     break;
                    case 'F7':
                        eliminar_perfil();
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

                if($('#modal-perfiles').is(':visible')) {
                    guardar_perfil();
                }
                event.preventDefault();
                event.stopPropagation();
            }




        }
        // alert("ola");

    })

    document.getElementById("cancelar-perfil").addEventListener("click", function(event) {
        event.preventDefault();
        perfiles.CerrarModal();
    })


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

})
