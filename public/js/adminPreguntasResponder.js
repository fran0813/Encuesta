$( document ).ready(function()
{
	verficiar();
});

// Refresca la tabla de las encuestas
function refrescar()
{
	$.ajax({
		method: "GET",
		url: "/admin/mostrarPreguntasResponder",
		dataType: 'json',
	})

	.done(function(response) {
		$('#preguntasRespondonder').html(response.html);
	});
}

// Refresca la tabla de las encuestas
function verficiar()
{
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/verificar1",
		dataType: 'json',
		data: { }
	})

	.done(function(response) {
		if (response.html == false) {
			refrescar();
		} else {
			location.href = '/admin/responder';
		}
		
	});
}

