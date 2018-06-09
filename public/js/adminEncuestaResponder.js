$( document ).ready(function()
{
	refrescar();
});

// Funciones de la tabla responder encuestas
$("#tablaEncuestasResponder").on("click", "a", function()
{
	var value = $(this).attr("value");
	var id = $(this).attr("id");
	idEncuesta(id);

	if(value == "responder"){
		redirigirResponder();
	}
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
		url: "/admin/mostrarEncuestasResponder",
		dataType: 'json',
	})

	.done(function(response) {
		$('#tablaEncuestasResponder').html(response.html).trigger("change");
	});
}

// Redirige a las responder la encuesta
function redirigirResponder()
{
	document.location ="/admin/responderEncuesta";
}