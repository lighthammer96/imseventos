var asistencias_evento = new BASE_JS("asistencias_evento", "reportes");

var principal = new BASE_JS("principal", "principal");
var eventos = new BASE_JS("eventos", "eventos");


document.addEventListener("DOMContentLoaded", function() {

    eventos.select({
        name: 'evento_id',
        url: '/obtener_eventos',
        placeholder: "Seleccione ..."
    });

    $(document).on("change", "#evento_id", function () {
        asistencias_evento.buscarEnFormulario("evento_descripcion").value = $("#evento_id option:selected").text();
    });


    document.getElementById("exportar_excel").addEventListener("click", function(e) {
        e.preventDefault();
        var required = true;

        required = required && asistencias_evento.required("evento_id");

        if(required) {
            $("#formulario-asistencias_evento").attr("action", BaseUrl + "/reportes/exportar_excel_asistencias_evento");
            $("#formulario-asistencias_evento").attr("method", "GET");
            $("#formulario-asistencias_evento").attr("target", "exportar_excel");


            window.open('', 'exportar_excel');
            document.getElementById('formulario-asistencias_evento').submit();
        }

    })




})
