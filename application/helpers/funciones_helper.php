<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function formatear_fecha($utc){
		$fecha = date('Y-m-d H:i:s', $utc);

		//obtengo el anio
		$anio = substr($fecha, 0, 4);

		//obtengo el mes en numero
		$mes = substr($fecha, 5,2);

		//defino un array con los meses del año para obtener el mes en texto
		$meses = array( "01"=>"enero","02"=>"febrero","03"=>"marzo","04"=>"abril","05"=>"mayo","06"=>"junio","07"=>"julio","08"=>"agosto","09"=>"septiembre","10"=>"octubre","11"=>"noviembre","12"=>"diciembre");
		$mes_string = $meses[$mes];


		//obtengo el día del mes
		$dia = substr($fecha, 8, 2);

		//defino un array con los dias de la semana para obtener el día en texto
		$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
		$dia_string = $dias[date('w',$utc)];

		//obtengo la hora y minutos
		$hora = substr($fecha, 11, 5);
		
		//obtengo cada uno por separado
		$minutos = substr($hora, 3, 2);
		$hora = substr($hora, 0, 2);
		
		
		$fecha_formateada = $dia_string." ".$dia." de ".$mes_string." de ".$anio." a las ".($hora).":".$minutos." hs";
		return $fecha_formateada;
	}

	//esta funcion obtiene la cantidad total de visitas y cantidad del mes en curso
	function cantidad_visitas(){
		$contenido = file_get_contents("assets/fake_bd/log.txt");
		$detalles = explode("#",$contenido);
		$total_visitas = count($detalles) - 1;
		
		$visitas_mes_actual = 0;
		foreach ($detalles as $value) {
			$mes = substr($value, 0,7);
			if ( $mes == date("Y-m") ){
				$visitas_mes_actual++;
			}
		}
		/*$puntero = fopen("assets/fake_bd/cant_visitas.txt","w");
		fwrite($puntero, $total_visitas.";".$visitas_mes_actual);
		fclose($puntero);*/
		return array("total"=>$total_visitas, "actual"=>$visitas_mes_actual);


	}

	function registrar_visita(){
		$puntero = fopen("assets/fake_bd/log.txt","a+");
		fwrite($puntero, date('Y-m-d').";".$_SERVER['REMOTE_ADDR']."#");
		fclose($puntero);
	}

	function quote($texto)
	{
		$texto_limpio = '';
		$invalidos = array('/truncate/i','/update/i','/insert/i','/delete/i','/sleep/i','/drop/i','/--/','/\//');
		$texto_limpio = preg_replace($invalidos,'',$texto);
		return "'".addslashes($texto_limpio)."'";
	}

	function validar_legajo($legajo){
		return (preg_match('/^[a-zA-z0-9-]+$/i') !== 1);
	}

		/**
	 * Establece la solicitud y devuelve la respuesta (Utiliza CURL)
	 */
	
	function get_rest($url){
		//La URL a la que se realizará la llamada
		$url = URL_BASE_GUARANI_REST.$url;
		//$proxy = "http://proxycabral.unne.local:3128/";
		$proxy = '';
		
		$ch = curl_init();
		//Tipo de autenticación, usuario y clave
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, USUARIO_GUARANI_REST.':'.CLAVE_GUARANI_REST);
		//Defino la URL de la conexion
		curl_setopt($ch, CURLOPT_URL, $url);
		// El proxy va vacío (no se usa proxy)
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		
		//para devolver el resultado de la transferencia como string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		//para incluir el header en el output (debug)
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		
		$res = curl_exec($ch);
		curl_close($ch);
		echo $res;
	}


	

	/* End of file funciones.php */
	/* Location: ./application/helpers/funciones.php */

