<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section id='bolillero'>
	<h3>BOLILLERO</h3>

	<div id="bolillas_limites">
		<label for="desde">Desde</label>
		<input type="number" id="desde" placeholder="Desde" min="1" value=1>
		<label for="hasta">Hasta</label>
		<input type="number" id="hasta" placeholder="Hasta" min="1">

		<button id="sortear">Sortear bolilla</button>
	</div>
	<div id="bolilla_resultado">
		<div id='titulo'>Resultado</div>
		<div id='bolilla'>-</div>
	</div>
<!-- 	<p style="width: 400px; font-size: 0.7em; margin: 0px auto; text-align: center;">
		<a href="<?php echo base_url(); ?>aleatoriedad.html" target="_blank" rel="noopener noreferrer">Distribución y aleatoriedad de los resultados</a>
	</p> -->
</section>


<script>
	document.addEventListener('DOMContentLoaded',function(){
		$boton = document.getElementById('sortear');
		document.getElementById('hasta').focus();

		$boton.addEventListener('click',sortear);
		
		function sortear(){
			desde = document.getElementById('desde');
			hasta = document.getElementById('hasta');
			
			if(parseInt(desde.value) >= parseInt(hasta.value) ){
				alert('La bolilla superior debe ser mayor a la bolilla inferior');
				hasta.focus();
				return;
			}

			try{
				desde = validarBolilla('desde', desde.value);
				hasta = validarBolilla('hasta', hasta.value);	
			}catch(error){
				alert(error.mensaje);
				document.getElementById(error.campo).focus();
				return;
			}	
			
			$boton.disabled = true;
			
			timer = setInterval(function(){
				document.getElementById('bolilla').textContent = Math.floor((Math.random()*( (hasta+1) -desde))+desde);
			},50);
			setTimeout( function(){
				 clearInterval(timer);
				 $boton.disabled = false;	
			},2500);
			
		}

		function validarBolilla(campo, valor){
			if(!valor){
				throw {mensaje:`Debe completar el campo '${campo}'`,campo}
			}
			if( isNaN(valor)){
				throw {mensaje:`La bolilla introducida en el campo '${campo}' no es válida`,campo}
			}
			if(parseInt(valor) <= 0){
				throw {mensaje:`La bolilla '${campo}' debe ser mayor o igual a 1`,campo}
			}
			return parseInt(valor);
		}
	})
</script>
<script src="<?php echo base_url() ?>assets/js/script_analytics.js"></script>