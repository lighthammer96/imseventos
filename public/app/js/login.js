$(function() {


    var login = new BASE_JS("login", "login");



    $("#user").focus();


    function loguearse() {

        var required = true;
        // required = required && modulos.required("modulo_nombre");
        required = required && login.required("user");
        required = required && login.required("pass");
        // required = required && login.required("pais_id");

        if(!required) {
            return false;
        }

        $.ajax({
            url: 'login/loguearse',
            type: 'POST',
            dataType: 'json',
            data: "user="+$("#user").val()+"&"+"pass="+$("#pass").val()+"&_token="+_token
        }).done(function(json) {
            // console.log(json);
            if(json.response == 'ok') {
                window.location = "principal/index";
            } else {
                switch(json.response) {
                    case 'nouser':
                    alert("USUARIO INCORRECTO!");
                    break;
                    case 'nopass':
                    alert("CONTRASEÑA INCORRECTA!");
                    break;
                    case 'nopersonal':
                    alert("POR FAVOR AGREGUE ESTE USUARIO A UN PERSONAL!");
                    break;
                }
            }
        }).fail(function() {
            console.log("OCURRIO UN ERROR");
        }).always(function() {
            console.log("COMPLETAR JSON");
        });
    }

    $("#btn-login").on("click",function(e) {
        e.preventDefault();
        loguearse();
    })

    $("#pass").keypress(function(e) {

        if(e.which == 13) {
            loguearse();
        }
    });
})
