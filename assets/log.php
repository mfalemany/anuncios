<?php 
	include_once("fake_bd/geoiploc.php");

	$logs = fopen("fake_bd/log.txt",'r');
	
	$contenido = fgets($logs);
	$registros = explode("#",$contenido); 
	$fecha = "";
	$contador = array();
	foreach ($registros as $value){
		if($value){
			$campos = explode(";",$value);
			if(array_key_exists($campos[0], $contador)){
				$contador[$campos[0]]++; 
			}else{
				$contador[$campos[0]] = 1; 
			}
		}
	}
	foreach ($contador as $key => $value){
		echo substr($key, 8, 2)."/".substr($key, 5, 2)."/".substr($key, 0, 4).": ".$value." visitas.<br>";
	}
	echo $_SERVER['REMOTE_ADDR'];
	var_dump(getCountryFromIP());
?>