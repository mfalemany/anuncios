<?php
autenticar();
if(isset($_FILES['archivos']) && count($_FILES['archivos']) > 0){ 
	try {
		procesar_archivos();
		$notificacion = "Subido con Éito!";
	} catch (Exception $e) {
		$notificacion = 'Ocurrió el siguiente error: ' . $e->getMessage();
	}
}

function listar_nombres_archivos(){
	$reglamentos = json_decode(file_get_contents('./assets/fake_bd/reglamentos_virtual.json'),TRUE);
	foreach($reglamentos['carreras'] as $nombre_carrera => $carreras){
		echo "<table class='tabla_materias'>";
		echo "<caption>$nombre_carrera</caption>";
		echo "<th>Materia</th><th>Nombre de Archivo</th>";
		foreach($carreras['anios'] as $anio){
			foreach($anio as $materias){
				echo "<tr>";
				echo "<td>".$materias['materia']."</td><td>".$materias['archivo']."</td>";
				echo "</tr>";
			}
			
		}
		echo "</table>";
	}
}
function procesar_archivos(){
	if( ! is_dir($_POST['ruta'])) throw new Exception('No existe el directorio indicado');
	for($i = 0; $i < count($_FILES['archivos']['name']); $i++){
		if( ! move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $_POST['ruta'] . "/" . $_FILES['archivos']['name'][$i])){
			throw new Exception('No se pudo subir el archivo');
		}
	}
}
function autenticar(){
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		denegar();
	}else{
		$logueado = FALSE;
		$usuarios = json_decode(file_get_contents('./assets/fake_bd/usuarios.json'),TRUE);
		foreach($usuarios as $usuario){
			if(strtolower($_SERVER['PHP_AUTH_USER']) == strtolower($usuario['usuario']) && sha1($_SERVER['PHP_AUTH_PW']) == $usuario['clave']){
				$logueado = TRUE;
				break;
			}
		}
		if(!$logueado) denegar();
		
	}	
}
function denegar(){
	header('WWW-Authenticate: Basic realm="Uploader de archivos"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Necesita autorización para acceder.';
	exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Subir archivos</title>
	<style>
		label{
			display: inline-block;
			min-width: 160px;
			text-align: right;
		}
		#notificacion{
			background-color: yellow;
			text-align: center;
		}
		.aclaracion_label{
			font-size: 0.8em;
		}
		.tabla_materias{
			border-collapse: collapse;
			float: left;
			margin: 10px;
		}
		.tabla_materias caption{
			font-size: 1.1em;
			font-weight: bold;
		}
		.tabla_materias tr:nth-child(odd){
			background-color:#CCC;
		}
		.tabla_materias tr td, .tabla_materias th{
			border: 1px solid black;
		}
		input[type="submit"]{
			position: relative;
			left: 160px;
		}
	</style>
</head>
<body>
	<div id="notificacion">
		<?php echo (isset($notificacion)) ? $notificacion : ''; ?>
	</div>
	<form action="uploader.php" method="POST" enctype="multipart/form-data">
		<label>Archivo</label> <input type="file" name="archivos[]" id="archivos" multiple required>
		<br>
		<br>
		<label>Ruta:</label> <input type="text" name="ruta" id="ruta" size="80" required> 
		<span class="aclaracion_label">(El directorio de referencia es <?php echo __DIR__; ?>/)</span>
		<br>
		<br>
		<input type="submit" value="Subir archivo(s)">
	</form>
	<ul>
		<li><a href="" class="enlace_ruta" id="reglamento_examen">Es un reglamento de examen</a></li>
	</ul>
	<div>
	<?php listar_nombres_archivos(); ?>
	</div>
	<script>
		const rutas = {
			"reglamento_examen":"./assets/pdfs/reglamentos_virtual"
		}
			
		$enlaces = document.querySelectorAll('.enlace_ruta')
		$enlaces.forEach( ruta => {
			ruta.addEventListener('click', evento => {
				evento.preventDefault();
				document.getElementById('ruta').value = rutas[evento.target.getAttribute('id')];
			})
		})
	</script>
</body>
</html>