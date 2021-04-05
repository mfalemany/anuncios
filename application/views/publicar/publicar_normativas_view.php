<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if(isset($notif)) : ?>
<div id="notificacion">
	<?php echo $notif; ?>
</div>
<?php endif; ?>
<?php $post = isset($post) ? $post : array('categoria'=>null); ?>
<div id="publicar_normativas">
	<div id="publicar">
		<form enctype="multipart/form-data" method="POST" action="<?php echo base_url(); ?>publicar/guardar_normativa">
			<div class="linea_formulario">
				<label for="nombre">Nombre (Nro. Resol):</label>
				<input id="nombre" name="nombre" 
						type="text" placeholder="Resol. 316/19 C.S." 
						value='<?php echo (isset($post['nombre'])) ? $post['nombre'] : ''; ?>'>
			</div>
			<div class="linea_formulario">
				<label for="descripcion">Descripción</label>
				<textarea cols=60 rows=3 id="descripcion" name="descripcion" placeholder="Régimen de Evaluación de Aprendizajes"><?php echo (isset($post['descripcion'])) ? $post['descripcion'] : ''; ?></textarea>
			</div>
			<div class="linea_formulario">
				<label for="categoria">Categoría</label>
				<select name="categoria" id="categoria">
					<option value="G" <?php echo ($post['categoria'] == 'G') ? 'selected' : ''?>>Generales</option>
					<option value="P" <?php echo ($post['categoria'] == 'P') ? 'selected' : ''?>>Particulares</option>
				</select>
			</div>
			<div class="linea_formulario">
				<label for="archivo">Documento PDF</label>
				<input type="file" id="archivo" name="archivo">
			</div>
			<div class="linea_formulario botonera">
				<input type="submit" value="Cargar" class="boton_opcion">
			</div>
		</form>
	</div>
	<div id="preview_normativa">
		
	</div>
	<div id="normativas_publicadas">
		
	</div>
</div>
<?php unset($_SESSION); ?>
<script type="text/javascript">
	$notif = document.getElementById('notificacion');
	if($notif){
		setTimeout(()=>{
			$notif.style.opacity = 0;
		},3000);
	}
</script>