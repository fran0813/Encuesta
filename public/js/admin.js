$( document ).ready(function()
{
	refrescar();
});

// Funciones de la tabla de las encuestas (Editar/Eliminar)
$("#tablaEncuestas").on("click", "a", function()
{
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
			$('#titulo2').val(response.titulo);
			$('#descripcion').val(response.descripcion);
		});
	}else if(clase == "btn btn-danger"){
		$.ajax({
			method: "GET",
			url: "/admin/eliminarEncuesta",
			dataType: 'json',
			data: { id: id }
		})

		.done(function(response) {
			refrescar();
		});
	}
});	

// Editar encuestas
$("#formEditarEncuesta").on("submit", function()
{
	var titulo = $("#titulo2").val();
	var descripcion = $("#descripcion").val();
	
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "GET",
		url: "/admin/editarEncuesta",
		dataType: 'json',
		data: { titulo: titulo,
				descripcion: descripcion}
	})

	.done(function(response){
		$('#respuesta2').html(response.html);	
		refrescar();
	});

	return false;
});

// Establece el id de la encuesta cuando se editar o elimina
function idEncuesta(id)
{
	var tipo = "editar";

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

// Refresca la tabla de las encuestas
function refrescar()
{
	$.ajax({
		method: "GET",
		url: "/admin/mostrarEncuestas",
		dataType: 'json',
	})

	.done(function(response) {
		$('#tablaEncuestas').html(response.html).trigger("change");
	});
}

// Redirige a las preguntas
function redirigirPreguntas()
{
	document.location ="/admin/preguntas";
}