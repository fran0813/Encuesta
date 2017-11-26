$( document ).ready(function() {
	limpiar();
	var tipo = "editar";
	refrescarPreguntas();
	refrescarRespuestasCerradas(tipo);
});

// Crear la pregunta abierta
$("#formCrearPreguntaAbierta").on("submit", function(){

	var preguntaAbierta = $("#preguntaAbierta").val();

	if(preguntaAbierta == ""){
		$('#respuesta1').html("Por favor ingrese la pregunta");
	}else{

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearPreguntaAbierta",
			dataType: 'json',
			data: { preguntaAbierta: preguntaAbierta }
		})

		.done(function(response) {
			$('#respuesta1').html(response.html);
			refrescarPreguntas();
		});

	}

	return false;
});

// Crear la pregunta cerrada
$("#formCrearPreguntaCerrada").on("submit", function(){

	var preguntaCerrada = $("#preguntaCerrada").val();

	if(preguntaCerrada == ""){
		$('#respuestaCerradas').html("Por favor ingrese la pregunta");
	}else{

		var tipo = "editar";

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearPreguntaCerrada",
			dataType: 'json',
			data: { preguntaCerrada: preguntaCerrada }
		})

		.done(function(response) {
			$('#respuestaCerradas').html(response.html);

			if(response.verificar == true){
				$("#preguntaCerrada").prop('disabled', true);
				$("#btnPreguntaCerrada").prop('disabled', true);
				$("#respuestaPregunta").prop('disabled', false);
				$("#btnRespuestaCerrada").prop('disabled', false);
				idPreguntaCerrada();
				refrescarRespuestasCerradas(tipo);
			}
		});

	}

	return false;
});

function idPreguntaCerrada() {
	var tipo = "crear";

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idCerrada",
		dataType: 'json',
		data: { id: tipo}
	})

	.done(function(response){
		
	});
}

// Crear respuesta cerrada
$("#formCrearRespuestaCerrada").on("submit", function(){

	var tipo = "crear";

	var respuestaPregunta = $("#respuestaPregunta").val();

	if(respuestaPregunta == ""){
		$('#respuesta2').html("Por favor ingrese la respuesta");
	}else{

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearRespuestaCerrada",
			dataType: 'json',
			data: { respuestaPregunta: respuestaPregunta }
		})

		.done(function(response) {
			refrescarRespuestasCerradas(tipo);
			
		});
		
	}

	return false;
});

function refrescarPreguntas() {
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


function refrescarRespuestasCerradas(tipo) {
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "GET",
		url: "/admin/mostrarRespuestasCerradas",
		dataType: 'json',
		data: { tipo: tipo}
	})

	.done(function(response) {
		
		$('#tablaRespuestasCerradas').html(response.html).trigger("change");
		$('#tablaRespuestasCerradas2').html(response.html).trigger("change");
	});
}

function limpiar() {
	$("#preguntaCerrada").prop('disabled', false);
	$("#preguntaCerrada").val("");
	$("#btnPreguntaCerrada").prop('disabled', false);
	$("#respuestaPregunta").prop('disabled', true);
	$("#respuestaPregunta").val("");
	$("#btnRespuestaCerrada").prop('disabled', true);
}

$("#tablaPreguntas").on("click", "a", function(){

	var clase = $(this).attr("class");

	var id = $(this).attr("id");

	if(clase == "btn btn-success"){

		var tipo = "editar";

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
				idPreguntaCerradaEditar(response.idCerrada);
				refrescarRespuestasCerradas(tipo);
				idCerrada(id);
				limpiar();
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

function idPreguntaCerradaEditar(id) {
	var tipo = "editar";

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idPreguntaCerrada",
		dataType: 'json',
		data: { tipo: tipo,
				idPreguntaCerrada: id}
	})

	.done(function(response){
		
	});
}

$("#tablaRespuestasCerradas2").on("click", "a", function(){

	var clase = $(this).attr("class");

	var id = $(this).attr("id");

	idPreguntaCerradaEditar(id);

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
			
		});
	}else if(clase == "btn btn-danger"){

		$.ajax({
			method: "GET",
			url: "/admin/eliminarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			refrescarRespuestasCerradas(tipo);
		});
	}

});

$("#tablaRespuestasCerradas").on("click", "a", function(){

	var clase = $(this).attr("class");

	var id = $(this).attr("id");

	idPreguntaCerradaEditar(id);

	if(clase == "btn btn-success"){

		var tipo = "editar";

		$.ajax({
			method: "GET",
			url: "/admin/mostrarActualizarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			console.info(response.id)	
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
			
		});
	}else if(clase == "btn btn-danger"){

		$.ajax({
			method: "GET",
			url: "/admin/eliminarRespuestaCerrada",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			refrescarRespuestasCerradas(tipo);
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

		var tipo = "editar";

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/editarRespuestaCerrada",
			dataType: 'json',
			data: { respuestaCerrada: respuestaCerrada2 }
		})

		.done(function(response) {
			console.info(response.id)
			$('#respuestaEditarRespuestaCerrada').html(response.html);
			refrescarRespuestasCerradas(tipo);
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

function tablaRespuesta() {
	$('#tablaRespuestasCerradas').html("");
}