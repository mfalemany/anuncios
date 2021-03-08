
document.addEventListener('DOMContentLoaded',cargaInicial);

async function cargaInicial(){
	/* Obtengo las configuraciones */
	config = await getConfig();
	
	/* Obtengo los SELECT que contienen las opciones para importar datos de Guaraní */
	$selectAnios = document.querySelector('.anio_academico_select');
	$selectTurnos = document.querySelector('.turno_examen_select');
	$selectLlamados = document.querySelector('.llamado_select');
	$consultar_fechas_btn = document.querySelector('.consultar_fechas_btn');

	//Asigno listeners a los select
	$selectAnios.addEventListener('change',recargarTurnos);
	$selectTurnos.addEventListener('change',recargarLlamados);
	$consultar_fechas_btn.addEventListener('click',obtenerMesasGuarani);
	
	//Hago la carga inicial
	recargarAnios();
}

async function getConfig(){
	return fetch('../assets/fake_bd/config.json').then( respuesta => respuesta.json()).then( json => json);
}

function recargarAnios(){
	$consultar_fechas_btn.disabled = true;
	/* ===================== Poblando el select de años ==================================*/
	url = `${config.url_guarani}/get_anios_academicos/2`;
	anios = completarSelect($selectAnios, url, 'anio_academico', 'anio_academico');
	anios.then(recargarTurnos).catch( e => alert(e));
}

function recargarTurnos(){
	$consultar_fechas_btn.disabled = true;
	$selectTurnos.innerHTML = '';
	/* ===================== Poblando el select de turnos ==================================*/
	url =  `${config.url_guarani}/get_turnos_anio/${$selectAnios.value}`;
	turnos = completarSelect($selectTurnos, url, 'turno_examen', 'nombre_detalle');
	turnos.then(recargarLlamados);
}

function recargarLlamados(){
	$consultar_fechas_btn.disabled = true;
	$selectLlamados.innerHTML = '';
	/* ===================== Poblando el select de turnos ==================================*/
	params = encodeURI(`${$selectAnios.value}||${$selectTurnos.value}`);
	url =  `${config.url_guarani}/get_llamados_turno/${params}`;
	completarSelect($selectLlamados, url, 'llamado', 'llamado')
	.then( () => $consultar_fechas_btn.disabled = false);

}
	
async function completarSelect(select,url_datos, campo_valor, campo_descripcion){
	return new Promise(async function(aceptar, rechazar){

		resp = await fetch(url_datos);
		
		if(resp.status != 200){
			rechazar('No está disponible la conexión con SIU-Guaraní');
			return;
		}
		
		json = await resp.json();
		
		json.forEach( elemento => {
			let opcion = document.createElement('option');
			opcion.value = elemento[campo_valor];
			opcion.innerText = elemento[campo_descripcion];
			select.appendChild(opcion);
		});
		aceptar();
	});
}

async function obtenerMesasGuarani(){
	if( ! confirm('Obtener datos del SIU-Guaraní y reemplazar los datos del turno seleccionado? (Los cambios no tendrán efecto si no hace click en \'Guardar\')')){
		return;
	}
	params = encodeURI(`${$selectAnios.value}||${$selectTurnos.value}||${$selectLlamados.value}`);
	url =  `${config.url_guarani}/get_mesas/${params}`;
	//console.log('Consultando',url);
	resp = await fetch(url);
	json = await resp.json();
	reemplazarDatosMesas(json);
}

function reemplazarDatosMesas(datos){
	/* Reemplazando datos del llamado */
	const carrera = document.querySelector('.carrera_select').value;
	const contenedorLlamado = document.querySelector(`.turno_examenes[data-carrera="${carrera}"]`);
	//Claves del Turno y llamado (campos ocultos)
	contenedorLlamado.querySelector(`input[name=turno_${carrera}]`).value = datos.llamado.turno_examen;
	contenedorLlamado.querySelector(`input[name=llamado_${carrera}]`).value = datos.llamado.llamado;


	//Nombre del turno
	contenedorLlamado.querySelector('.nombre_turno').value = datos.llamado.nombre_turno;
	contenedorLlamado.querySelector('.nombre_turno').style.backgroundColor = config.color_datos_cargados;
	//Si es un segundo llamado, se agrega al nombre de turno.
	if(datos.llamado.llamado == 2) contenedorLlamado.querySelector('.nombre_turno').value += ' - Segundo Llamado';
	//fechas de Inicio de llamado, fin de llamado e inicio de inscripciones.
	contenedorLlamado.querySelector('.desde_turno').value = ymdToDmy(datos.llamado.fecha_inicio_llamado).substring(0,5);
	contenedorLlamado.querySelector('.desde_turno').style.backgroundColor = config.color_datos_cargados;

	contenedorLlamado.querySelector('.hasta_turno').value = ymdToDmy(datos.llamado.fecha_fin_llamado).substring(0,5);
	contenedorLlamado.querySelector('.hasta_turno').style.backgroundColor = config.color_datos_cargados;
	//El formato y las opciones para new Date están acá: https://medium.com/swlh/use-tolocaledatestring-to-format-javascript-dates-2959108ea020
	contenedorLlamado.querySelector('.inicio_insc_turno').value = new Date(json.llamado.fecha_inicio_inscripcion).toLocaleDateString('es-AR',{weekday:'long',day:'2-digit',month:'long'});
	contenedorLlamado.querySelector('.inicio_insc_turno').style.backgroundColor = config.color_datos_cargados;
	
	
	//Datos de cada mesa
	datos.mesas.forEach( (mesa) => {
		const $fila = document.querySelector(`[data-materia="${mesa.materia}"]`);
		if( ! $fila){
			return;
		}
		const nombreMateria = $fila.querySelector('td:nth-child(1)').innerText;
		
		/* HORARIO DEL EXAMEN */
		if(mesa.hora_examen && mesa.hora_examen != '00:00:00'){
			let hora = mesa.hora_examen.substring(0,5);
			try{
				$fila.querySelector('.horario_examen').querySelector(`option[value="${hora}"]`).selected = true;
				$fila.querySelector('.horario_examen').style.backgroundColor = config.color_datos_cargados;
				//console.log(`${nombreMateria}: Se asignó el horario ${hora}`);
			}catch(e){
				console.log(`${nombreMateria}: El horario declarado no está entre las opciones: (${hora})`);
			}
		}else{
			console.log(`${nombreMateria}: La materia no tiene horario asignado. Se omite.`);
		}

		/* FECHA DEL EXAMEN */
		let fecha = mesa.fecha_examen.split('-').reverse().join('/').substring(0,5);
		$fila.querySelector('.fecha_examen').value = fecha;
		$fila.querySelector('.fecha_examen').style.backgroundColor = config.color_datos_cargados;

		/* FIN INSCRIPCIONES */
		fecha = ymdToDmy(mesa.fin_inscripciones).substring(0,5);
		$fila.querySelector('.fecha_cierre').value = fecha;
		$fila.querySelector('.fecha_cierre').style.backgroundColor = config.color_datos_cargados;
	});
}

function ymdToDmy(fecha){
	return fecha.substring(0,10).split('-').reverse().join('/');
}