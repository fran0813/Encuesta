$( document ).ready(function()
{
	refrescar();
});

// Funciones de la tabla de las encuestas (Editar/Eliminar)
$("#tablaTabulacion").on("click", "a", function()
{
	var value = $(this).attr("value");
	var id = $(this).attr("id");
	idEncuesta(id);

	if(value == "tabulacion"){
		redirigirTabulacion();
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
		url: "/admin/mostrarTabulaciones",
		dataType: 'json',
	})

	.done(function(response) {
		$('#tablaTabulacion').html(response.html);
	});
}

// Redirige a las responder la encuesta
function redirigirTabulacion()
{
	document.location ="/admin/graficas";
}
