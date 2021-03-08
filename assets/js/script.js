import {burgerizar} from './modulos/boton_burger.js';
import {scrollUpButton} from './modulos/boton_scrollUp.js';

//Shorcut
const d = document;
var anuncios, $filtro;


document.addEventListener('DOMContentLoaded',function(){
	anuncios = d.querySelectorAll('.anuncio');
	//Verifica si hay nuevas publicaciones, y si las encuentra, actualiza la ventana
	if(anuncios.length){
		comprobarNovedades((1000 * 60 * 5));
		
	}
	$filtro = d.getElementById('txt_filtro_criterio');

	if(d.getElementById('boton_burger_container')){
		//Crea el botón hamburguesa
		burgerizar('boton_burger_container','menu_mobile');
	}

	// Botón de Scroll UP
	scrollUpButton(200);
	
	if($filtro){
		$filtro.focus();
		$filtro.addEventListener('keyup',filtrarAnunciosPorContenido);
	}

	//Fijo el foco en el cuadro de texto para loguearse
	const $login = d.getElementById('usuario_login');
	if($login){
		$login.focus();	
	}
	
	const $carrera = d.querySelector('#carrera');
	if($carrera){
		$carrera.addEventListener('change',filtrarAnunciosPorCarrera);
	}

	//Botones que permiten eliminar anuncios
	const botonesEliminar = d.querySelectorAll('.eliminar');
	if(botonesEliminar.length){
		botonesEliminar.addEventListener('click',function(e){
			if(!confirm("Eliminar anuncio definitivamente?")){
				e.preventDefault();
			}
		});
	}

	//Boton cerrar
	const botonesCerrar = d.querySelectorAll('.boton_cerrar');
	botonesCerrar.forEach( boton => {
		boton.addEventListener('click',accionBotonCerrar)
	});
});

function accionBotonCerrar(e){
	e.target.parentElement.classList.add('hidden');
}

async function getConfig(){
	return fetch('assets/fake_bd/config.json').then( respuesta => respuesta.json()).then( json => json);
}

function comprobarNovedades(lapso){

	//Cada 5 minutos se chequea nuevos anuncios
	setInterval(async function(){
		const config = await getConfig();
		const cant_locales = document.querySelectorAll('.anuncio').length;
		const cant_server = await fetch(`${config.url_guarani}'/cantidad_anuncios`)
								.then( resultado => resultado.text()).then(cantidad => cantidad);
		if(cant_locales != parseInt(cant_server) ){
			location.reload();
		}
	},lapso);
}

//Función obtenida en https://es.stackoverflow.com/questions/62031/eliminar-signos-diacr%C3%ADticos-en-javascript-eliminar-tildes-acentos-ortogr%C3%A1ficos
function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
}

/* Si el filtro es "todas" se muestran todos los anuncios. 
   Si el filtro es una carrera, se muestran los anuncios para esa carrera y los anuncios para "todas" */
function filtrarAnunciosPorCarrera(){
	$filtro.value = null;
	const seleccionado = event.target.value;

	anuncios.forEach(function(anuncio){
		anuncio.style.display = (seleccionado == 'todas') ? 
			'block' : 
			anuncio.classList.contains(seleccionado) || anuncio.classList.contains('todas') ? 'block' : 'none';
	});
}

function filtrarAnunciosPorContenido(){
	const busqueda = eliminarDiacriticos($filtro.value.toLowerCase());
	let textoAnuncio;
	anuncios.forEach(function(anuncio){
		textoAnuncio = eliminarDiacriticos(anuncio.textContent.toLowerCase());
		anuncio.style.display = textoAnuncio.indexOf(busqueda) >= 0 || $filtro.value.length == 0 ? 'block' : 'none' ;
	});
}

// ================ DESDE ACÁ PARA ABAJO HAY QUE REFACTORIZAR EL CÓDIGO PARA SACAR jQuery ========== 

$(document).ready(function(){
	$("#submitCambioClave").on("click",function(e){
		e.preventDefault()
		var error = "";
		
		if($("#actual").prop("value").trim().length == 0){
			error = error + "Clave actual: El campo está vacío.\n";
		}
		if($("#nueva").prop("value").trim().length == 0){
			error = error + "Clave Nueva: El campo está vacío.\n";
		}
		if($("#rep_nueva").prop("value").trim().length == 0){
			error = error + "Repetir clave nueva: El campo está vacío.\n";
		}
		if($("#nueva").prop("value") != $("#rep_nueva").prop("value")){
			error = error + "Las claves ingresadas no coinciden\n";
		}
		if(error.length > 0){
			alert("Se produjeron los siguientes errores:\n\n"+error);
		}else{
			$("#form_cambio_clave").submit();
		}
	})

	/* Generación de un nuevo turno de examenes */
	$("#filtro_examenes").on("keyup",function(){
		$(".fecha_examen").each(function(){
			if( $(this).prop("value").trim().indexOf( $("#filtro_examenes").prop("value").trim() ) == 0){
				let td = $(this).parent()[0];
				let tr = $(td).parent()[0];
				//console.log(tr);
				$(tr).css("display","table-row");
			}else{
				let td = $(this).parent()[0];
				let tr = $(td).parent()[0];
				$(tr).css("display","none");
			}
		})
		
	});
	$("#filtro_examenes").focus();

})
