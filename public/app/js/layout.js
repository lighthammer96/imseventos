//var tabID = sessionStorage.tabID ? sessionStorage.tabID : sessionStorage.tabID = Math.random();

var url = this.window.location.pathname;
var partesUrl = url.split("/");
// var route = partesUrl[partesUrl.length-1];
var ruta = partesUrl[partesUrl.length-2] + "/" + partesUrl[partesUrl.length-1];
var elementos = document.getElementsByClassName("modulosUrl");
for(let i = 0; i < elementos.length; i++) {
	if(typeof elementos[i].getAttribute("modulo_controlador") != "undefined" && elementos[i].getAttribute("modulo_controlador") == ruta) {

		// var tipodoc_id = elementos[i].getAttribute("tipodoc_id");

		var modulo_id = elementos[i].getAttribute("modulo_id");
		var modulo_controlador = elementos[i].getAttribute("modulo_controlador");
		elementos[i].parentNode.classList.add("active");
		elementos[i].parentNode.parentNode.parentNode.classList.add("active");
		// elementos[i].getElementsByTagName("i")[0].classList.remove("fa fa-circle-o");
		// elementos[i].getElementsByTagName("i")[0].classList.add("fa fa-circle");

		$(elementos[i]).find("i").removeClass("fa fa-circle-o");
		$(elementos[i]).find("i").addClass("fa fa-circle");
		// console.log();

	}

}

var modulos_pantalla_completa = ["DocumentosController"];

document.addEventListener("DOMContentLoaded", function() {

	// $("input[name=fecha_proceso]").inputmask();
	//alert(session.fecha_proceso);
	// document.getElementsByName("fecha_proceso")[0].value = (typeof session.fecha_proceso == "undefined") ?BASE_JS.ObtenerFechaActual("user") : BASE_JS.FormatoFecha(session.fecha_proceso, "user");

	// jQuery("input[name=fecha_proceso]").datepicker({
	// 	format: "dd/mm/yyyy",
	// 	language: "es",
	// 	todayHighlight: true,
	// 	todayBtn: "linked",
	// 	autoclose: true,
	// 	endDate: "now()",

	// });
	var botones = document.getElementsByTagName("button");

	setTimeout(function() {
		for (let index = 0; index < botones.length; index++) {
			botones[index].disabled = false;

		}
	}, '500');


	// $.post(BaseUrl + 'PrincipalController/validarInicioSistema', {}, function(data, textStatus, xhr) {
	//     if(data.response == "NO") {
	//         $("#modalConfig").modal("show");
	//     } else {
	//         $("#modalConfig").modal("hide");
	//     }
	// }, 'json');

	//PARA MINIMIZAR MENU LATERAL Y QUE LA TABLA GANE MAS ESPACIO
	// if(modulos_pantalla_completa.indexOf(modulo_controlador) != -1) {
	// 	var modulosUrl = document.getElementsByClassName("modulosUrl");
	// 	for (let index = 0; index < modulosUrl.length; index++) {
	// 		if(modulosUrl[index].getAttribute("modulo_controlador") == modulo_controlador) {
	// 			//alert("ola");
	// 			//modulosUrl[index].classList.remove("active");
	// 			modulosUrl[index].parentNode.parentNode.style = "";
	// 		}

	// 	}
	// 	document.getElementById("wrapper").classList.add("forced");
	// 	document.getElementById("wrapper").classList.add("enlarged");
	// } else {
	// 	document.getElementById("wrapper").classList.remove("forced");
	// 	document.getElementById("wrapper").classList.remove("enlarged");
	// }



});



// HTMLElement.prototype.prependHtml = function (element) {
//     const div = document.createElement('div');
//     div.innerHTML = element;
//     this.insertBefore(div, this.firstChild);
// };

// HTMLElement.prototype.appendHtml = function (element) {
//     const div = document.createElement('div');
//     div.innerHTML = element;
//     while (div.children.length > 0) {
//         this.appendChild(div.children[0]);
//     }
// };


$(document).on("change", "#idioma_sistema", function(e) {
	e.preventDefault();
	var array = this.value.toString().split("|");
	$.ajax({
		url: BaseUrl+'/principal/cambiar_idioma',
		type: 'POST',
		dataType: 'json',
		data: "idioma_id="+array[0]+"&idioma_codigo="+array[1]+"&_token="+_token
	}).done(function(json) {
		// console.log(json);
		if(json.response == 'ok') {
			// alert();
			if(typeof modulo_controlador != "undefined") {

				window.location = BaseUrl+"/"+modulo_controlador;
			} else {
				window.location = BaseUrl+"/principal/index";
			}
		} else {

		}
	}).fail(function() {
		console.log("ERROR 1");
	}).always(function() {
		console.log("ERROR 2");
	});
})



$(document).on("keydown", "#buscador", function(e) {

	// console.log(e);
	if(e.keyCode == 13) {
		e.preventDefault();
	}



})


$(document).on("click", "#search-btn", function(e) {

	// console.log(e);


	e.preventDefault();
	var buscador = $("#buscador").val();
	if(buscador != "") {
		$.ajax({
			url: BaseUrl+'/principal/consultar_modulo',
			type: 'POST',
			dataType: 'json',
			data: "buscador="+buscador+"&_token="+_token
		}).done(function(json) {
			// console.log(json);
			if(json.length > 0) {
				// alert();
				window.location = BaseUrl+"/"+json[0].modulo_controlador;
			} else {
				alert(no_hay_modulo+": "+buscador);
			}
			// return false;
		}).fail(function() {
			console.log("ERROR 1");
			// return false;
		}).always(function() {
			console.log("ERROR 2");
			// return false;
		});

	}

})




$(document).on("mouseover", ".modulosUrl", function(e) {
	// console.log($(this).text());
	if(!$(this).parent("li").hasClass("active")) {
		$(this).find("i").removeClass("fa fa-circle-o");
		$(this).find("i").addClass("fa fa-circle");
	}

})

$(document).on("mouseout", ".modulosUrl", function(e) {
	if(!$(this).parent("li").hasClass("active")) {
		$(this).find("i").removeClass("fa fa-circle");
		$(this).find("i").addClass("fa fa-circle-o");
	}

})

function validarkeys(e, type) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = type;
    //46 -> es el punto
    especiales = [8, 37, 39, 32];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    //alert(tecla);
    // alert(letras.indexOf(tecla));
    // alert(tecla_especial);
    if(letras.indexOf(tecla) == -1 && !tecla_especial) {
       // alert("entro");
        e.preventDefault();
        //return false; // no funciona con esto
    }

}

HTMLElement.prototype.solo_letras = function () {
    var solo_letras = "áéíóúabcdefghijklmnñopqrstuvwxyz";
	// console.log(this);
	$(this).keypress(function(event) {
		// console.log(event);
        validarkeys(event, solo_letras);
    });

};

HTMLElement.prototype.solo_numeros = function () {
    var solo_numeros = "0123456789";
	// console.log(this);
	$(this).keypress(function(event) {
        validarkeys(event, solo_numeros);
    });

};


HTMLElement.prototype.decimales = function () {
    var decimales = "/.0123456789";
	// console.log(this);
	$(this).keypress(function(event) {
        validarkeys(event, decimales);
    });

};


// $(document).on("focus", "input", function () {
//     $(this).parent("div").addClass("focus-input");
// });

// $(document).on("focusout", "input", function () {
//     $(this).parent("div").removeClass("focus-input");
// });

