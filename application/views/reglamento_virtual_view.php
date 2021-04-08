<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $datos = json_decode(file_get_contents('assets/fake_bd/reglamentos_virtual.json'),TRUE); ?>
<div class="articulo">
	<section class="seccion" id="reglamento_virtual">
		<div class="titulo_seccion">
			Bolillero
		</div>
		<div class="cuerpo_seccion">
			Puede acceder al bolillero haciendo <a href="<?php echo base_url(); ?>bolillero" target="_BLANK" rel="noreferrer noopener">click aquí</a>
		</div>	
	</section>
	<section class="seccion" id="reglamento_virtual">
		<div class="titulo_seccion">
			Reglamentos de cátedra para exámenes finales: Modalidad Virtual
		</div>
		<div class="cuerpo_seccion">
			<p>
				El Consejo Directivo de la Facultad de Ciencias Agrarias aprobó el <a href="<?php echo base_url(); ?>assets/pdfs/reglamentos_virtual/protocolo_examenes_virtuales_fca_unne.pdf" target="_BLANK">Protocolo para evaluaciones finales en modalidad virtual</a>, que establece lineamientos generales. 
			</p>
			<p>Cada cátedra establece su reglamento, que incluye la modalidad y condiciones propias para la evaluación. Puede consultar cada uno de estos reglamentos:</p>

			<div id="enlace_tabla_reglamentos">
				<a href="#agr" style="background-color: #55802b;">Ingeniería Agronómica</a>
				<a href="#ind" style="background-color: #1c81b1;">Ingeniería Industrial</a>
			</div>
			
			<?php foreach ($datos['carreras'] as $carrera => $detalles): ?>
				
				<div id="<?php echo $detalles['id_carrera']; ?>"></div>
				<table class="tabla_cebra tabla_reglamentos">
					<caption><h2><u><?php echo $carrera; ?><u></h2></caption>
					<tr>
						<td class="center">Materia</td>
						<td class="center">Reglamento</td>
					</tr>
					<?php foreach ($detalles['anios'] as $anio => $materias): ?>
						<tr>
							<td colspan="2" class="center" style="background-color: #c5c5c5; font-weight: bold;"><?php echo $anio; ?>
							</td>
						</tr>

						<?php foreach ($materias as $materia): ?>
							<tr>
								<td><?php echo $materia['materia']; ?></td>
								<td class="center">
									<?php 
										$archivo = "assets/pdfs/reglamentos_virtual/reglamento_".$materia['archivo'].".pdf"; 

										if(file_exists($archivo)) :
									?> 
									<a href="<?php echo base_url().$archivo; ?>" target="_BLANK" rel="noopener noreferrer" class="enlace">Descargar</a>
									<?php else: ?>
										No disponible
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach ?>
					<?php endforeach ?>
				</table>
			<?php endforeach; ?>
		</div>
	</section>
</div>
<script src="<?php echo base_url() ?>assets/js/script_analytics.js"></script>
