<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		
		
		</div>
		<div id="footer">
			Contacto: bedeliaagr@gmail.com - Tel.: 0379-4427589 (interno 140) - 
			<?php if(!$this->session->userdata('logged_in')): ?>
				<a href="<?php echo base_url(); ?>publicar">Login</a>
			<?php else: ?>	
				<a href="<?php echo base_url(); ?>publicar">Publicar</a>
			<?php endif; ?>
			
		</div>
	</div>
</body>
</html>
