<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- 
<div style="text-align:center; color:#FFF; background-color:#bf5454;">
	<h3 style="padding: 3px 0px 3px 0px;  text-shadow: 1px 1px 1px #222;">Inscripción al Curso Anticipado de Ingreso: 
		<a href="http://www.agr.unne.edu.ar/curso" target="_BLANK" style="color:inherit;">click aquí!</a>
	</h3>
</div>
-->
<!-- =========================== DÍAS NO LABORABLES ========================================-->
<style>
	.enlace{
		color:#FFF; 
		font-size: 0.9em;
		text-decoration: none; 
		cursor: pointer; 
		text-shadow: 1px 1px 1px black;
		box-sizing: border-box;
		padding: 0px 20px;

	}
	.enlace:hover{
		background-color: #4f612a;
	}
</style>
<!-- =========================== FILTROS ========================================-->
<div id="filtro">
	<div id="filtro_criterio">
		<label for="txt_filtro_criterio" id="lbl_filtro_criterio">Filtrar anuncios: </label>
		<input type="text" id="txt_filtro_criterio"  placeholder="Filtrar Anuncios">
	</div>
	<div id="filtro_carrera">
		<label for="carrera" id="lbl_filtro_carrera">Ver anuncios para:</label>
		<select name="carrera" id="carrera">
			<option value="todas">Todas las carreras</option>
			<option value="agronomia">Ing. Agronómica</option>
			<option value="industrial">Ing. Industrial</option>
		</select>
	</div>
</div>
<!-- =========================== FILTROS ========================================-->

<!-- =========================== ANUNCIOS DESTACADOS ============================-->

<!-- ANUNCIO DESTACADO -->
<!--
<div class="anuncio todas" id="0">
	<div class="anuncio_titulo" style="background-color: #9e5050 !important;">
		
	</div>
	<div class="anuncio_contenido">
		<p></p>
	</div>
	<div class="autor" title="Por Dirección Gestión Estudios">
	Publicado el 9 de diciembre de 2020.
	</div>
</div> 
-->
<!-- FIN DEL ANUNCIO DESTACADO-->

<!-- =========================== ANUNCIOS ========================================-->

<?php foreach(json_decode($anuncios) as $anuncio): ?>
	<?php //var_dump($anuncio); die; ?>

	 
	<div class="anuncio <?php echo $anuncio->carrera; ?>" id="<?php echo $anuncio->utc; ?>"  >
		<div class="anuncio_titulo <?php echo $anuncio->carrera; ?>" ><?php echo $anuncio->titulo; ?></div>
		<div class="anuncio_contenido">
			<?php echo $anuncio->contenido; ?>
		</div>
		<div class="autor" title="Por <?php echo $usuarios[$anuncio->autor]['nombre_pila']; ?>">
		Publicado el <?php echo formatear_fecha($anuncio->utc); ?>.
		</div>
	</div> 
<?php endforeach; ?>

<!-- =========================== ANALYTICS ========================================-->
<script src="<?php echo base_url() ?>assets/js/script_analytics.js"></script>

