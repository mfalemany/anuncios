<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
Cronograma
<!DOCTYPE html>
<html>
<head>
	<title>Cronograma Diario</title>
	<meta charset="utf-8">
</head>
<body>
	<table border=1	>
		<tr>
			<th>Inicio</th>
			<th>Fin</th>
			<th>Aula</th>
			<th>Materia</th>
			
		</tr>
	<?php foreach ($clases as $clase): ?>
		<tr title="<?php echo $clase->descripcion; ?>">
			<td><?php echo $clase->hora_inicio; ?></td>
			<td><?php echo $clase->hora_fin; ?></td>
			<td><?php echo $clase->aula; ?></td>
			<td><?php echo $clase->materia; ?></td>
			
		</tr>
	<?php endforeach; ?>	

	</table>
</body>
</html>
