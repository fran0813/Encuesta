$( document ).ready(function()
{
	refrescar();
});

// Refresca la tabla de las encuestas
function refrescar()
{
	var tipo = "ComboChart";
	$.ajax({
		method: "GET",
		url: "/admin/mostrarGraficas",
		dataType: 'json',
	})

	.done(function(response) {
		$('#tablaGraficas').html(response.html);
		$('#totalPreguntas').val(response.cont);
		for (var i = 1; i <= response.cont; i++) {
			grafica(i,tipo);
		}	
	});
}

function grafica(i,tipo)
{	
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "GET",
		url: "/admin/mostrarG",
		dataType: 'json',
		data: { i: i,
				tipo: tipo}
	})

	.done(function(response){
		$('#div'+response.idG).html(response.html);
	});
}

// $(function()
// {
// 	$(document).on('click', 'button', function(event)
// 	{	
	 	
// 	    mostrarGraficas(idPregunta,idRegion,idTown,tipo);	
// 	});
// });