var participantes_evento = new BASE_JS("participantes_evento", "reportes");

var principal = new BASE_JS("principal", "principal");
var eventos = new BASE_JS("eventos", "eventos");


document.addEventListener("DOMContentLoaded", function() {

    eventos.select({
        name: 'evento_id',
        url: '/obtener_eventos',
        placeholder: "Seleccione ..."
    });

    $(document).on("change", "#evento_id", function () {
        participantes_evento.buscarEnFormulario("evento_descripcion").value = $("#evento_id option:selected").text();
    });


    document.getElementById("exportar_excel").addEventListener("click", function(e) {
        e.preventDefault();
        var required = true;

        required = required && participantes_evento.required("evento_id");

        if(required) {
            $("#formulario-participantes_evento").attr("action", BaseUrl + "/reportes/exportar_excel_participantes_evento");
            $("#formulario-participantes_evento").attr("method", "GET");
            $("#formulario-participantes_evento").attr("target", "exportar_excel");


            window.open('', 'exportar_excel');
            document.getElementById('formulario-participantes_evento').submit();
        }

    })




})
