var visitantes_recepcionados = new BASE_JS("visitantes_recepcionados", "reportes");

var principal = new BASE_JS("principal", "principal");
var eventos = new BASE_JS("eventos", "eventos");


document.addEventListener("DOMContentLoaded", function() {

    eventos.select({
        name: 'evento_id',
        url: '/obtener_eventos',
        placeholder: "Seleccione ..."
    });

    $(document).on("change", "#evento_id", function () {
        visitantes_recepcionados.buscarEnFormulario("evento_descripcion").value = $("#evento_id option:selected").text();


    });



    document.getElementById("exportar_excel").addEventListener("click", function(e) {
        e.preventDefault();
        var required = true;

        required = required && visitantes_recepcionados.required("evento_id");


        if(required) {
            $("#formulario-visitantes_recepcionados").attr("action", BaseUrl + "/reportes/exportar_excel_visitantes_recepcionados");
            $("#formulario-visitantes_recepcionados").attr("method", "GET");
            $("#formulario-visitantes_recepcionados").attr("target", "exportar_excel");


            window.open('', 'exportar_excel');
            document.getElementById('formulario-visitantes_recepcionados').submit();
        }

    })




})
