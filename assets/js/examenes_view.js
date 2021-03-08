document.addEventListener('DOMContentLoaded',inicio);
const d = document;


function inicio(){
	modal = document.getElementById("modal");

	document.querySelector(".close").addEventListener('click', e => {
		modal.style.display = 'none';
	});
	window.addEventListener('click', e => {
		if (e.target == modal) {
			modal.style.display = "none";
		}
	})
	
	d.querySelectorAll('.ver_inscriptos').forEach( enlace => {
		enlace.addEventListener('click',mostrarInscriptos)
		enlace.addEventListener('click', e => {
			
		});
	});

}

async function getConfig(){
	return fetch('assets/fake_bd/config.json').then( respuesta => respuesta.json()).then( json => json);
}

async function mostrarInscriptos(e){
	e.preventDefault();

	/* Obtengo las configuraciones */
	config = await getConfig();
	// Obtengo los parámetros
	anio = new Date().getFullYear();
	turno = e.target.dataset.turno_examen;
	llamado = e.target.dataset.llamado;
	materias = e.target.dataset.materias;
	//Armo un string que se pasa a la URL como un único parámetro
	const params = encodeURI(`${anio}||${turno}||${llamado}||${materias}`);
	//Hago la consulta
	const url = `${config.url_guarani}/get_inscriptos_mesa/${params}`;
	console.log('Consultando: ',url);
	const resp = await fetch(url);
	let inscriptos = await resp.json();
 	console.log(inscriptos);
	if(inscriptos.length == 0){
		alert('No se registraron inscripciones');
	}else{
		inscriptos = inscriptos.map(inscripto => {
			inscripto.tipo_inscripcion = (inscripto.tipo_inscripcion == 'R') ? 'Regular' : 'Libre';
			return inscripto;
		});
		inscriptos = inscriptos.map(inscripto => {
			inscripto.estado = (inscripto.estado == 'A') ? 'Activo' : 'Pendiente';
			return inscripto;
		});


		//$contenedor_tabla = d.getElementById('lista_inscriptos');
		fragmento = d.createDocumentFragment();
		inscriptos.forEach( alumno => {
			const fila = d.createElement('tr');
			//Esta clase es la que me permite eliminar los datos entre un pedido y otro 
			fila.classList.add('dato');
			//(limpiar la tabla de datos, para cargar nuevos) sin eliminar las cabeceras
			for(let dato in alumno){
				let columna = d.createElement('td');
				columna.innerText = alumno[dato];
				fila.appendChild(columna);
			}
			fragmento.appendChild(fila);
		})

		modal = document.getElementById("modal");
		filas_info = modal.querySelectorAll('.modal-info table tbody tr.dato');
		if(filas_info){
			filas_info.forEach( fila => fila.parentElement.removeChild(fila)); 
		}
		modal.querySelector('.modal-info table tbody').appendChild(fragmento);
		modal.querySelector('.modal-footer').innerHTML = `Total Inscriptos: ${inscriptos.length}`;
		modal.style.display = 'block';
		
	}
	
}