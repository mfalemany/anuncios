/* controla la cantidad de archivos
   con resultados de encuestas de docentes y cátedra */
var cant_arch_doc = 1;

window.onload = function(){
	
	//comportamiento al procesar el formulario
	document.getElementById('btn_procesar').onclick = function(e){
		//valido los archivos seleccionados del docente
		if( ! validarDatosDocente() ){
			e.preventDefault();
			return;
		}
	}
}

function validarDatosDocente(){
	//variable que controla si se ha seleccionado AL MENOS un archivo
	var algun_archivo_doc = false;
	
	//Se recorren todos los posibles archivos seleccionados
	for(var i = 1; i <= cant_arch_doc; i++){
		//si el input contiene algun archivo...
		if($("#file_doc_"+i)[0].files.length > 0){
			//verifico que sea del tipo corecto (en este caso *.txt)
			if($("#file_doc_"+i)[0].files[0].type != "text/plain"){
				//si no lo es, muestro un error para ese input
				mostrarError('El archivo docente número '+i+' no está permitido. Por favor, seleccione el archivo de texto (con extensi&oacute;n .txt) generado con SIU-Kolla');
				return false;	
			}else{
				//en caso contrario, ya tenemos al menos un archivo seleccionado y válido
				algun_archivo_doc = true;
			}
		}	
	}
	//si no hemos encontrado ningun archivo cargado
	if( ! algun_archivo_doc){
		mostrarError('No se ha seleccionado un archivo de resultados docente para procesar');
		return false;
	}else{
		return true;
	}
}

function mostrarError(mensaje){
	document.getElementById('contenedor_error').style.display = 'block';
	document.getElementById('contenedor_error').innerHTML = mensaje;
	setTimeout(function(){
		document.getElementById('contenedor_error').style.display = 'none';
	},3000)
}