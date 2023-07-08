var reporte_vuelos = new BASE_JS("reporte_vuelos", "reportes");

var principal = new BASE_JS("principal", "principal");
var eventos = new BASE_JS("eventos", "eventos");


document.addEventListener("DOMContentLoaded", function() {

    eventos.select({
        name: 'evento_id',
        url: '/obtener_eventos',
        placeholder: "Seleccione ..."
    });
    $("input[name=registro_fecha_llegada]").attr("data-inputmask", "'alias': 'dd/mm/yyyy'");

    $("input[name=registro_fecha_llegada]").inputmask();
    jQuery("input[name=registro_fecha_llegada]").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,


    });

    $(document).on("click", "#calendar-registro_fecha_llegada", function (e) {
        e.preventDefault();


        if ($("input[name=registro_fecha_llegada]").hasClass("focus-datepicker")) {

            $("input[name=registro_fecha_llegada]").blur();
            $("input[name=registro_fecha_llegada]").removeClass("focus-datepicker");
        } else {

            $("input[name=registro_fecha_llegada]").focus();
            $("input[name=fechanacimiento]").addClass("focus-datepicker");
        }

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
