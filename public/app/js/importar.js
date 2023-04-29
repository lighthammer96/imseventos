var importar = new BASE_JS('importar', 'importar');

document.addEventListener("DOMContentLoaded", function() {
    
    BASE_JS.HaBilitarModalEffects("importar");
   
   
    document.getElementById("importar").addEventListener("click", function(event) {
        event.preventDefault();
        var required = true;

        required = required && importar.required("dato");
        required = required && importar.required("excel");

        if(required) {
            var promise = importar.guardar();

            promise.then(function(response) {
    
                document.getElementById("CargandoProceso").style.display = "none";
                if (typeof response.msg != "undefined") {
                    // BASE_JS.sweet({
                    //     text: response.msg
                    // });
                    document.getElementsByClassName("MensajeProgreso")[0].style.display = "block";
                    document.getElementById("TituloProgreso").style.display = "none";
                    document.getElementById("BarraProgreso").style.display = "none";
                    document.getElementById("TiempoTranscurrido").style.display = "none";
                    $("#MensajeProgreso").find("h3").find("strong").text(response.msg);
                    document.getElementsByClassName("ok")[0].style.display = "block";
                    return false;
                }
                document.getElementById("MensajeProgreso").style.display = "none";
                document.getElementById("TituloProgreso").style.display = "block";
                document.getElementById("BarraProgreso").style.display = "block";
                document.getElementById("TiempoTranscurrido").style.display = "block";

                var modal = document.querySelector('#ModalProgreso');
                classie.add(modal, 'md-show');
               // $("#ModalProgreso").modal("show");
                importar.AjaxAsync({
                    url: '/importar_datos',
                    datos: {
                        NombreFile: response.NombreFile,
                        proceso_id: response.proceso_id,
                        total_elementos: response.total_elementos,
                        dato: document.getElementById("dato").value
                    }
                }).then(function(datos) {
                    //console.log(datos);
                })
    
                BASE_JS.Procesando(response.proceso_id);
            })
        }
      
    })

    document.getElementById("dato").addEventListener("change", function() {
        document.getElementById("formato").setAttribute("href", BaseUrl + "/formatos_carga/"+ this.value+".xlsx");
    })


 

})