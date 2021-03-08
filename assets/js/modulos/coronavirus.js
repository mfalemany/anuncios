document.addEventListener('DOMContentLoaded',function(){
	img = document.createElement('img');
	img.setAttribute('src','http://www.agr.unne.edu.ar/anuncios/assets/imagenes/coronavirus02.png');
	img.setAttribute('id','coronavirus');
	img.style.width = '65px';
	img.style.height = '65px';

	document.body.append(img);
	/* ======================= CORONAVIRUS FLOTANDO =================================== */
	//Muestra la imagen del coronavirus en intervalos irregulares
	cv = document.getElementById('coronavirus');

	if(document.querySelectorAll('.anuncio').length > 5){
		cv.addEventListener('click', function(){
			alert('#QuedateEnCasa\nNuestro mail: alumnado-fca@agr.unne.edu.ar');
			clearInterval(cv_interval);
			cv.style.display = 'none';
		});	
		cv_interval = setInterval(function(){
			cv.classList.remove('oculto');	
			width = Math.random()*document.body.offsetWidth;
			height = Math.random()*document.body.offsetHeight;
			signo = (Math.round(Math.random())) ? '+' : '-';
			cv.style.transform = `translate(${width}px,-${height}px)`;
		},2000);
		//en 20 segundos desaparece
		setTimeout(function(){
			clearInterval(cv_interval);
			cv.style.display = 'none';
		},20000);
	}else{
		cv.style.display = 'none';
	} 
	/* ==================================================================================== */
})