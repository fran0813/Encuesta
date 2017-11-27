$( document ).ready(function() {
	limpiar();
	refrescarPreguntas();
	refrescarRespuestasCerradas();
});

// Crear la pregunta abierta
$("#formCrearPreguntaAbierta").on("submit", function()
{
	var preguntaAbierta = $("#preguntaAbierta").val();

	if(preguntaAbierta == ""){
		$('#respuestaCrearPreguntaAbierta').html("Por favor ingrese la pregunta");
	}else{

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearPreguntaAbierta",
			dataType: 'json',
			data: { preguntaAbierta: preguntaAbierta }
		})

		.done(function(response) {
			$('#respuestaCrearPreguntaAbierta').html(response.html);
			refrescarPreguntas();
			$("#preguntaAbierta").val("");
		});

	}
	return false;
});

// Crear la pregunta cerrada
$("#formCrearPreguntaCerrada").on("submit", function()
{
	var preguntaCerrada = $("#preguntaCerrada").val();
	var id = "crear";

	if(preguntaCerrada == ""){
		$('#respuestaCrearPreguntaCerrada').html("Por favor ingrese la pregunta");
	}else{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearPreguntaCerrada",
			dataType: 'json',
			data: { preguntaCerrada: preguntaCerrada }
		})

		.done(function(response) {
			$('#respuestaCrearPreguntaCerrada').html(response.html);

			if(response.verificar == true){
				$("#preguntaCerrada").prop('disabled', true);
				$("#btnPreguntaCerrada").prop('disabled', true);
				$("#respuestaPregunta").prop('disabled', false);
				$("#btnRespuestaCerrada").prop('disabled', false);
				idCerrada(id);
				refrescarRespuestasCerradas();
			}
		});
	}
	return false;
});

// Crear respuesta cerrada
$("#formCrearRespuestaCerrada").on("submit", function(){

	var tipo = "crear";
	var respuestaPregunta = $("#respuestaPregunta").val();

	if(respuestaPregunta == ""){
		$('#respuestaCrearRespuestaCerrada').html("Por favor ingrese la respuesta");
	}else{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearRespuestaCerrada",
			dataType: 'json',
			data: { respuestaPregunta: respuestaPregunta,
					tipo: tipo }
		})

		.done(function(response) {
			refrescarRespuestasCerradas();			
		});		
	}
	return false;
});

// Crear respuesta cerrada
$("#formCrearRespuestaCerrada2").on("submit", function(){

	var tipo = "editar";
	var respuestaPregunta = $("#respuestaPregunta2").val();

	if(respuestaPregunta == ""){
		$('#respuestaCrearRespuestaCerrada2').html("Por favor ingrese la respuesta");
	}else{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearRespuestaCerrada",
			dataType: 'json',
			data: { respuestaPregunta: respuestaPregunta,
					tipo: tipo }
		})

		.done(function(response) {
			var tipo = "crear";
			refrescarRespuestasCerradas();			
		});		
	}
	return false;
});

$("#tablaPreguntas").on("click", "a", function(){

	var clase = $(this).attr("class");
	var id = $(this).attr("id");

	if(clase == "btn btn-success"){
		
		$.ajax({
			method: "GET",
			url: "/admin/mostrarActualizarPregunta",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			if(response.tipo == "abierta"){			
				$('#preguntaAbierta2').val(response.pregunta);
				idAbierta(id);
			}else if(response.tipo == "cerrada"){
				$('#preguntaCerrada2').val(response.pregunta);
				$('#respuestaVerdadera2').html(response.correcta);
				idCerrada(id);
				refrescarRespuestasCerradas();
				limpiar();
				limpiar2();
			}
		});
	}else if(clase == "btn btn-danger"){

		$.ajax({
			method: "GET",
			url: "/admin/eliminarPregunta",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {			
			refrescarPreguntas();
		});
	}

});	

$("#tablaRespuestasCerradas2").on("click", "a", function(){

	var clase = $(this).attr("class");
	var id = $(this).attr("id");
	idRespuestaCerrada(id);

	if(clase == "btn btn-success"){
		var tipo = "editar";

		$.ajax({
			method: "GET",
			url: "/admin/mostrarActualizarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {		
			$('#respuestaCerrada2').val(response.respuesta);
		});
	}else if(clase == "btn btn-info"){

		$.ajax({
			method: "GET",
			url: "/admin/verdadera",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			$('#respuestaVerdadera2').html(response.html);
		});
	}else if(clase == "btn btn-danger"){
		$.ajax({
			method: "GET",
			url: "/admin/eliminarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			refrescarRespuestasCerradas();
		});
	}

});

// Funciones de la tabla de respuestas cuando se crea la pregunta cerrada
$("#tablaRespuestasCerradas").on("click", "a", function()
{
	var clase = $(this).attr("class");
	var id = $(this).attr("id");
	idRespuestaCerrada(id);

	if(clase == "btn btn-success"){
		var tipo = "editar";
		$.ajax({
			method: "GET",
			url: "/admin/mostrarActualizarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			$('#respuestaCerrada2').val(response.respuesta);
		});
	}else if(clase == "btn btn-info"){
		$.ajax({
			method: "GET",
			url: "/admin/verdadera",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			$('#respuestaVerdadera').html(response.html);
		});
	}else if(clase == "btn btn-danger"){
		$.ajax({
			method: "GET",
			url: "/admin/eliminarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			refrescarRespuestasCerradas();
		});
	}
});

// Crear la encuestas
$("#formEditarPreguntaAbierta").on("submit", function(){

	var preguntaAbierta2 = $("#preguntaAbierta2").val();

	if(preguntaAbierta2 == ""){
		$('#respuestaEditarPreguntaAbierta').html("Porfavor ingrese la pregunta abierta");
	}else{

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/editarPreguntaAbierta",
			dataType: 'json',
			data: { preguntaAbierta: preguntaAbierta2 }
		})

		.done(function(response) {
			$('#respuestaEditarPreguntaAbierta').html(response.html);
			refrescarPreguntas();
		});
		
	}

	return false;
});

