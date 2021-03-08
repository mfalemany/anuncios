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
<div id="no_laborables" style="background-color:#76905c; margin: -18px auto 3px 0px; text-align: center;">
	<a href="http://www.agr.unne.edu.ar/images/documentos/Res-778.17.pdf" target="_BLANK" class='enlace'>CRONOGRAMA DE DÍAS NO LABORABLES</a>
	<a href="<?php echo base_url(); ?>/assets/pdfs/perm/resol_316_19.pdf" target="_BLANK" class='enlace'>RÉGIMEN DE REGULARIDAD DE ESTUDIANTES</a>
</div>
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51336609-2', 'auto');
  ga('send', 'pageview');

</script>

