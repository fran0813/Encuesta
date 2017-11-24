$( document ).ready(function() {

	refrescar()

});

// Funcion para establecer el id de la encuesta cuando se edita o elimina
function idEncuesta(id) {

	// var idEncuesta = $("#idEncuesta").val();

	var tipo = "crear";

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idEncuesta",
		dataType: 'json',
		data: { tipo: tipo,
				idEncuesta: id}
	})

	.done(function(response){
		console.info(response.msg);
	});

}

$("#tablaEncuestas").on("click", "a", function(){

	var clase = $(this).attr("class");

	var id = $(this).attr("id");

	idEncuesta(id);

	if(clase == "btn btn-success"){

		$.ajax({
			method: "GET",
			url: "/admin/mostrarActualizarEncuesta",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			$('#descripcion').val(response.descripcion);
			$('#titulo').val(response.titulo);
		});

	}else if(clase == "btn btn-danger"){

		$.ajax({
			method: "GET",
			url: "/admin/eliminarEncuesta",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			console.info(response.msg);
			refrescar();
		});
	}

});	

// Editar encuestas
$("#formEditarEncuesta").on("submit", function(){

	var titulo = $("#titulo").val();
	var descripcion = $("#descripcion").val();

	if(titulo == "" || descripcion == ""){
		$('#respuesta').html("Por favor ingrese todos los datos");
	}else{

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/editarEncuesta",
			dataType: 'json',
			data: { titulo: titulo,
					descripcion: descripcion}
		})

		.done(function(response){
			$('#respuesta').html(response.html);	
			refrescar();
		});

	}

	return false;

});

function refrescar() {
	$.ajax({
		method: "GET",
		url: "/admin/mostrarEncuestas",
		dataType: 'json',
	})

	.done(function(response) {
		// console.info(response)
		$('#tablaEncuestas').html(response.html).trigger("change");
	});
}

function redirigirPreguntas() {
	document.location ="/admin/preguntas";
}