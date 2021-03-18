<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	
	<title><?php echo $titulo; ?></title>
	<!-- jquery -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<!-- script propio -->
	<script type="module" src="<?php echo base_url(); ?>assets/js/script.js?a=<?php echo time(); ?>"></script>
	
	<!-- hoja de estilos -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/estilos.css?a=<?php echo time(); ?>" media="all"> 
	<!-- Botón Hamburguesa -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/boton_burger.css?a=<?php echo time(); ?>" media="all"> 
	<!-- fuente de google -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
	<!-- metadatos -->
	<meta property="og:url" content="http://www.agr.unne.edu.ar/anuncios/" />
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="Anuncios FCA">
	<meta property="og:description" content="Sección de novedades administrada por la Dirección Gestión Estudios.">
	<meta property="og:image" content="http://www.agr.unne.edu.ar/anuncios/assets/imagenes/fca-fb.png">
	<meta name="Description" content="Novedades para alumnos de la FCA - UNNE. Alumnado-Bedelia" />
	<meta name="author" content="Dir. Gestión Estudios">
	<meta name="title" content="Anuncios FCA">
	<!-- icono de la pagina -->
	<link href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" rel="shortcut icon" />
	

</head>
<body>
	<div id="contenedor">
		<div id="linea_verde"></div>
		<div id="cabecera">
			<img src="<?php echo base_url(); ?>assets/imagenes/header_nuevo.png" alt="Anuncios - FCA">
		</div>