// Editar pregunta cerrada
$("#formEditarPreguntaCerrada").on("submit", function(){

	var preguntaCerrada2 = $("#preguntaCerrada2").val();

	if(preguntaCerrada2 == ""){
		$('#respuestaEditarPreguntaCerrada').html("Porfavor ingrese la pregunta abierta");
	}else{

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/editarPreguntaCerrada",
			dataType: 'json',
			data: { preguntaCerrada: preguntaCerrada2 }
		})

		.done(function(response) {
			$('#respuestaEditarPreguntaCerrada').html(response.html);
			$('#respuestaEditarRespuestaCerrada').html(response.html);
			$("#preguntaCerrada2").prop('disabled', true);
			$("#btnPreguntaCerrada2").prop('disabled', true);
			$("#respuestaPregunta2").prop('disabled', false);
			$("#btnRespuestaCerrada2").prop('disabled', false);
			refrescarPreguntas();
		});
		
	}

	return false;
});

// Editar respuesta cerrada
$("#formEditarRespuestaCerrada").on("submit", function(){

	var respuestaCerrada2 = $("#respuestaCerrada2").val();

	if(preguntaCerrada2 == ""){
		$('#respuestaEditarRespuestaCerrada').html("Porfavor ingrese la respuesta");
	}else{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/editarRespuestaCerrada",
			dataType: 'json',
			data: { respuestaCerrada: respuestaCerrada2 }
		})

		.done(function(response) {
			refrescarRespuestasCerradas();
		});
	}
	return false;
});

function idAbierta(id) {
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idAbierta",
		dataType: 'json',
		data: { id: id }
	})

	.done(function(response) {

	});
}

function idCerrada(id) {
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idCerrada",
		dataType: 'json',
		data: { id: id }
	})

	.done(function(response) {

	});
}

// Establece el id de la respuesta
function idRespuestaCerrada(id)
{

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idRespuestaCerrada",
		dataType: 'json',
		data: { id: id}
	})

	.done(function(response){
		console.info(response)
	});
}

// Refresca la tabla de preguntas
function refrescarPreguntas()
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "GET",
		url: "/admin/mostrarPreguntas",
		dataType: 'json',
		data: {}
	})

	.done(function(response) {
		$('#tablaPreguntas').html(response.html);
	});
}

// Refresca las tablas respuestas cerradas
function refrescarRespuestasCerradas()
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "GET",
		url: "/admin/mostrarRespuestasCerradas",
		dataType: 'json',
		data: { }
	})

	.done(function(response) {
		$('#tablaRespuestasCerradas').html(response.html).trigger("change");
		$('#tablaRespuestasCerradas2').html(response.html).trigger("change");
	});
}

// Resetea los input y los botones
function limpiar()
{
	$("#preguntaCerrada").prop('disabled', false);
	$("#preguntaCerrada").val("");
	$("#btnPreguntaCerrada").prop('disabled', false);
	$("#respuestaPregunta").prop('disabled', true);
	$("#respuestaPregunta").val("");
	$("#btnRespuestaCerrada").prop('disabled', true);	
}

function limpiar2() {
	$("#preguntaCerrada2").prop('disabled', false);
	$("#btnPreguntaCerrada2").prop('disabled', false);
	$("#respuestaPregunta2").prop('disabled', true);
	$("#btnRespuestaCerrada2").prop('disabled', true);
}

// Limpiar la tabla de respuestas cerradas
function tablaRespuesta()
{
	$('#tablaRespuestasCerradas').html("");
}