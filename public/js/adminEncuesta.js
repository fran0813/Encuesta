$( document ).ready(function()
{

});

// Crea la encuesta
$("#formCrearEncuesta").on("submit", function()
{
	var titulo = $("#titulo").val();
	var descripcion = $("#descripcion").val();

	if(titulo == "" || descripcion == ""){
		$('#respuesta').html("Por favor ingrese todos los datos");
	}else{
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "GET",
			url: "/admin/crearEncuestas",
			dataType: 'json',
			data: { titulo: titulo,
					descripcion: descripcion}
		})

		.done(function(response){
			$('#respuesta').html(response.html);	
			idEncuesta();
			redirigirPreguntas();
		});
	}
	return false;
});

// Establece el id de la encuesta
function idEncuesta()
{	
	var tipo = "crear";

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idEncuesta",
		dataType: 'json',
		data: { tipo: tipo}
	})

	.done(function(response){
		
	});	
}

// Redirige a las preguntas
function redirigirPreguntas()
{
	setTimeout(function(){ 
		document.location ="/admin/preguntas";
	}, 1500);
}