/**
 * Version 1.3 fase Beta
 * Author: The Lighthammer
 *
 **/

class BASE_JS {
    constructor(referencia, controlador) {
        var self = this;
        // this.controlador = BaseUrl+$controlador;
        this.controladorURL = BaseUrl + "/" + controlador;

        // this.tablaBD = tablaBD;
        //this.selectUrl = BaseUrl + "PrincipalController/obtenerSelect";
        this.formularioID = "formulario-" + referencia;
        this.modalID = "modal-" + referencia;
        this.referencia = referencia;
        //this.comboQueryUrl = BaseUrl+"PrincipalController/getComboboxQuery";
        this.datatable = new Object();
        // this.tipodoc_id = tipodoc_id;
        this.modulo_id = modulo_id;
        // VARIABLE PARA ACTIVAR Y DESACTIVAR INPUTS
        this.disabled = false;
        $("#" + this.modalID).on('shown.bs.modal', function(event) {
            //alert(self.formularioID);
            var elementos = document.getElementById(self.formularioID).getElementsByClassName('entrada');
            for (let index = 0; index < elementos.length; index++) {
                // console.log(elementos[index].name);
                // console.log(elementos[index]["name"], );
                //alert("shown.bs.modal");
                //console.log(elementos[index].getAttribute("autofocus"));
                if (elementos[index].getAttribute("autofocus") == "autofocus") {
                    //alert("hola");
                    // console.log(elementos[index].name);
                    // console.log(elementos[index].tagName);
                    // $(elementos[index].tagName+"[name="+elementos[index].name+"]").focus();
                    // $(elementos[index].tagName+"[name="+elementos[index].name+"]").select();
                    elementos[index].focus();
                    if (elementos[index].tagName == "INPUT") {
                        elementos[index].select();
                    }
                    if (elementos[index].tagName == "SELECT" && elementos[index].classList.contains("selectized")) {
                        //alert("ola");
                        $("#" + elementos[index].id)[0].selectize.focus();
                        //CODIGO PARA QUE SE ABRA EL DROPDOWN CONTENT DEL SELECTIZE AL MOMENTO DEL AUTOFOCUS
                        $("#" + elementos[index].id).siblings().find(".selectize-dropdown").css({
                            width: '278px',
                            top: '26px'
                        });
                    }
                    // console.log(elementos[index]);
                    // console.log(elementos[index].select());
                    // console.log(elementos[index].focus());
                    // if(elementos[index].tagName != "SELECT") {
                    // }
                }
            }
        })
    }
    abrirModal() {
        //this.activarInputs();
        if (!this.disabled) {
            this.activarEntradas();
        } else {
            this.desactivarEntradas();
        }
        this.LimpiarFormulario();
        $("#" + this.modalID).modal("show");
        //PARA PONER EN FOCO EL PRIMER INPUT
        $("#" + this.modalID).trigger('shown.bs.modal');
        // $("#"+this.modalID).on('shown.bs.modal', function () {
        //  document.getElementsByName("tipodoc_descripcion")[0].focus();
        // })
        console.log("MODAL ABIERTO -> " + this.modalID);
    }
    CerrarModal() {
        $("#" + this.modalID).modal("hide");
        console.log("MODAL CERRADO -> " + this.modalID);
    }
    CerrarFormulario(callbackSI = "", callbackNO = "") {
        var self = this;
        var elementosDesactivados = 0;
        var elementos = document.getElementById(this.formularioID).getElementsByClassName("entrada");
        for (let i = 0; i < elementos.length; i++) {
            if (elementos[i].disabled) {
                elementosDesactivados++;
            }
            //console.log(elementos[i]);
        }
        if (elementosDesactivados == elementos.length) {
            $("#" + self.modalID).modal("hide");
        } else {
            BASE_JS.sweet({
                confirm: true,
                text: seguro_cancelar,
                callbackConfirm: function() {
                    $("#" + self.modalID).modal("hide");
                    console.log("MODAL CERRADO -> " + self.modalID);
                    if (typeof callbackSI == "function") {
                        callbackSI();
                    }
                },
                callbackCancel: function() {
                    //alert("#"+self.modalID);
                    $("#" + self.modalID).trigger('shown.bs.modal');
                    return false;
                }
            });
        }
        //$("#"+self.modalID).trigger('shown.bs.modal');
    }
    TablaListado(parametros) {
        var self = this;
        var stringColumnas = $(parametros.tablaID).attr("columnas");
        var ColumnasOcultas = (typeof parametros.ColumnasOcultas != "undefined") ? parametros.ColumnasOcultas : [0];
        //console.log(ColumnasOcultas);
        var array = [];
        if (typeof stringColumnas != "undefined") {
            var columnas = stringColumnas.split(",");
            for (var i = 0; i < columnas.length; i++) {
                array.push({
                    "data": columnas[i]
                });
            }
        }
        // console.log(array);
        var table = $(parametros.tablaID).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: self.controladorURL + parametros.url,
                type: "post",
                data: function(d) {
                    //console.log(parametros);
                    for (let p in parametros) {
                        d[p] = parametros[p];
                    }
                    // d.tipodoc_id = self.tipodoc_id
                    d.modulo_id = self.modulo_id
                    d._token = _token


                },
                error: function() {
                    // BASE_JS.sweet({
                    //     text: 'HUBO UN ERROR EN LA CARGA DE DATOS ... POR FAVOR CONTACTE CON EL ADMINISTRADOR DEL SISTEMA'
                    // });
                    console.log('HUBO UN ERROR EN LA CARGA DE DATOS ... POR FAVOR CONTACTE CON EL ADMINISTRADOR DEL SISTEMA');
                }
            },
            "columns": array,
            "createdRow": function(row, data, dataIndex) {
                // console.log(data);
                if (typeof data.state != "undefined" && (data.state == "I" || data.state == '0')) {
                    $(row).addClass("text-danger");
                    $(row).css("font-weight", "bold");
                }
                $(row).css("cursor", "pointer");
            },
            "columnDefs": [{
                "targets": ColumnasOcultas,
                "visible": false,
                "searchable": false
            }, ],
            "keys": {
                keys: [112, 13 /* ENTER */ , 38 /* UP */ , 40 /* DOWN */ ]
            },
            "select": {
                style: 'single'
            },
            "order": [
                [0, "DESC"]
            ],
            "initComplete": function(settings, json) {
                // referencia: https://stackoverflow.com/questions/14619498/datatables-global-search-on-keypress-of-enter-key-instead-of-any-key-keypress
                // esto ess para que solo busque cuando se presione enter
                // $('.dataTables_filter input').unbind();
                // $('.dataTables_filter input').bind('keyup', function(e){
                //     var code = e.keyCode || e.which;
                //     if (code == 13) {
                //         table.search(this.value).draw();
                //     }
                //     if(this.value == "") {
                //         table.search(this.value).draw();
                //     }
                // });

                $(parametros.tablaID+'_filter input').unbind();
                $(parametros.tablaID+'_filter input').bind('keyup', function(e){
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        table.search(this.value).draw();
                    }
                    if(this.value == "") {
                        table.search(this.value).draw();
                    }
                });
            }
        });

         //referencia del select focus: https://www.gyrocode.com/articles/jquery-datatables-how-to-navigate-rows-with-keytable-plugin/
         //
        // Handle event when cell gains focus
        $(parametros.tablaID).on('key-focus.dt', function(e, datatable, cell) {
            // Select highlighted row
            table.row(cell.index().row).select();
        });
        // Handle click on table cell
        $(parametros.tablaID).on('click', 'tbody td', function(e) {
            e.stopPropagation();
            // Get index of the clicked row
            var rowIdx = 0;
            if (typeof table.cell(this).index() != "undefined") {
                rowIdx = table.cell(this).index().row;
            }
            // // Select row
            table.row(rowIdx).select();
        });
        // Handle key event that hasn't been handled by KeyTable
        $(parametros.tablaID).on('key.dt', function(e, datatable, key, cell, originalEvent) {
            // If ENTER key is pressed
            if (key === 13) {
                // Get highlighted row data
                var data = table.row(cell.index().row).data();
                // FOR DEMONSTRATION ONLY
                // $("#example-console").html(data.join(', '));
            }
        });
        // $('div.dataTables_filter input').bind('keyup', function(e) {
        //     console.log(e);
        //     if(e.keyCode == 13) {
        //         table.search(this.value).draw();
        //     }
        //     e.preventDefault();
        //     e.stopPropagation();
        // });
        //console.log(datatable);
        console.log("TABLA -> " + parametros.tablaID);
        //console.log(datatable);
        this.datatable = table;

        //return datatable;
    }
    guardar() {
        var self = this;
        var formularioDatos = new FormData(document.getElementById(this.formularioID));
        var botones = document.getElementById(this.formularioID).getElementsByTagName("button");
        for (var i = 0; i < botones.length; i++) {
            if (botones[i].id.indexOf("guardar") != -1) {
                botones[i].disabled = true;
            }
        }

        formularioDatos.append("_token", _token);

        var promise = fetch(this.controladorURL + "/guardar_" + this.referencia, {
            method: "POST",
            body: formularioDatos
        }).then(function(response) {
            //console.log(response.json());
            return response.json();
        }).catch(function(error) {
            //console.log(error);
            // BASE_JS.sweet({
            //     text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message
            // });
            console.log('HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message);
            self.CerrarModal();
        }).then(function(response) {
            if (typeof response != "undefined") {
                // if(typeof response.error != "undefined") {
                //  BASE_JS.sweet({
                //      text: response.message
                //  });
                //  alert(typeof response.error);
                //  return false;
                // } else {
                //  BASE_JS.notificacion(response);
                //  for (var i = 0; i < botones.length; i++) {
                //      if(botones[i].id.indexOf("guardar") != -1) {
                //          botones[i].disabled = false;
                //      }
                //  }
                //  return response;
                // }
            }
            if(typeof response.msg != "undefined") {
                BASE_JS.notificacion(response);
            }
            for (var i = 0; i < botones.length; i++) {
                if (botones[i].id.indexOf("guardar") != -1) {
                    botones[i].disabled = false;
                }
            }
            return response;
        });


        promise.then(function(response) {

            if(typeof response.validacion == "undefined" && typeof response.status != "undefined" &&  response.status.indexOf("ee") == -1 && response.status.indexOf("e") == -1) {
                self.LimpiarFormulario();
                $("#" + self.modalID).trigger('shown.bs.modal');
            }

            if(typeof self.datatable.ajax != "undefined") {
                self.datatable.clear();
                self.datatable.ajax.reload();
                self.datatable.draw();
            }

        })

        return promise;
    }
    // evento(selector, evento, funcion) {
    //  console.log(document.querySelectorAll(selector));
    //  var elementos = document.querySelectorAll(selector);
    //  for(let i = 0; i < elementos.length; i++){
    //      elementos[i].addEventListener(evento, function() {
    //          if(typeof funcion == "function") {
    //              funcion();
    //          }
    //      })
    //  }
    // }
    get(id) {
        var self = this;
        //var datos = {id: id};
        var datos = new URLSearchParams("id=" + id + "&_token=" + _token);
        var promise = fetch(this.controladorURL + "/get_" + this.referencia, {
            method: "POST",
            body: datos,
        }).then(function(response) {
            //console.log(response.json());
            return response.json();
        }).catch(function(error) {
            // BASE_JS.sweet({
            //     text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message
            // });
            console.log('HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message);
        }).then(function(response) {
            //console.log(self.formularioID);
            var elementos = document.getElementById(self.formularioID).getElementsByClassName("entrada");
            //console.log(elementos);
            self.abrirModal();
            self.disabled = false;
            response = response[0];
            if (response != null) {
                for (let i = 0; i < elementos.length; i++) {
                    //alert(response[elementos[i].name]);

                    if (response[elementos[i].name] != null && elementos[i].type != "file" ) {

                        if (elementos[i].classList.contains("selectized")) {
                            // Para el selectizejs anteriormente le ponia asi como esta comentado en lineas abajo, pero mi problema era que el setValue dipara un change y malograba mis trigger de change, se cruzaban por eso opte por hacer la segunda opcion ue es destruir, asignar valor y volver poner el selecticejs
                            // $("#"+elementos[i].name).siblings().find(".selectize-dropdown").find(".selectize-dropdown-content").find(".option").removeClass("selected");
                            // $("#"+elementos[i].name)[0].selectize.setValue(response[elementos[i].name]);
                            $("#" + elementos[i].name).selectize()[0].selectize.destroy();
                            elementos[i].value = BASE_JS.FormatoFecha(response[elementos[i].name], "user")
                            $("#" + elementos[i].name).selectize();
                        } else {

                            if(elementos[i].type == "radio") {
                                if(elementos[i].value == response[elementos[i].name]) {

                                    elementos[i].checked = true;
                                    $("input[name='"+elementos[i].name+"']").attr("checked", "checked");
                                    elementos[i].parentNode.classList.add("checked");
                                } else {
                                    elementos[i].checked = false;
                                    $("input[name='"+elementos[i].name+"']").removeAttr("checked");
                                    elementos[i].parentNode.classList.remove("checked");
                                }
                            } else {
                                if(elementos[i].type == "checkbox" ) {
                                    // console.log(response[elementos[i].name]);
                                    if(response[elementos[i].name] == 1 || response[elementos[i].name] == 'S') {
                                        elementos[i].checked = true;
                                        $("input[name='"+elementos[i].name+"']").attr("checked", "checked");
                                        elementos[i].parentNode.classList.add("checked");
                                    } else {
                                        elementos[i].checked = false;
                                        $("input[name='"+elementos[i].name+"']").removeAttr("checked");
                                        elementos[i].parentNode.classList.remove("checked");

                                    }
                                }
                                elementos[i].value = BASE_JS.FormatoFecha(response[elementos[i].name], "user");
                            }

                        }
                    }
                }
            }
            // if(typeof parametros.callback == "function") {
            //     callback();
            // }
            return response;
        });
        return promise
    }
    // eliminar(id) {
    //  var self = this;
    //  //var datos = {id: id};
    //  var datos = new URLSearchParams("id="+id);
    //  var promise = fetch(self.controladorURL + "/Eliminar"+this.referencia, {
    //      method: "POST",
    //      body: datos,
    //  }).then(function(response) {
    //      //console.log(response.json());
    //      return response.json();
    //  }).catch(function(error) {
    //      BASE_JS.sweet({
    //          text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> '+ error.message
    //      });
    //  }).then(function(response) {
    //      BASE_JS.mensaje(response);
    //      return response;
    //  });
    //  return promise
    // }
    Operacion(id, tipo) {
        var self = this;
        var url = "";
        //var datos = {id: id};
        if (tipo == "A") {
            url = this.controladorURL + "/anular_" + this.referencia;
        }
        if (tipo == "E") {
            url = this.controladorURL + "/eliminar_" + this.referencia;
        }
        if (tipo == "AC") {
            url = this.controladorURL + "/activar_" + this.referencia;
        }
        var datos = new URLSearchParams("id=" + id + "&_token=" + _token);
        var promise = fetch(url, {
            method: "POST",
            body: datos,
        }).then(function(response) {
            //console.log(response.json());
            return response.json();
        }).catch(function(error) {
            // BASE_JS.sweet({
            //     text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message
            // });
            console.log('HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message);
        }).then(function(response) {
            if(typeof response.msg != "undefined") {
                BASE_JS.mensaje(response);
            }
            return response;
        });

        promise.then(function(response) {
            // alert();
            if(typeof self.datatable.ajax != "undefined") {
                self.datatable.clear();
                self.datatable.ajax.reload();
                self.datatable.draw();
            }

        })
        return promise
    }
    ver(id) {
        this.disabled = true;
        return this.get(id);
    }
    ajax(parametros) {
        //var self = this;
        if(typeof parametros.datos == "undefined") {
            parametros.datos = {
                '_token': _token
            };
        } else {
            parametros.datos['_token'] = _token;
        }
        parametros.type = (typeof parametros.type == "undefined") ? "POST" : parametros.type;
        parametros.contentType = (typeof parametros.contentType == "undefined") ? "json" : parametros.contentType;
        var datos = (typeof parametros.datos == "undefined") ? {} : new URLSearchParams(BASE_JS.serialize(parametros.datos));
        // parametros.internet = (typeof parametros.internet == "undefined") ? false : parametros.internet;
        // var header = new Headers();
        // if(parametros.contentType == "json") {
        //  header.set("Content-Type", "application/json");
        // }
        // if(parametros.contentType == "html") {
        //  header.set("Content-Type", "text/html");
        // }
        // var request = new Request(this.controladorURL + parametros.url, {
        //  method: parametros.type,
        //  body: datos,
        //  headers: header
        // })
        var promise = fetch(this.controladorURL + parametros.url, {
            method: parametros.type,
            body: datos,
            cache: "force-cache"
        }).then(function(response) {
            if (parametros.contentType == "json") {
                return response.json();
            }
            if (parametros.contentType == "html") {
                return response.text();
            }
        }).catch(function(error) {
            // BASE_JS.sweet({
            //     text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message
            // });
            console.log('HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message);
        }).then(function(response) {
            return response;
        });
        return promise;
    }
    async AjaxAsync(parametros) {
        if(typeof parametros.datos == "undefined") {
            parametros.datos = {
                '_token': _token
            };
        } else {
            parametros.datos['_token'] = _token;
        }

        parametros.type = (typeof parametros.type == "undefined") ? "POST" : parametros.type;
        parametros.contentType = (typeof parametros.contentType == "undefined") ? "json" : parametros.contentType;

        var datos = (typeof parametros.datos == "undefined") ? {} : new URLSearchParams(BASE_JS.serialize(parametros.datos));
        try {
            let response = await fetch(this.controladorURL + parametros.url, {
                method: parametros.type,
                body: datos,
                cache: "force-cache"
            });
            if (parametros.contentType == "json") {
                return await response.json();
            }
            if (parametros.contentType == "html") {
                return await response.text();
            }
            // let data = await response.json();
            // return data;
        } catch (error) {
            // BASE_JS.sweet({
            //     text: 'HUBO UN PROBLEMA CON LA PETICIÓN ASYNC FETCH -> ' + error
            // });
            console.log('HUBO UN PROBLEMA CON LA PETICIÓN ASYNC FETCH -> ' + error);
        }

        // url referencia:
        // https://www.it-swarm.dev/es/javascript/async-await-fetch-como-manejar-los-errores/809445628/
        // https://dev.to/shoupn/javascript-fetch-api-and-using-asyncawait-47mp

    }
    LimpiarFormulario() {
        //console.log(this.formularioID);
        var elementos = document.getElementById(this.formularioID).getElementsByClassName("entrada");
        for (let i = 0; i < elementos.length; i++) {
            elementos[i].parentNode.classList.remove('has-error');
            elementos[i].parentNode.classList.remove('has-success');
        }
        var formulario = document.getElementById(this.formularioID);
        var inputs = formulario.getElementsByClassName("entrada");
        for (let i = 0; i < inputs.length; i++) {
            if(inputs[i].name == "_token") {
                continue;
            }
            //console.log(inputs[i]);
            var defaultValue = inputs[i].getAttribute("default-value");
            // console.log(inputs[i].name, inputs[i].type);
            if (inputs[i].type == "checkbox" || inputs[i].type == "radio") {
                inputs[i].checked = false;

                // esto es por el icheck js
                $("input[name='"+inputs[i].name+"']").removeAttr("checked");
                elementos[i].parentNode.classList.remove("checked");

            }
            if (defaultValue != null) {
                // alert(defaultValue);
                inputs[i].value = defaultValue;
            } else {
                if (inputs[i].tagName != "SELECT" && inputs[i].type != "checkbox" && inputs[i].type != "radio") {
                    inputs[i].value = "";
                } else {
                    if (inputs[i].classList.contains("selectized")) {
                        // console.log(inputs[i].name);
                        // $("#"+inputs[i].name).siblings().find(".selectize-dropdown").find(".selectize-dropdown-content").find(".option").removeClass("selected");
                        // // $("#"+inputs[i].name).val("");
                        // $("#"+inputs[i].name)[0].selectize.setValue("");
                        $("#" + inputs[i].id).selectize()[0].selectize.destroy();
                        inputs[i].selectedIndex = 0;
                        $("#" + inputs[i].id).selectize();
                    } else {
                        inputs[i].selectedIndex = 0;
                    }
                }
            }
        }
        if (typeof formulario.getElementsByTagName("table")[0] != "undefined" && typeof formulario.getElementsByTagName("table")[0].getElementsByTagName("tbody")[0] != "undefined") {
            formulario.getElementsByTagName("table")[0].getElementsByTagName("tbody")[0].innerHTML = "";
        }
        console.log("FORMULARIO LIMPIADO -> " + this.formularioID);
    }
    limpiarDatos(className) {
        var elementos = document.getElementById(this.formularioID).getElementsByClassName(className);
        //console.log(elementos);
        for (let i = 0; i < elementos.length; i++) {
            if(elementos[i].type != "checkbox" && elementos[i].type != "radio") {
                elementos[i].value = "";
            }

            //elementos[i].innerText = "";
            //console.log(elementos[i]);
           // console.log(elementos[i].classList);

            if (elementos[i].type == "checkbox" || elementos[i].type == "radio") {
                elementos[i].checked = false;

                // esto es por el icheck js
                $("input[name='"+elementos[i].name+"']").removeAttr("checked");
                elementos[i].parentNode.classList.remove("checked");

            }

            if (elementos[i].tagName == "SELECT") {
                if (elementos[i].classList.contains("selectized")) {
                    $("#" + elementos[i].id).selectize()[0].selectize.destroy();
                    elementos[i].selectedIndex = 0;
                    $("#" + elementos[i].id).selectize();
                } else {
                    elementos[i].selectedIndex = 0;
                }
            }
        }
        console.log("ELEMENTOS LIMPIADOS CUYA CLASE ES -> " + className);
        //return elementos;
    }
    asignarDatos(datos) {
        for (let dato in datos) {
            if (this.buscarEnFormulario(dato)) {
                //console.log(this.buscarEnFormulario(dato));
                this.buscarEnFormulario(dato).value = datos[dato];
            }
        }
    }
    desactivarEntradas() {
        //console.log("desactivar");
        var elementos = document.getElementById(this.formularioID).getElementsByClassName("entrada");
        for (let i = 0; i < elementos.length; i++) {
            elementos[i].disabled = true;
            // console.log(elementos[i]);

            if(elementos[i].type == "radio" && elementos[i].parentNode.classList.contains("iradio_minimal-blue")) {
                elementos[i].parentNode.classList.add("disabled");
            }
            //console.log(elementos[i]);
        }
        var botones = document.getElementById(this.formularioID).getElementsByTagName("button");
        for (let i = 0; i < botones.length; i++) {
            //console.log(botones[i]);
            if (botones[i].id.indexOf("guardar") != -1 || botones[i].id.indexOf("cobrar") != -1 || botones[i].id.indexOf("Guardar") != -1 || botones[i].id.indexOf("Cobrar") != -1) {
                //alert(botones[i].id);
                botones[i].style.display = 'none';
            }
            // alert(botones[i].id.indexOf("cancelar"));
            // alert(botones[i].id.indexOf("Cancelar"));
            if (botones[i].id.indexOf("cancelar") == -1 && botones[i].id.indexOf("Cancelar") == -1) {
                //alert("ola");
                botones[i].disabled = true;
            }
            //console.log(botones[i]);
        }
        //SOLO PARA EL PLUGIN CHOSEN
        // var chosens = document.getElementById(this.formularioID).getElementsByClassName("chosen-container");
        // for(let i = 0; i < chosens.length; i++) {
        //  if(chosens[i].classList.contains("chosen-container-single")) {
        //      chosens[i].classList.remove("chosen-container-single");
        //      chosens[i].classList.add("chosen-container-single-desactivado");
        //  }
        //  if(chosens[i].classList.contains("chosen-container-multi")) {
        //      chosens[i].classList.remove("chosen-container-multi");
        //      chosens[i].classList.add("chosen-container-multi-desactivado");
        //  }
        // }
    }
    activarEntradas() {
        //console.log("activar");
        var elementos = document.getElementById(this.formularioID).getElementsByClassName("entrada");
        for (let i = 0; i < elementos.length; i++) {
            elementos[i].disabled = false;

            if(elementos[i].type == "radio" && elementos[i].parentNode.classList.contains("iradio_minimal-blue")) {
                elementos[i].parentNode.classList.remove("disabled");
            }
        }
        var botones = document.getElementById(this.formularioID).getElementsByTagName("button");
        for (let i = 0; i < botones.length; i++) {
            botones[i].style.display = 'inline';
            botones[i].disabled = false;

        }
        //alert(this.formularioID);
        // $("#"+this.formularioID).find(".chosen-select").val("").trigger("chosen:updated");;
        // $("#"+this.formularioID).find(".chosen-select").chosen("destroy");
        // $("#"+this.formularioID).find(".chosen-select").chosen({width: "100%"});
    }
    required(name) {
        //var formularioSelector = document.getElementById(this.formularioID).querySelector(selector);
        if (this.buscarEnFormulario(name)) {
            if (this.buscarEnFormulario(name).value == "") {
                //console.log(this.buscarEnFormulario(name).parentNode);
                //this.buscarEnFormulario(name).parentNode.classList.remove('has-success');
                this.buscarEnFormulario(name).parentNode.classList.add('has-error');
                return false;
            } else {
                this.buscarEnFormulario(name).parentNode.classList.remove('has-error');
                //this.buscarEnFormulario(name).parentNode.classList.add('has-success');
                return true;
            }
        }
        //console.log(formularioSelector);
    }
    enter(input, nextInput, callback = "", required = true) {
        var self = this;
        // console.log(input+" "+this.buscarEnFormulario(input));
        // console.log(nextInput+" "+this.buscarEnFormulario(nextInput));
        if (this.buscarEnFormulario(input) && this.buscarEnFormulario(nextInput)) {
            // console.log(this.buscarEnFormulario(input));
            // console.log(this.buscarEnFormulario(nextInput));
            if (self.buscarEnFormulario(input).tagName == "SELECT" && self.buscarEnFormulario(input).classList.contains("selectized")) {
                // console.log($("#"+self.buscarEnFormulario(input).id)[0].selectize.$control_input);
                // $("#"+self.buscarEnFormulario(input).id)[0].selectize.$control_input.on({
                //  keydown: function (event) {
                $(document).on('keydown', '#' + self.buscarEnFormulario(input).id + '-selectized', function(event) {
                    var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                    // console.log(keyCode); return false;
                    // console.log(self.buscarEnFormulario(input));
                    // console.log(self.buscarEnFormulario(nextInput));
                    if (keyCode == 13 || keyCode == 9) {
                        if (required) {
                            if (self.required(input)) {
                                if (self.buscarEnFormulario(nextInput).tagName == "SELECT" && self.buscarEnFormulario(nextInput).classList.contains("selectized")) {
                                    //console.log(self.buscarEnFormulario(nextInput).id);
                                    $("#" + self.buscarEnFormulario(nextInput).id)[0].selectize.focus();
                                    //self.buscarEnFormulario(nextInput).size = 5;
                                    // if(nextSelector.classList.contains('select2-hidden-accessible')) {
                                    //     $(nextInput).select2("open");
                                    // }
                                }
                                if (typeof callback == "function") {
                                    callback();
                                }
                                self.buscarEnFormulario(nextInput).focus();
                                event.preventDefault(); // esto antes no estaba, lo puse el 10/07/2020 para que al presionar la tecla tab funcione igual que al presionar enter
                            } else {
                                event.preventDefault();
                            }
                        } else {
                            // agregado por manuel 21/06/2021 22:04
                            if (self.buscarEnFormulario(nextInput).tagName == "SELECT" && self.buscarEnFormulario(nextInput).classList.contains("selectized")) {
                                //console.log(self.buscarEnFormulario(nextInput).id);
                                $("#" + self.buscarEnFormulario(nextInput).id)[0].selectize.focus();
                                //self.buscarEnFormulario(nextInput).size = 5;
                                // if(nextSelector.classList.contains('select2-hidden-accessible')) {
                                //     $(nextInput).select2("open");
                                // }
                            }
                            if (typeof callback == "function") {
                                callback();
                            }
                            self.buscarEnFormulario(nextInput).focus();
                            event.preventDefault();
                            // comentado por manuel 21/06/2021 21:57
                            // self.buscarEnFormulario(nextInput).focus();

                            // if (self.buscarEnFormulario(nextInput).tagName != "SELECT") {
                            //     event.preventDefault();
                            // } else {
                            //     return false;
                            // }
                        }
                    }
                    //console.log(e);
                    // }
                })
            } else {
                this.buscarEnFormulario(input).addEventListener("keydown", function(event) {
                    var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                    // alert(keyCode)
                    if (keyCode == 13 || keyCode == 9) {
                        //HAY VECES QUE NO ES NECESARIO VALIDAR SI ESTA VACIO UN INPUT, Y SOLO HAY QUE PASAR AL SIGUIENTE...
                        if (required) {
                            if (self.required(input)) {
                                // alert(nextInput);
                                // alert(self.buscarEnFormulario(nextInput).tagName );
                                if (self.buscarEnFormulario(nextInput).tagName == "SELECT" && self.buscarEnFormulario(nextInput).classList.contains("selectized")) {
                                    //console.log(self.buscarEnFormulario(nextInput).id);
                                    $("#" + self.buscarEnFormulario(nextInput).id)[0].selectize.focus();
                                    //self.buscarEnFormulario(nextInput).size = 5;
                                    // if(nextSelector.classList.contains('select2-hidden-accessible')) {
                                    //     $(nextInput).select2("open");
                                    // }
                                }
                                if (typeof callback == "function") {
                                    callback();
                                }
                                // console.log(keyCode, nextInput);
                                //alert(nextInput);
                                self.buscarEnFormulario(nextInput).focus();
                                event.preventDefault(); // esto antes no estaba, lo puse el 10/07/2020 para que al presionar la tecla tab funcione igual que al presionar enter
                            } else {
                                event.preventDefault();
                            }
                            // if(self.buscarEnFormulario(nextInput).tagName != "SELECT") {
                            //  event.preventDefault();
                            // } else {
                            //  return false;
                            // }
                        } else {
                            // agregado por manuel 21/06/2021 22:04
                            if (self.buscarEnFormulario(nextInput).tagName == "SELECT" && self.buscarEnFormulario(nextInput).classList.contains("selectized")) {
                                //console.log(self.buscarEnFormulario(nextInput).id);
                                $("#" + self.buscarEnFormulario(nextInput).id)[0].selectize.focus();
                                //self.buscarEnFormulario(nextInput).size = 5;
                                // if(nextSelector.classList.contains('select2-hidden-accessible')) {
                                //     $(nextInput).select2("open");
                                // }
                            }
                            if (typeof callback == "function") {
                                callback();
                            }
                            self.buscarEnFormulario(nextInput).focus();
                            event.preventDefault();
                            // comentado por manuel 21/06/2021 21:57
                            // self.buscarEnFormulario(nextInput).focus();

                            // if (self.buscarEnFormulario(nextInput).tagName != "SELECT") {
                            //     event.preventDefault();
                            // } else {
                            //     return false;
                            // }

                        }
                        //console.log("evento", event);
                        //return false;
                    }
                })
            }
        }
        // document.getElementById(this.formularioID).querySelector(input);
        // var nextSelector = document.getElementById(this.formularioID).querySelector(nextInput);
    }
    buscarEnFormulario(name) {

        let elementos = document.getElementById(this.formularioID);
        for (let i = 0; i < elementos.length; i++) {
            if (elementos[i].name == name) {
                return elementos[i];
            }
        }
        return false;
    }
    static obtenerHora() {
        var date = new Date();
        // var minutos = "";
        // if(f.getMinutes() < 10) {
        //     minutos = "0"+f.getMinutes();
        // } else {
        //     minutos = f.getMinutes();
        // }
        // return f.getHours() +":" + minutos + ":" + f.getSeconds();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var segundos = date.getSeconds()
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        segundos = segundos < 10 ? '0' + segundos : segundos;
        var strTime = hours + ':' + minutes + ':' + segundos + ' ' + ampm;
        return strTime;
    }
    // function formatAMPM(date) {
    //  var hours = date.getHours();
    //  var minutes = date.getMinutes();
    //  var ampm = hours >= 12 ? 'pm' : 'am';
    //  hours = hours % 12;
    //  hours = hours ? hours : 12; // the hour '0' should be '12'
    //  minutes = minutes < 10 ? '0'+minutes : minutes;
    //  var strTime = hours + ':' + minutes + ' ' + ampm;
    //  return strTime;
    //   }
    static ObtenerFechaActual(type) {
        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth() + 1; //hoy es 0!
        var yyyy = hoy.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        if (type == "user") {
            hoy = dd + '/' + mm + '/' + yyyy;
        }
        if (type == "server") {
            hoy = yyyy + '-' + mm + '-' + dd;
        }
        return hoy;
    }

    static sumarDias(dias, fecha) {
        var Fecha = new Date();
        var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() + 1) + "/" + Fecha.getFullYear());
        var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
        var aFecha = sFecha.split(sep);
        var fecha = aFecha[2] + '/' + aFecha[1] + '/' + aFecha[0];
        fecha = new Date(fecha);
        fecha.setDate(fecha.getDate() + parseInt(dias));
        var anno = fecha.getFullYear();
        var mes = fecha.getMonth() + 1;
        var dia = fecha.getDate();
        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;
        var fechaFinal = dia + sep + mes + sep + anno;
        return (fechaFinal);
    }

    static FormatoFecha(fecha, formato) {

        if (fecha != null) {
            var date = fecha.toString().split(/[\/.-]/);
            if (formato == "user") {
                // var array = fecha.toString().split(/[\/.-]/);
                // console.log(array)
                //var date = fecha.toString().split("-");
                if (date.length == 3 && date[0].toString().length == 4 && date[1].toString().length == 2 && date[2].toString().length == 2) {
                    return date[2] + "/" + date[1] + "/" + date[0];
                }
            }
            if (formato == "server") {
                //var date = fecha.toString().split("/");
                if (date.length == 3 && date[0].toString().length == 2 && date[1].toString().length == 2 && date[2].toString().length == 4) {
                    return date[2] + "-" + date[1] + "-" + date[0];
                }
            }
        }
        return fecha;
    }

    calcularSubTotal2() {
        var subtotal = 0.00;
        var elementos = document.getElementById(this.formularioID).getElementsByClassName("subtotal");
        //console.log(elementos);
        for (let i = 0; i < elementos.length; i++) {
            // console.log(elementos[i]);
            if (!isNaN(elementos[i].innerText)) {
                subtotal = subtotal + parseFloat(elementos[i].innerText);
            }
        }
        return subtotal.toFixed(2);
    }
    CalcularSuma(className) {
        var suma = 0.00;
        var elementos = document.getElementById(this.formularioID).getElementsByClassName(className);
        for (let i = 0; i < elementos.length; i++) {
            //console.log(className, elementos[i].tagName);
            if (elementos[i].tagName == "INPUT" || elementos[i].tagName == "SELECT") {
                if (!isNaN(elementos[i].value)) {
                    //console.log(elementos[i].value);
                    suma = suma + parseFloat(elementos[i].value);
                }
            } else {
                if (!isNaN(elementos[i].innerText)) {
                    //console.log(elementos[i].value);
                    suma = suma + parseFloat(elementos[i].innerText);
                }
            }
        }
        return suma.toFixed(2);
    }
    calcularTotal2() {
        var total = 0.00;
        var elementos = document.getElementById(this.formularioID).getElementsByClassName("total");
        for (let i = 0; i < elementos.length; i++) {
            if (!isNaN(elementos[i].value)) {
                //console.log(elementos[i].value);
                total = total + parseFloat(elementos[i].value);
            }
        }
        return total.toFixed(2);
    }
    static serialize(object) {
        return Object.keys(object).map(function(k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(object[k])
        }).join('&');
    }
    select(parametros) {
        // console.log(parametros);
        // parametros.datos._token = _token;
        if(typeof parametros.datos == "undefined") {
            parametros.datos = {
                '_token': _token
            };
        } else {
            parametros.datos['_token'] = _token;
        }

        // console.log(parametros);
        var selected = (typeof parametros.selected != "undefined") ? parametros.selected : "";
        var placeholder = (typeof parametros.placeholder != "undefined") ? parametros.placeholder : "";
        var datos = (typeof parametros.datos == "undefined") ? new URLSearchParams("_token="+_token) : new URLSearchParams(BASE_JS.serialize(parametros.datos));

        var promise = fetch(this.controladorURL + parametros.url, {
            method: 'POST',
            body: datos
        }).then(function(response) {
            return response.json();
        }).catch(function(error) {
            // BASE_JS.sweet({
            //     text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message
            // });
            console.log('HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message);
        }).then(function(response) {
            var options = "";
            var prioridadSelected = false;
            if (placeholder != "") {
                options += '<option value="">' + placeholder + '</option>';

            }
            if (response.length > 0) {

                for (let i = 0; i < response.length; i++) {
                    var atributo1 = "";
                    if (typeof response[i].atributo1 != "undefined") {
                        atributo1 = response[i].atributo1;
                    }
                    //alert(parametros.name+ " "+selected);
                    if (selected === response[i].id) {
                        // alert("hola "+parametros.name+" "+response[i].id    );
                        options += '<option atributo1="' + atributo1 + '" selected="selected" value="' + response[i].id + '">' + response[i].descripcion + '</option>';
                        prioridadSelected = true;
                    } else {
                        if (typeof response[i].defecto != "undefined" && response[i].defecto == "S" && !prioridadSelected) {
                            options += '<option atributo1="' + atributo1 + '" selected="selected" value="' + response[i].id + '">' + response[i].descripcion + '</option>';
                            // console.log( document.getElementsByName(parametros.name)[0].tagName);
                            if(document.getElementsByName(parametros.name)[0].tagName == "SELECT") {

                                document.getElementsByName(parametros.name)[0].setAttribute("default-value", response[i].id)
                            }
                        } else {
                            options += '<option atributo1="' + atributo1 + '" value="' + response[i].id + '">' + response[i].descripcion + '</option>';
                        }
                    }
                }
                // alert(options);
                // document.getElementsByName(parametros.name)[0].innerHTML = options;
                // $(".chosen-select").chosen({width: "100%"});
                // alert($('.chosen-select').val());
                // if(typeof parametros.callback == "function") {
                //  parametros.callback();
                // }
                //console.log(options);
            }

            if (typeof document.getElementsByName(parametros.name)[0] != "undefined" && document.getElementsByName(parametros.name)[0].tagName == "SELECT") {
                if (document.getElementsByName(parametros.name)[0].classList.contains("selectized")) {
                    // $("#"+document.getElementsByName(parametros.name)[0].id).selectize()[0].selectize.clear();
                    $("#" + document.getElementsByName(parametros.name)[0].id).selectize()[0].selectize.destroy();
                }
                document.getElementsByName(parametros.name)[0].innerHTML = options;
                //alert(document.getElementsByName(parametros.name)[0].id);
                //selectizejs ES UNA CLASE QUE CREO MANUEL SOLO PARA IDENTIFICAR QUE SELECT FUNCIONARAN CON EL PLUGIN
                // Y CUALES SEGUIRAN CON SU FUNCIONALIDAD NORMAL
                if (document.getElementsByName(parametros.name)[0].classList.contains("selectizejs")) {
                    //alert("hola");
                    $("#" + document.getElementsByName(parametros.name)[0].id).selectize();
                    //CUANDO PONGO ESTO SE MALOGRA EN LOS SELECT DE DEPARTAMENTOS, PROVINCIAS Y DISTRITOS DEL MODULO CLIENTES. , PARA QUE NO LO MALOGRE LE PUSE EL IF SOLO EN CASO DE QUE EL SELECTED SEA DIFERENTE DE VACIO

                    // comentado por manuel 23/06/2021, porque cuando se da en modificar el combo se focusea solito desplegandose el div de options y eso no me gusta ._.
                    // if (selected != "") {
                    //     $("#" + document.getElementsByName(parametros.name)[0].id)[0].selectize.focus();
                    // }
                }
                //$(".chosen-select").chosen({width: "100%"});
            }
            return response;
        });
        return promise;
    }
    select_init(parametros) {

        if(typeof parametros.datos == "undefined") {
            parametros.datos = {
                '_token': _token
            };
        } else {
            parametros.datos['_token'] = _token;
        }


        var placeholder = (typeof parametros.placeholder != "undefined") ? parametros.placeholder : "";
        var datos = (typeof parametros.datos == "undefined") ? new URLSearchParams("_token="+_token) : new URLSearchParams(BASE_JS.serialize(parametros.datos));

        var promise = fetch(this.controladorURL + "/select_init", {
            method: 'POST',
            body: datos
        }).then(function(response) {
            return response.json();
        }).catch(function(error) {

            console.log('HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message);
        }).then(function(response) {
            // console.log(response);
            var options = "";

            for (const key in response) {
                options = "";
                if (placeholder != "") {
                    options += '<option value="">' + placeholder + '</option>';
                }
                for (let i = 0; i < response[key].length; i++) {
                    var atributo1 = "";
                    if (typeof response[key][i].atributo1 != "undefined") {
                        atributo1 = response[key][i].atributo1;
                    }

                    if (typeof response[key][i].defecto != "undefined" && response[key][i].defecto == "S") {

                        options += '<option atributo1="' + atributo1 + '" selected="selected" value="' + response[key][i].id + '">' + response[key][i].descripcion + '</option>';

                        if(typeof document.getElementsByName(key)[0] != "undefined" && document.getElementsByName(key)[0].tagName == "SELECT") {
                            document.getElementsByName(key)[0].setAttribute("default-value", response[key][i].id)
                        }
                    } else {
                        options += '<option atributo1="' + atributo1 + '" value="' + response[key][i].id + '">' + response[key][i].descripcion + '</option>';
                    }




                }

                // console.log(document.getElementsByName(key));
                if(typeof document.getElementsByName(key)[0] != "undefined") {
                    if (document.getElementsByName(key)[0].classList.contains("selectized")) {
                        $("#" + document.getElementsByName(key)[0].id).selectize()[0].selectize.destroy();
                    }
                    document.getElementsByName(key)[0].innerHTML = options;
                    if (typeof document.getElementsByName(key)[0] != "undefined" && document.getElementsByName(key)[0].tagName == "SELECT" && document.getElementsByName(key)[0].classList.contains("selectizejs")) {

                        $("#" + document.getElementsByName(key)[0].id).selectize();


                    }
                }

            }


            return response;
        });
        return promise;
    }
    static mensaje(parametros) {
        // switch (parametros.status) {
        //  case "i": {
        //      parametros.type = "success";
        //      parametros.msg = (typeof parametros.msg == "undefined" ) ? "SE INSERTÓ CORRECTAMENTE" : parametros.msg;
        //      break;
        //  };
        //  case "m": {
        //      parametros.type = "success";
        //      parametros.msg = (typeof parametros.msg == "undefined" ) ? "SE MODIFICÓ CORRECTAMENTE" : parametros.msg;
        //      break;
        //  };
        //  case "e": {
        //      parametros.type = "success";
        //      parametros.msg = (typeof parametros.msg == "undefined" ) ? "SE ELIMINÓ CORRECTAMENTE" : parametros.msg;
        //      break;
        //  };
        //  case "ei": {
        //      parametros.type = "danger";
        //      parametros.msg = (typeof parametros.msg == "undefined" ) ? "ERROR AL INSERTAR" : parametros.msg;
        //      break;
        //  };
        //  case "ee": {
        //      parametros.type = "danger";
        //      parametros.msg = 'ERRROR AL ELIMINAR';
        //      break;
        //  };
        //  case "em": {
        //      parametros.type = "danger";
        //      parametros.msg = "ERROR AL MODIFICAR";
        //      break;
        //  };
        //  case "a": {
        //      parametros.type = "success";
        //      parametros.msg = "SE ANULÓ CORRECTAMENTE";
        //      break;
        //  };
        //  case "ea": {
        //      parametros.type = "danger";
        //      parametros.msg = "ERROR AL ANULAR";
        //      break;
        //  };
        //  case "ac": {
        //      parametros.type = "success";
        //      parametros.msg = "SE ACTIVÓ CORRECTAMENTE";
        //      break;
        //  };
        //  case "eac": {
        //      parametros.type = "danger";
        //      parametros.msg = "ERROR AL ACTIVAR";
        //      break;
        //  };
        // }
        BASE_JS.notificacion(parametros);
    }
    static notificacion(parametros) {
        //alert(parametros.type );
        parametros.position = (typeof parametros.position == "undefined") ? 'top right' : parametros.position;
        parametros.title = (typeof parametros.title == "undefined") ? mensaje : parametros.title;
        parametros.type = (typeof parametros.type == "undefined") ? 'warning' : parametros.type;
        // alert(parametros.msg);
        $.Notification.autoHideNotify(parametros.type, parametros.position, parametros.title, parametros.msg);
    }
    static sweet(parametros) {
        parametros.title = (typeof parametros.title == "undefined") ? alerta : parametros.title;
        parametros.type = (typeof parametros.type == "undefined") ? "warning" : parametros.type;
        if (typeof parametros.confirm == "undefined") {
            parametros.showCancelButton = false;
            parametros.showConfirmButton = false;
            parametros.timer = (typeof parametros.timer == "undefined") ? 2000 : parametros.timer;
            //2000;
        } else {
            parametros.showCancelButton = true;
            parametros.showConfirmButton = true;
            parametros.timer = null;
        }
        parametros.textYes = (typeof parametros.textYes == "undefined") ? "SI" : parametros.textYes;
        parametros.textNo = (typeof parametros.textNo == "undefined") ? "NO" : parametros.textNo;
        parametros.closeOnConfirm = (typeof parametros.closeOnConfirm == "undefined") ? true : parametros.closeOnConfirm;
        parametros.closeOnCancel = (typeof parametros.closeOnCancel == "undefined") ? true : parametros.closeOnCancel;
        if (typeof parametros.confirm == "undefined") {
            swal({
                title: parametros.title,
                text: parametros.text,
                type: parametros.type,
                showCancelButton: parametros.showCancelButton,
                showConfirmButton: parametros.showConfirmButton,
                confirmButtonText: parametros.textYes,
                cancelButtonText: parametros.textNo,
                closeOnConfirm: parametros.closeOnConfirm,
                closeOnCancel: parametros.closeOnCancel,
                timer: parametros.timer
            });
        } else {
            swal({
                title: parametros.title,
                text: parametros.text,
                type: parametros.type,
                showCancelButton: parametros.showCancelButton,
                showConfirmButton: parametros.showConfirmButton,
                confirmButtonText: parametros.textYes,
                cancelButtonText: parametros.textNo,
                closeOnConfirm: parametros.closeOnConfirm,
                closeOnCancel: parametros.closeOnCancel,
                timer: parametros.timer
            }, function(isConfirm) {
                if (typeof parametros.confirm != "undefined") {
                    if (isConfirm) {
                        if (typeof parametros.callbackConfirm == "function") {
                            parametros.callbackConfirm();
                        }
                    } else {
                        if (typeof parametros.callbackCancel == "function") {
                            parametros.callbackCancel();
                        }
                    }
                }
            });
        }
    }
    WindowOpen(parametros) {
        //console.log(parametros);
        parametros.method = (typeof parametros.method == "undefined") ? "POST" : parametros.title;
        var formulario = document.createElement("form");
        formulario.setAttribute("method", parametros.method);
        formulario.setAttribute("action", this.controladorURL + parametros.url);
        formulario.setAttribute("target", parametros.target);
        parametros.datos.forEach(function(item) {
            var campo = document.createElement("input");
            campo.setAttribute("type", "hidden");
            campo.setAttribute("name", Object.keys(item)[0]);
            campo.setAttribute("value", item[Object.keys(item)[0]]);
            formulario.appendChild(campo);
        });
        document.body.appendChild(formulario);
        window.open('', parametros.target);
        formulario.submit();
    }
    // static ObtenerDiasHabiles() {
    //     var anno = fecha.getFullYear();
    //     var mes = fecha.getMonth() + 1;
    //     var dia = fecha.getDate();
    //     var DiasHabiles = 0;
    //     //primero mes, luego anio
    // var DiasFeriados = [
    //     [1, 1],
    //     [4, 9],
    //     [4, 10],
    //     [5, 1],
    //     [6, 29],
    //     [7, 28],
    //     [7, 29],
    //     [8, 30],
    //     [10, 8],
    //     [11, 1],
    //     [12, 8],
    //     [12, 25]
    // ];
    //     // url: https://www.lawebdelprogramador.com/foros/JavaScript/1355015-Calculo-de-dias-laborales-y-que-un-input-tome-un-valor.html
    //     // url: https://www.todoexpertos.com/categorias/tecnologia-e-internet/desarrollo-de-sitios-web/javascript/respuestas/1253557/dias-habiles-sabado-domingo-y-festivos
    // }
    /**
     * [SumarDiasHabiles description]
     *
     * @param   {[type]}  dias   [dias description] dias habiles a sumar
     * @param   {[type]}  fecha  [fecha description] format dd/mm/yyyy, es la fecha inicial a la cual se sumara los dias habiles
     *
     * @return  {[type]}         [return description], se obtendra una nueva fecha con los dias habiles sumados
     */
    static SumarDiasHabiles(dias, fecha) {
        var DiasFeriados = ["1-1", "4-9", "4-10", "5-1", "6-29", "7-28", "7-29", "8-30", "10-8", "11-1", "12-8", "12-25"];
        var fecha1 = fecha;
        var diafecha1 = fecha1.slice(0, 2);
        var mesfecha1 = parseInt(fecha1.slice(3, 5)) - 1;
        var añofecha1 = fecha1.slice(6);
        var fechaconversion1 = new Date(añofecha1, mesfecha1, diafecha1);
        // var fecha2 = FechaFinal;
        // var diafecha2 = fecha2.slice(0,2);
        // var mesfecha2 = parseInt(fecha2.slice(3,5))-1;
        // var añofecha2 = fecha2.slice(6);
        // var fechaconversion2= new Date(añofecha2,mesfecha2,diafecha2);
        // var diferencia= fechaconversion2.getTime() - fechaconversion1.getTime();
        // var cantidaddias= Math.floor(diferencia/(1000*24*60*60))+1;
        // Cantidad de dias no labores(sábado y domingos)//-->
        var fecha3 = fechaconversion1;
        fecha3.setDate(fecha3.getDate() - 1);
        // for(var i=0 ;i < cantidaddias; i++){
        //     fecha3.setDate(fecha3.getDate() + 1);
        //     var diasemana=fecha3.getDay();
        //     var mes = fecha3.getMonth()+1;
        //     var dia = fecha3.getDate();
        //     //console.log(DiasFeriados.indexOf(mes.toString()+"-"+dia.toString()));
        //     if(diasemana==0 || diasemana==6 || DiasFeriados.indexOf(mes.toString()+"-"+dia.toString()) != -1){
        //         nolaboral++;
        //     }
        // }
        var nolaboral = 0;
        var laboral = 0;
        while (dias != laboral) {
            fecha3.setDate(fecha3.getDate() + 1);
            //console.log(FormatoFecha(fecha3, 'user'), nolaboral);
            var diasemana = fecha3.getDay();
            var mes = fecha3.getMonth() + 1;
            var dia = fecha3.getDate();
            //console.log(DiasFeriados.indexOf(mes.toString()+"-"+dia.toString()));
            // sabados, domingos y feriados
            if (diasemana == 0 || diasemana == 6 || DiasFeriados.indexOf(mes.toString() + "-" + dia.toString()) != -1) {
                nolaboral++;
            } else {
                laboral++;
            }
        }
        var hoy = fecha3;
        var dd = hoy.getDate();
        var mm = hoy.getMonth() + 1; //hoy es 0!
        var yyyy = hoy.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        hoy = dd + '/' + mm + '/' + yyyy;
        // if (type == "user") {
        //     hoy = dd + '/' + mm + '/' + yyyy;
        // }
        // if (type == "server") {
        //     hoy = yyyy + '-' + mm + '-' + dd;
        // }
        return hoy;
    }
    static HaBilitarModalEffects(id) {
        // document.getElementById(id).setAttribute("data-modal", "ModalProgreso");
        var overlay = document.querySelector('.md-overlay');
        var el = document.getElementById(id);
        var modal = document.querySelector('#ModalProgreso'),
            close = modal.querySelector('.ok');

        function removeModal(hasPerspective) {
            classie.remove(modal, 'md-show');
            if (hasPerspective) {
                classie.remove(document.documentElement, 'md-perspective');
            }
        }

        function removeModalHandler() {
            removeModal(classie.has(el, 'md-setperspective'));
            $(".modal-backdrop").remove();
        }
        el.addEventListener('click', function(ev) {
            // classie.add(modal, 'md-show');
            overlay.removeEventListener('click', removeModalHandler);
            overlay.addEventListener('click', removeModalHandler);
            if (classie.has(el, 'md-setperspective')) {
                setTimeout(function() {
                    classie.add(document.documentElement, 'md-perspective');
                }, 25);
            }
        });
        close.addEventListener('click', function(ev) {
            ev.stopPropagation();
            removeModalHandler();
        });


    }
    static Procesando(proceso_id) {
        var data_proceso = new URLSearchParams(BASE_JS.serialize({proceso_id: proceso_id, _token: _token}));
        var promise = fetch(BaseUrl + "/importar/procesos", {
            method: 'POST',
            cache: "force-cache",
            body: data_proceso,
        }).then(function(response) {

            return response.text();
        }).catch(function(error) {
            BASE_JS.sweet({
                text: 'HUBO UN PROBLEMA CON LA PETICIÓN FETCH -> ' + error.message
            });
        }).then(function(response) {
            //console.log(response);
            //console.log(typeof response);
            var array = response.split("|");
            //console.log(array.length);
            // console.log(response.length);
            var proceso_total_elementos_procesar = parseInt(array[0]);
            var proceso_numero_elementos_procesados = parseInt(array[1]);
            var proceso_porcentaje_actual_progreso = parseFloat(array[2]);
            var proceso_tiempo_transcurrido = array[3];
            //console.log(proceso_total_elementos_procesar + " > " + proceso_numero_elementos_procesados);
            document.getElementById("BarraProgreso").getElementsByClassName("progress-bar")[0].setAttribute("aria-valuenow", proceso_porcentaje_actual_progreso);
            document.getElementById("PorcentajeProgreso").innerText = proceso_porcentaje_actual_progreso + "%";
            document.getElementById("BarraProgreso").getElementsByClassName("progress-bar")[0].setAttribute("style", "width: " + proceso_porcentaje_actual_progreso + "%;");
            // alert(TotalElementos +">"+ ElementosProcesados)
            document.getElementById("TiempoTranscurrido").innerText = proceso_tiempo_transcurrido;
            if (proceso_total_elementos_procesar > proceso_numero_elementos_procesados) {
                //alert(proceso_id);
                //Procesando(proceso_id);
                setTimeout(function() {
                    BASE_JS.Procesando(proceso_id);
                }, 500)
            } else {
                var datos = new URLSearchParams(BASE_JS.serialize({proceso_id: proceso_id, _token: _token}));
                fetch(BaseUrl + "/principal/EliminarProceso", {
                    method: 'POST',
                    body: datos,
                    cache: "force-cache",

                }).then(function(response) {
                    return response.text();
                }).catch(function(error) {
                    BASE_JS.sweet({
                        text: 'HUBO UN PROBLEMA AL ELIMINAR ARCHIVO DE PROCESO '+proceso_id+' -> ' + error.message
                    });
                }).then(function(response) {
                    console.log("eliminar proceso " + response);
                    document.getElementsByClassName("ok")[0].style.display = "block";
                    return response;
                });

            }
            return response;
        });
        return promise;




    }

    validar_email(name) {
        var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        var valor = this.buscarEnFormulario(name).value;
        if (this.buscarEnFormulario(name)) {
            if (valor != "") {

                if (emailRegex.test(valor)) {
                    this.buscarEnFormulario(name).parentNode.classList.remove('has-error');
                    return true;
                } else {

                }
            }
        }

        BASE_JS.notificacion({title: advertencia, type: 'warning', msg: email_invalido});
        this.buscarEnFormulario(name).parentNode.classList.add('has-error');
        return false;

    }
}


// ~~~~~~~ similar a $.fn de jquery ~~~~~~ //

// HTMLElement.prototype.hello = function()
// {
// console.log(this.value+" says hello world.");
// }

// ~~~~~~~~~~~~~~ aplicacion ~~~~~~~~~~~~~ //
// document.getElementById('cliente_tipopersona').hello()

// ~~~~~~~~~~~~~~ referencia ~~~~~~~~~~~~~ //
// https://stackoverflow.com/questions/31719677/is-there-a-pure-javascript-equivalent-to-jquerys-fn-extend
// https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement
