<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php foreach($examenes as $examen): ?>
<div id="turnos">
	<div id="agronomia">
		<div class="cabecera_acordeon" onclick="$(this).next().slideToggle(300)">
			<?php echo $examen->carrera; ?>
		</div>
		<div class='turno'>
			<article id="examenes">
				<div class="turno_examenes">
					<?php //var_dump($examen); die; ?>
					TURNO DE EXAMENES: <?php echo $examen->turno->detalles->nombre_turno; ?> 
					(desde el <?php echo $examen->turno->detalles->desde_turno; ?> al <?php echo $examen->turno->detalles->hasta_turno; ?>)
				</div>
				<div class="inicio_insc">
					Inicio de Inscripciones: <?php echo $examen->turno->detalles->fecha_inicio_insc; ?>
				</div>

				<?php /* ================================ DIA EXAMENES ================================*/ ?>
				<?php /* ================================ PRIMER AÑO ================================*/ ?>
				<?php $anios = array("1"=>"Primer Año","2"=>"Segundo Año","3"=>"Tercer Año","4"=>"Cuarto Año","5"=>"Quinto Año"); ?>
				<?php for($i = 1; $i<=5; $i++): ?>
				<div class="dia_examenes">
					<?php echo $anios[$i]; ?>
				</div>
				
				<table class="tabla_examenes">
					<th>Materia</th><th>Hora</th><th>Lugar</th><th>Examen</th><th>Cierre Insc</th><th>Inscriptos</th>
					<?php //var_dump($examen->mesas); die; ?>
					<?php foreach ($examen->turno->mesas as $materia => $info): ?>
						
						
						<?php if($i == $info->anio): ?>


							<?php if($info->activo == 1): ?>
								<tr>
									<td>
										<?php echo utf8_encode($info->materia); ?>
										<?php if($info->modificado): ?>
											<span class="rojo">(Nueva fecha)</span>
										<?php endif; ?> 
										
									</td>
									
									<td>
										<?php echo $info->horario; ?>
									<td>
										<?php echo $aulas[$info->lugar]['nombre']; ?>
									</td>
									<td>
										<?php echo $info->fecha_examen; ?>
									</td>
									<td>
										<?php echo $info->fecha_cierre; ?> (19:00 hs)
									</td>

									<td>
									<?php 

										$fecha_cierre = explode('/',$info->fecha_cierre);
										if(count($fecha_cierre) == 2){
											//Se formatea la fecha de cierre a YYYY-MM-DD
											$fecha_cierre = date('Y-'.$fecha_cierre[1].'-'.$fecha_cierre[0]);
											$fecha_examen = explode('/',$info->fecha_examen);

											if(count($fecha_examen) == 2): 
												$fecha_examen = date('Y-'.$fecha_examen[1].'-'.$fecha_examen[0]);
												$hoy = date('Y-m-d');
												//Si la fecha de cierre ya pasó, y el exámen no ocurrió, se muestra la lista
												if($hoy > $fecha_cierre && $hoy <= $fecha_examen): ?>
													<a href="#" class="ver_inscriptos" 
														data-materias="<?php echo implode(',',$info->codigos_materia); ?>"
														data-carrera="<?php echo $examen->codigo_carrera; ?>"
														data-turno_examen="<?php echo $examen->turno->detalles->turno; ?>" 
														data-llamado="<?php echo $examen->turno->detalles->llamado; ?>" 
														>Ver</a>
												<?php endif;
											endif;
										}
										// Genera el siguiente enlace:
										// http://www.agr.unne.edu.ar/anuncios/rest/wrapper/get_inscriptos_mesa/2020%7C%7CTERCER%20TURNO%7C%7C2%7C%7C50,51.
										

									?>
									</td>
									<!-- <td>
										<?php if(file_exists("./assets/pdfs/examenes/".trim($info->nombre_archivo).".pdf")): ?>
										<a href="<?php echo base_url(); ?>assets/pdfs/examenes/<?php echo trim($info->nombre_archivo); ?>.pdf" target="_BLANK">Ver</a>
										<?php endif; ?>
									</td> -->

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
			</article>	
		</div>
	</div>	
<?php endforeach; ?>
</div>
<div id="modal" class="modal">
	<div class="modal-content">
		<div class="close">&times;</div>
		<div class="modal-info">
			<table class="tabla_cebra">
				<tbody>
					<tr>
						<th>Legajo</th><th>Alumno</th><th>Tipo Insc.</th><th>Estado</th>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			
		</div>
	</div>
</div>
<!-- <div id="lista_inscriptos" class="hidden popup">
	<div class="boton_cerrar">Cerrar</div>
	<table class="tabla_cebra">
		<tbody>
			<tr>
				<th>Legajo</th><th>Alumno</th><th>Tipo Insc.</th><th>Estado</th>
			</tr>
		</tbody>
		<tfoot>
			<tr><td colspan="4">Total Inscriptos: <span id="total_inscriptos"></span></td></tr>
		</tfoot>
	</table>
	
</div> -->
<script src="<?php echo base_url(); ?>assets/js/examenes_view.js"></script>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-51336609-2', 'auto');
  ga('send', 'pageview');
</script>