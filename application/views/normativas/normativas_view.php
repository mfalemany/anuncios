<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="normativas" class="articulo">
	<section class="seccion">
		<div class="titulo_seccion">
			Normativas Generales
		</div>
		<div class="cuerpo_seccion">
			<ul>
			<?php if(isset($normativas['G'])) : ?>
				<?php foreach($normativas['G'] as $normativa) : ?>
				<li>
					<a href="<?php echo base_url(); ?>assets/pdfs/perm/<?php echo $normativa['archivo']; ?>.pdf" 
						target="_blank"><?php echo $normativa['nombre']; ?></a> - <?php echo $normativa['descripcion']; ?>
						<?php if($this->session->userdata('logged_in')): ?>
						-
						<a class="confirmacion" href="<?php echo base_url(); ?>normativas/eliminar/<?php echo $normativa['archivo']; ?>">Eliminar</a>
					<?php endif; ?>

					</li>
				<?php endforeach; ?>		
			<?php endif; ?>
			</ul>
		</div>
	</section>
	<section class="seccion">
		<div class="titulo_seccion">
			Normativas Particulares
		</div>
		<div class="cuerpo_seccion">
			<ul>
				<?php if(isset($normativas['P'])) : ?>
				<?php foreach($normativas['P'] as $normativa) : ?>
				<li><a href="<?php echo base_url(); ?>assets/pdfs/perm/<?php echo $normativa['archivo']; ?>.pdf" 
						target="_blank"><?php echo $normativa['nombre']; ?></a> - <?php echo $normativa['descripcion']; ?>  

					<?php if($this->session->userdata('logged_in')): ?>
						-
						<a class="confirmacion" href="<?php echo base_url(); ?>normativas/eliminar/<?php echo $normativa['archivo']; ?>">Eliminar</a>
					<?php endif; ?>
					</li>
				<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
	</section>
</div>
<script type="text/javascript">
	 let enlaces = document.querySelectorAll('.confirmacion');
	 enlaces.forEach((elemento) => {
	 	elemento.addEventListener('click',(evento)=>{
	 		if( ! confirm('Eliminar?')) evento.preventDefault();
	 	})
	 })
</script>