document.addEventListener('DOMContentLoaded',function(){
	ckeditificar();
	
	$("#submit_publicar").on("click",function(e){
		if( ! confirm("Publicar para "+$("#carrera :selected").text()+"?")){
			e.preventDefault();
		}
		campos = "";

		
		if( $("#titulo").prop("value").length == 0){
			campos = campos+"- Titulo\n";
		}
		console.log(CKEDITOR.instances.editor1.getData().length)
		if( CKEDITOR.instances.editor1.getData().length == 0){
			campos = campos + "- Contenido\n";
		}
		
		if(campos.length > 0){
			e.preventDefault();
			alert("Ocurrió un error en los siguientes campos:\n"+campos);
		}
	});

	$("#subir_archivo").on("click",function(){
		$("#carga_archivos").css({"display":"block","z-index":1000,"width":"100%"});
		
		$("#texto_enlace").focus();
		$("#texto_enlace").select();
		
	})

	$("#cancelar").on("click",function(){
		$("#carga_archivos").css({"display":"none"});
	})

	$("#subir").on("click",function(){
		
		//si se selecciono algun archivo...
		if( $("#userfile").prop("files")[0] ){
			//se definen los formatos permitidos
			var validos = ['application/pdf','image/jpeg','image/gif','image/png','image/bmp'];
			//y si tiene alguno de los formatos permitidos
			if( validos.indexOf(  $("#userfile").prop("files")[0].type.toLowerCase()  ) >= 0 ){
								
				var formData = new FormData();
			    formData.append("userfile", $("#userfile").prop("files")[0] );

				$.ajax({
					url:'/anuncios/publicar/subir_archivo', //metodo que controla la subida
					type:'POST', //Metodo que usaremos
					contentType:false, //Debe estar en false para que pase el objeto sin procesar
					data:formData, //Le pasamos el objeto que creamos con los archivos
					processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
					cache:false, //Para que el formulario no guarde cache
					error: function(e){console.log(e)},
					success: function(){alert("Archivo subido con exito!")}
				}).done(function(msg){
					//console.log(msg);
					respuesta = JSON.parse(msg);
					console.log(respuesta);
					//generamos el link y lo agregamos al editor
					CKEDITOR.instances.editor1.insertHtml('<a target="_BLANK" data-cke-saved-href="/anuncios/assets/pdfs/temp/'+respuesta.resultado.file_name+'" href="/anuncios/assets/pdfs/temp/'+respuesta.resultado.file_name+'">'+$("#texto_enlace").prop("value")+'</a>','unfiltered_html');
					CKEDITOR.instances.editor1.updateElement();

					//se resetea el campo "Texto del enlace"
					$("#texto_enlace").prop("value","Enlace..");
					//se borra el archivo anterior (si es que se llama dos veces esta funcion)
					$("#userfile").replaceWith( userfile = $("#userfile").clone( true ) );
					//se oculta la pantalla de carga de archivo
					$("#carga_archivos").css({"display":"none"});

				});
			}else{
				alert("El archivo seleccionado no es admitido.");
			}
		}else{
			alert("No se ha seleccionado un archivo para subir");
		}
	})
});

function ckeditificar(){
	if($("#editor1")){
		CKEDITOR.replace('editor1');	
	}
}

function editar_anuncio(id){
	//Obtengo la instancia del editor
	editor = CKEDITOR.instances.editor1;
	//Obtengo el anuncio seleccionado
	$anuncio = document.getElementById(id);
	//asigno el contenido del anuncio al cuerpo del editor	
	editor.setData($anuncio.querySelector('.anuncio_contenido').innerHTML);
	//asigno el título del anuncio al campo "Titulo"
	document.getElementById('titulo').value = $anuncio.querySelector('.anuncio_titulo').textContent;
	//Obtengo la carrera del anuncio que se está editando...
	carrera = $anuncio.classList.contains('todas') ? 'todas' :
		$anuncio.classList.contains('agronomia') ? 'agronomia' : 'industrial';
	//y la asigno al select "Carrera"
	document.getElementById('carrera').querySelector(`option[value='${carrera}']`).selected = true;
	//Obtengo el boton de submit y pongo el modo "edicion" (el modo normal es "nuevo")
	document.getElementById('id_anuncio').value = id;
	//Llevo al usuario a la parte superior de la pantalla, donde está el editor
	window.scrollTo({top:0,behavior:'smooth'});
}


function eliminar_anuncio(id){
	if( ! confirm("Eliminar anuncio?")){
		return false;
	}
	$.ajax({
		method: "POST",
		url: './publicar/eliminar',
		data: {id_anuncio: id},
		//success: function(estado){console.log("Todo OK"+estado)},
		error: function(error){console.log("Hubo un error"+error)},
		dataType: 'json',
		complete: function(a){
			$("#"+id).slideUp();
		}
	});
}