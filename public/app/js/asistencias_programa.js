var asistencias_programa = new BASE_JS("asistencias_programa", "reportes");

var principal = new BASE_JS("principal", "principal");
var eventos = new BASE_JS("eventos", "eventos");
var programas = new BASE_JS("programas", "programas");


document.addEventListener("DOMContentLoaded", function() {

    asistencias_programa.select_init({
        placeholder: "Seleccione ..."
    });

    $(document).on("change", "#evento_id", function () {
        asistencias_programa.buscarEnFormulario("evento_descripcion").value = $("#evento_id option:selected").text();
        programas.select({
            name: 'programa_id',
            url: '/obtener_programas_select',
            placeholder: "Seleccione ...",
            datos: { evento_id: $("#evento_id").val(), tp_id: $("#tp_id").val() }


        });

    });
    $(document).on("change", "#tp_id", function () {

        programas.select({
            name: 'programa_id',
            url: '/obtener_programas_select',
            placeholder: "Seleccione ...",
            datos: { evento_id: $("#evento_id").val(), tp_id: $("#tp_id").val() }
        });
    });

    $(document).on("change", "#programa_id", function () {
        asistencias_programa.buscarEnFormulario("programa_descripcion").value = $("#programa_id option:selected").text();

    });


    document.getElementById("exportar_excel").addEventListener("click", function(e) {
        e.preventDefault();
        var required = true;

        required = required && asistencias_programa.required("evento_id");

        if(required) {
            $("#formulario-asistencias_programa").attr("action", BaseUrl + "/reportes/exportar_excel_asistencias_programa");
            $("#formulario-asistencias_programa").attr("method", "GET");
            $("#formulario-asistencias_programa").attr("target", "exportar_excel");


            window.open('', 'exportar_excel');
            document.getElementById('formulario-asistencias_programa').submit();
        }

    })




})
