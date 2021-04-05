<div class="botonera">
	<span>Bienvenido&nbsp;&nbsp;<b><?php echo $this->session->userdata('nombre_pila'); ?></b>.</span>
	<span><a href="<?php echo base_url(); ?>publicar">Anuncios</a></span>
	<span><a href="<?php echo base_url(); ?>publicar/examenes">Exámenes</a></span>
	<span><a href="<?php echo base_url(); ?>publicar/normativas">Normativas</a></span>
	<span><a href="<?php echo base_url(); ?>login/cambio_clave">Cambiar mi clave</a></span>
	<span><a href="<?php echo base_url(); ?>login/cerrar_sesion">Cerrar Sesión</a></span>
</div>