<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if($this->error): ?>
<div class="mensaje_error">
	La combinación de usuario y clave no es correcta. Por favor, intentelo nuevamente!
</div>
<?php endif; ?>

<div id="login">
	<?php echo form_open('login/verifico_login',array('id'=>'form_login')); ?>
		<table>
			<tr>
				<td colspan="2" class='center'><h3>Publicacion de Anuncios - AGR</h3></td>
			</tr>
			<tr>
				<td><label for="username">Usuario:</label></td>
				<td><input type="text" name="usuario" id="usuario_login"> </td>
			</tr>
			<tr>
				<td><label for="pass">Clave:</label> </td>
				<td><input type="password" name="pass" id="pass_login"> </td>
			</tr>
			<tr>
				<td colspan="2" class='center'><input type="submit" value="Ingresar"> </td>
			</tr>
			<tr>
				<td colspan="2" class='center'><a href="<?php echo base_url(); ?>inicio">Volver a los anuncios</a></td>
			</tr>
		</table>
	<?php echo form_close(); ?>
</div>