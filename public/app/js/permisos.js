// var perfiles = new BASE_JS("perfiles", 'PerfilesController');
var permisos = new BASE_JS("permisos", "permisos");
var perfiles = new BASE_JS("perfiles", "perfiles");

document.addEventListener("DOMContentLoaded", function() {

    perfiles.select({
        name: 'perfil_id',
        url: '/obtener_perfiles',
        placeholder: "Seleccione ..."
    });


    $(function() {
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
    })


    // document.getElementsByName("perfil_id")[0].addEventListener("change", function() {

    $(document).on("change", "#perfil_id", function() {
        var perfil_id = $(this).val();
        if(perfil_id != "") {
            permisos.ajax({
                url: '/get',
                datos: { perfil_id: perfil_id }
            }).then(function(response) {
                var checks = document.getElementsByClassName("checkboxes");
                for(let i = 0; i < checks.length; i++){
                    if(buscarEnDom(checks[i].getElementsByTagName("input")[0], response)) {
                        checks[i].getElementsByTagName("input")[0].checked = true;
                        checks[i].getElementsByClassName("icheckbox_minimal-blue")[0].classList.add("checked");
                    } else {
                        checks[i].getElementsByTagName("input")[0].checked = false;
                        checks[i].getElementsByClassName("icheckbox_minimal-blue")[0].classList.remove("checked");

                    }
                }

            });
        } else {
            var checks = document.getElementsByClassName("checkboxes");
            for(let i = 0; i < checks.length; i++){
                checks[i].getElementsByTagName("input")[0].checked = false;
            }
        }
    })
    function buscarEnDom(elemento, object) {
        for(let j = 0; j < object.length; j++) {
            // if((object[j].modulo_id == elemento.value && elemento.name == "modulo_id[]")  || (object[j].accion_id == elemento.value && elemento.name == 'accion_id_'+object[j].modulo_id+'[]')) {
            if((object[j].modulo_id == elemento.value && elemento.name == "modulo_id[]")) {
                return elemento;


            }

        }

        return false;
    }

    document.getElementById("guardar-permisos").addEventListener("click", function(event) {
        event.preventDefault();
        if($("select[name=perfil_id]").val() == "") {
            $("select[name=perfil_id]").focus(); return false;
        }
    // alert("flow");
        var promise = permisos.guardar();
        promise.then(function(response) {
            if(typeof response.status == "undefined" || response.status.indexOf("e") != -1) {
                return false;
            }
            // CargarMenu();
            setTimeout(function () {
                window.location = permisos.controladorURL+"/index   ";
            }, '1000');
            // recagarPagina();
        });

    })

    // function recagarPagina() {
    // 	window.location = permisos.controladorURL;
    // }

    var padres = document.getElementsByClassName("padre");

    for(let i = 0; i < padres.length; i++){
        padres[i].addEventListener("click", function(event) {
            event.preventDefault();
            var checks = this.parentNode.getElementsByClassName("checkboxes");

            if(this.classList.contains('todo')) {
                for(let j = 0; j < checks.length; j++){


                    checks[j].getElementsByTagName("input")[0].checked = true;
                    //console.log(checks[j].getElementsByClassName("icheckbox_minimal-blue")[0]);
                    checks[j].getElementsByClassName("icheckbox_minimal-blue")[0].classList.add("checked");
                }

                this.classList.add("ninguno");
                this.classList.remove("todo");
            } else {
                if(this.classList.contains('ninguno')) {
                    for(let j = 0; j < checks.length; j++){
                        // checks[j].click();
                        checks[j].getElementsByTagName("input")[0].checked = false;

                        checks[j].getElementsByClassName("icheckbox_minimal-blue")[0].classList.remove("checked");
                    }

                    this.classList.add("todo");
                    this.classList.remove("ninguno");
                }
            }
        })
    }


    var checkboxes = document.getElementsByClassName("checkboxes");

    for(let i = 0; i < checkboxes.length; i++){
        checkboxes[i].addEventListener("click", function(event) {
            event.preventDefault();

            // alert(typeof this.nextSibling.getElementsByClassName("checkboxes")); return;
            if(this.nextSibling != null && this.nextSibling.nodeName != "#text") {
                //console.log(this.nextSibling.nodeName);
                var checks = this.nextSibling.getElementsByClassName("checkboxes");

                if(this.nextSibling.classList.contains('todo')) {
                    this.getElementsByTagName("input")[0].checked = true;
                    for(let j = 0; j < checks.length; j++){

                        checks[j].getElementsByTagName("input")[0].checked = true;
                    }
                    this.nextSibling.classList.add("ninguno");
                    this.nextSibling.classList.remove("todo");
                } else {
                    if(this.nextSibling.classList.contains('ninguno')) {
                        this.getElementsByTagName("input")[0].checked = false;
                        for(let j = 0; j < checks.length; j++){

                            checks[j].getElementsByTagName("input")[0].checked = false;
                        }
                        this.nextSibling.classList.add("todo");
                        this.nextSibling.classList.remove("ninguno");
                    }
                }
            } else {

                if(this.getElementsByTagName("input")[0].checked) {
                    this.getElementsByTagName("input")[0].checked = false;
                } else {
                    this.getElementsByTagName("input")[0].checked = true;
                }
            }

        })
    }


})

