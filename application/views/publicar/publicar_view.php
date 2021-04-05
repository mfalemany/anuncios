<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<div id="publicar">
	<div id="nueva_publicacion">
		<?php echo form_open_multipart('publicar/guardar'); ?>
		<table id="tabla_publicacion">
			<tr>
				<td>
					<label for="titulo" style="color:white">Titulo:</label>
					<input type="text" name="titulo" id="titulo">
					<label for="carrera" style="color:white">Publicación para:</label>
					<select name="carrera" id="carrera">
						<option value="todas">Todas las carreras</option>
						<option value="agronomia">Ing. Agronómica</option>
						<option value="industrial">Ing. Industrial</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><textarea name="editor1" id="editor1" cols="30" rows="10"></textarea></td>
			</tr>
		</table>
		<input type="hidden" id="id_anuncio" name="id_anuncio" value="">
		<input type="submit" value="Publicar" id="submit_publicar" class="boton_ok">
		<input type="button" value="Subir un archivo" id="subir_archivo" class="boton_opcion">&nbsp;&nbsp;(Máximo: <?php echo ini_get('post_max_size'); ?>)

		<?php echo form_close(); ?>
		
	</div>
	<hr>

</div>

<div id="carga_archivos">
	<div id="form_carga_archivos">
		<h2>Subir un archivo</h2>
		<div id="campos_archivo">
			<form action="" enctype = "multipart / form-data" >
				<p>Texto del enlace: <input type="text" name="texto_enlace" id="texto_enlace" value="Enlace..."></p>
				<p>Archivo : <input type="file" name="userfile" id="userfile"></p>
				<input type="button" class="boton_fail" value="Cancelar" id="cancelar">
				<input type="button" class="boton_ok" value=" Listo! " id="subir">
			</form>

		</div>
	</div>
</div>



<div id="publicaciones_actuales">

<?php if(json_decode($anuncios) > 0): ?>
	<h1>Publicaciones Actuales</h1>
<?php else: ?>
	<h1>No hay anuncios publicados!</h1>
<?php endif; ?>


<?php foreach(json_decode($anuncios) as $anuncio): ?>
	
	<div class="anuncio <?php echo $anuncio->carrera; ?>" id="<?php echo $anuncio->utc; ?>">
		<div class="anuncio_titulo <?php echo $anuncio->carrera; ?>"><?php echo $anuncio->titulo; ?></div>
		<div class="anuncio_contenido">
			<?php echo $anuncio->contenido; ?>
		</div>
	<div class="autor">Publicado el <?php echo formatear_fecha($anuncio->utc); ?> por <?php echo $usuarios[$anuncio->autor]["nombre_pila"]; ?>.</div>
	<div class="acciones derecha">
		<br>
		<input type="button" value="Editar" onclick="editar_anuncio(<?php echo $anuncio->utc; ?>)" class="boton_opcion">
		<input type="button" value="Eliminar" onclick="eliminar_anuncio(<?php echo $anuncio->utc; ?>)" class="boton_fail">
	</div>
	</div> 
	<br>

<?php endforeach; ?>

	

</div>

<!-- CKEDITOR -->
<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modulos/publicar.js"></script>