/*
PARA UTILIZAR ESTE SCRIPT, DEBE HABER UN CODIGO HTML COMO ESTE EN EL DOCUMENTO

<div id='boton_burger_container' class='oculto'>
	<div id="boton_burger">
		<div class="barra" id="barra1"></div>
		<div class="barra" id="barra2"></div>
		<div class="barra" id="barra3"></div>
	</div>
</div>


Y UN MENU CON LA SIGUIENTE ESTRUCTURA
<div id='menu_mobile' class='oculto'>
	<ul>
		<li><a href="">OCPION 1</a></li>
		<li><a href="">OCPION 2</a></li>
		<li><a href="">OCPION 3</a></li>
		<li><a href="">OCPION 4</a></li>
	</ul>
</div>
 */
/* 
	boton_burger: ID del elemento que funcionará como botón
	menu_manejado: ID del elemento que contiene el menú que se controlará
*/
export function burgerizar(botonBurgerID,menuID){
	const boton_burger = document.getElementById(botonBurgerID);
	boton_burger.addEventListener('click',function(){
		const menu = document.getElementById(menuID);
		//Quito o agrego la clase Oculto al menú
		menu.classList.toggle('is_active');
		const barras = document.querySelectorAll(`#boton_burger .barra`);
		barras.forEach( barra => barra.classList.toggle("change"));	
	});	
}