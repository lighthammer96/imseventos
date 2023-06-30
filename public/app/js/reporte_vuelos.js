var reporte_vuelos = new BASE_JS("reporte_vuelos", "reportes");

var principal = new BASE_JS("principal", "principal");
var eventos = new BASE_JS("eventos", "eventos");


document.addEventListener("DOMContentLoaded", function() {

    eventos.select({
        name: 'evento_id',
        url: '/obtener_eventos',
        placeholder: "Seleccione ..."
    });


    document.getElementById("exportar_excel").addEventListener("click", function(e) {
        e.preventDefault();
        var required = true;

        required = required && reporte_vuelos.required("evento_id");


        if(required) {
            $("#formulario-reporte_vuelos").attr("action", BaseUrl + "/reportes/exportar_excel_reporte_vuelos");
            $("#formulario-reporte_vuelos").attr("method", "GET");
            $("#formulario-reporte_vuelos").attr("target", "exportar_excel");


            window.open('', 'exportar_excel');
            document.getElementById('formulario-reporte_vuelos').submit();
        }

    })




})
