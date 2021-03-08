
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="cerrar_sesion derecha">
	
	Bienvenido&nbsp;&nbsp;<b><?php echo $this->session->userdata('nombre_pila'); ?></b>.&nbsp;&nbsp;<a href="<?php echo base_url(); ?>publicar">Anuncios</a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>login/cambio_clave">Cambiar mi clave</a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>login/cerrar_sesion">Cerrar Sesión</a>
</div>

<article id="examenes">
	<div class='opciones_importacion'> 
		<div class='titulo'>Importar datos de SIU-Guaraní</div>
		<div class='opcion_importacion'>
			<label>Carrera</label>
			<select class='carrera_select'>
				<option value="01">Ingeniería Agronómica</option>
				<option value="08">Ingeniería Industrial</option>
			</select>	
		</div>
		<div class='opcion_importacion'>
			<label>Año académico</label>
			<select class='anio_academico_select'>
				
			</select>	
		</div>
		<div class='opcion_importacion'>
			<label>Turno Examen</label>
			<select class='turno_examen_select'>
				
			</select>
		</div>
		<div class='opcion_importacion'>
			<label>Llamado</label>
			<select class='llamado_select'>
				
			</select>
		</div>
		<button class="consultar_fechas_btn">Obtener</button>
	</div>
	<hr>
	<div id="contenedor_filtro_examenes">
		Filtro por fecha: <input type="text" name="filtro" id="filtro_examenes">
	</div>

	<form method="POST" action="<?php echo base_url(); ?>publicar/guardar_turno">
	<?php 
		foreach($examenes as $examen):
			$detalles = $examen->turno->detalles;
			$materias = $examen->turno->mesas;
			//var_dump($detalles); die;
	?>
	<h1 class="center"><?php echo $examen->carrera; ?></h1>
	
	<div class="turno_examenes" data-carrera="<?php echo $examen->codigo_carrera; ?>">
		TURNO DE EXAMENES: 
		<input type="text" name="nombre_turno_<?php echo $examen->codigo_carrera; ?>" class="nombre_turno"  value="<?php echo $detalles->nombre_turno; ?>"> 
		<!-- Mantienen el ID del turno y el llamado ----------->
		<input type="hidden" name="turno_<?php echo $examen->codigo_carrera; ?>" value="<?php echo $detalles->turno; ?>">
		<input type="hidden" name="llamado_<?php echo $examen->codigo_carrera; ?>" value="<?php echo $detalles->llamado; ?>">
		<!-- ----------------------------------------------- -->
		(desde el 
		<input type="text" name="desde_turno_<?php echo $examen->codigo_carrera; ?>" class="desde_turno" value="<?php echo $detalles->desde_turno; ?>"> 
		al 
		<input type="text" name="hasta_turno_<?php echo $examen->codigo_carrera; ?>" class="hasta_turno" value="<?php echo $detalles->hasta_turno; ?>">)
		
		<div id="inicio_insc">
			Inicio de Inscripciones: <input type="text" name="inicio_insc_turno_<?php echo $examen->codigo_carrera; ?>" value="<?php echo $detalles->fecha_inicio_insc; ?>" class="inicio_insc_turno">

		</div>
	</div>
	

	<?php /* ================================ PRIMER AÑO ================================*/ ?>
	
	<?php 
		$anio = 1; 
		$literales = array('1'=>'Primer','2'=>'Segundo','3'=>'Tercer','4'=>'Cuarto','5'=>'Quinto'); 
	?>
	<?php for($i = 1; $i<=5; $i++): ?>
	
	<div class="dia_examenes">
		<?php echo $literales[$i]; ?> Año
	</div>

	<table class="tabla_examenes">
		<th>Materia</th><th>Hora</th><th>Lugar</th><th>Examen</th><th>Cierre Insc</th><th style="font-size: 0.7em;">Modif?</th>
		<?php //var_dump($aulas); die; ?>
		
		<?php foreach ($materias as $materia => $info): ?>
				
			<?php if($i == $info->anio): ?>


				<?php if($info->activo == 1): ?>
					<tr data-materia="<?php echo (isset($info->codigos_materia[1])) ? $info->codigos_materia[1] : $info->codigos_materia[0]; ?>">
						<td>
							<?php echo utf8_encode($info->materia); ?>
						</td>
						
						<td>
							<select name="<?php echo trim($info->nombre_archivo); ?>_horario" 
									class="horario_examen" 
									id="<?php echo trim($info->nombre_archivo)."_horario"; ?>">
								<?php for($hs = 7; $hs < 19; $hs++ ): ?>
									<?php $opcion_punto = ( $hs < 10 )? "0".$hs: $hs; $opcion_punto .= ":00" ?>
									<?php $opcion_media = ( $hs < 10 )? "0".$hs: $hs; $opcion_media .= ":30" ?>
									<option value="<?php echo $opcion_punto; ?>" <?php echo ($opcion_punto == $info->horario)? "selected":""; ?>><?php echo $opcion_punto; ?></option>
									<option value="<?php echo $opcion_media; ?>" <?php echo ($opcion_media == $info->horario)? "selected":""; ?>><?php echo $opcion_media; ?></option>
								<?php endfor; ?>	
							</select>
							
						</td>
						<td>
							<?php // var_dump($aulas); die;  ?>
							<select name="<?php echo trim($info->nombre_archivo); ?>_lugar" class="lugar_examen <?php echo $examen->codigo_carrera; ?>">
							<?php foreach ($aulas as $key => $value): ?>
								<?php //echo $info->lugar."   -   ".$key; die; ?>
								<option value="<?php echo $key; ?>" <?php echo ($info->lugar == $key)? "selected": ""; ?>><?php echo $value['nombre']; ?></option>
							<?php endforeach; ?>

							</select>

						</td>
						<td>
							<input type="text" class="center fecha_examen <?php echo $examen->codigo_carrera; ?>" 
											   name="<?php echo trim($info->nombre_archivo); ?>_fecha_examen" 
											   value="<?php echo $info->fecha_examen; ?>" required>
						</td>
						<td>
							<input type="text" class="center fecha_cierre <?php echo $examen->codigo_carrera; ?>" 
											   name="<?php echo trim($info->nombre_archivo); ?>_fecha_fin_insc" 
											   value="<?php echo $info->fecha_cierre; ?>" required>
						</td>
						<td class="center">
							<input type="checkbox" 
									name="<?php echo trim($info->nombre_archivo); ?>_modificado" 
									class="checkbox <?php echo $examen->codigo_carrera; ?>" <?php echo ($info->modificado)? "checked":""; ?> >
						</td>
					</tr>
				<?php endif; ?>
			<?php 
				else: 
					continue;
				endif;
			?>
		<?php endforeach; ?>
	</table>
	<?php endfor; ?>
	<?php endforeach; ?>

	<br>
	
	<input type="submit" value="Guardar cambios!" class="boton_ok">
	

	</form>

</article>

<script src="<?php echo base_url(); ?>assets/js/examenes.js"></script>


