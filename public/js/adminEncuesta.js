$( document ).ready(function() {

});

// Crear la encuestas
$("#formCrearEncuesta").on("submit", function(){

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
		});

	}

	return false;

});

function idEncuesta() {
	
	var tipo = "crear";

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/idEncuesta",
		dataType: 'json',
		data: { tipo: tipo}
	})

	.done(function(response){
		console.info(response.msg);
	});

	setTimeout(function(){ 
		document.location ="/admin/preguntas";
	}, 2000);
}

