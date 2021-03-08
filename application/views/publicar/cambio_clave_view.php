<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if(count($this->error) > 0): 
		if(strlen($this->error['descripcion'] ) > 0): ?>
			<div class="mensaje_error">
			<?php echo $this->error["descripcion"]; ?>
		<?php else: 
				redirect("login");
			 endif; ?>
	<?php endif; ?>
</div>



<div id="cambio_clave">
	<?php echo form_open('login/cambiar_clave',array("id"=>"form_cambio_clave") ); ?>
	<table id='cambio_clave_tabla'>
		<tr>
			<td colspan="2">Cambio de clave para <?php echo $usuario; ?></td>
		</tr>
		<tr>
			<td><label for="actual">Clave Actual:</label></td>
			<td><input type="password" name="actual" id="actual" autofocus></td>
		</tr>
		<tr>
			<td><label for="nueva">Clave Nueva:</label></td>
			<td><input type="password" name="nueva" id="nueva"></td>
		</tr>
		<tr>
			<td><label for="rep_nueva">Repetir clave nueva:</label></td>
			<td><input type="password" name="rep_nueva" id="rep_nueva"></td>
		</tr>
		<tr>
			<td><input type="button" value="Volver" class="boton_fail" id="cancelar"></td>
			<td><input type="submit" value="Cambiar" class="boton_ok" id="submitCambioClave"></td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
	$("#cancelar").on("click",function(){
		window.location.href = "<?php echo base_url(); ?>publicar/";
	})
</script>