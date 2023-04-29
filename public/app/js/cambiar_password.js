var usuarios = new BASE_JS('usuarios', 'usuarios');
document.getElementsByName("nueva_pass_1")[0].addEventListener("change", function(event) {
    var nueva_pass_2 = document.getElementsByName("nueva_pass_2")[0].value;

    var required = true;
    required = required && usuarios.required("nueva_pass_1");
    required = required && usuarios.required("nueva_pass_2");
    if(required) {
        if(this.value != nueva_pass_2) {
            BASE_JS.notificacion({
                msg: 'LAS CONTRASEÑAS NO COINCIDEN',
                type: 'warning',
            });

            document.getElementById("guardar-usuario").disabled = true;
        } else {
            document.getElementById("guardar-usuario").disabled = false;
        }
    }

})

document.getElementsByName("nueva_pass_2")[0].addEventListener("change", function(event) {
    var nueva_pass_1 = document.getElementsByName("nueva_pass_1")[0].value;
    var required = true;
    required = required && usuarios.required("nueva_pass_1");
    required = required && usuarios.required("nueva_pass_2");
    //alert(required);
    if(required) {
        if(this.value != nueva_pass_1) {
            BASE_JS.notificacion({
                type: 'warning',
                msg: 'LAS CONTRASEÑAS NO COINCIDEN'
            });
            document.getElementById("guardar-usuario").disabled = true;
        } else {
            document.getElementById("guardar-usuario").disabled = false;
        }
    }
})


document.getElementById("guardar-usuario").addEventListener("click", function(event) {
    event.preventDefault();

    var required = true;
   

    required = required && usuarios.required("nueva_pass_1");
    required = required && usuarios.required("nueva_pass_2");





    if(required) {
        usuarios.guardar();
        
       
    }
})