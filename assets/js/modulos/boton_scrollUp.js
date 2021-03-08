export function scrollUpButton(alturaDesdeVisible){
	//Shorcut del document
	const d = document;
	//Creo el botón
	const boton = document.createElement('button');
	//Propiedades del botón
	boton.setAttribute('id','scrollUpButton');
	boton.classList.add('hidden');
	
	

	//Agrego el evento al clik
	boton.addEventListener('click',goUp);
	//agrego el botón al documento
	document.body.appendChild(boton);
	
	//durante el scroll en la pantalla, se muestra o oculta el boton
	window.addEventListener('scroll',function(){
		let scrollTop = window.pageYOffset || d.documentElement.scrollTop;
		if(scrollTop > alturaDesdeVisible){
			boton.classList.remove('hidden');
			
		}else{
			boton.classList.add('hidden');
		}
	})
	
}

function goUp(){
	window.scrollTo({top:0,behavior:'smooth'});
}