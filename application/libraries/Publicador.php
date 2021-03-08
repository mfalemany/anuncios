<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publicador{

	private $archivo_publicaciones = "assets/fake_bd/publicaciones.txt";
	private $archivo_examenes = "assets/fake_bd/turno_examenes.txt";
	private $archivo_aulas = "assets/fake_bd/aulas.txt";
	private $puntero_publicaciones;
	private $puntero_examenes;
	private $puntero_aulas;

	/*
	 * Formato de Anuncio: utc###titulo###cuerpo###publicador %% utc###titulo###cuerpo###publicador
	*/

	function __construct(){
		//lee el archivo especificado en 'archivo_usuarios' y guarda un puntero al mismo en puntero_usuarios
		$this->leer_archivo($this->archivo_publicaciones,'puntero_publicaciones');
		//lee el archivo especificado en 'archivo_examenes' y guarda un puntero al mismo en puntero_examenes
		$this->leer_archivo($this->archivo_examenes,'puntero_examenes');
		//lee el archivo especificado en 'archivo_aulas' y guarda un puntero al mismo en puntero_aulas
		$this->leer_archivo($this->archivo_aulas,'puntero_aulas');
		
	}	


	//devuelve un array con todos los anuncios actuales
	public function lista_anuncios(){
		$anuncios = array();
		
		//si el archivo de publicaciones es leido, y tiene contenido
		
		if($contenido = file_get_contents($this->archivo_publicaciones)){


			//lo divido en registros individuales
			$registros = explode("%%",$contenido);	

			//y por cada uno
			foreach($registros as $registro){
				
				if(strlen(str_replace(" ", "", $registro)) > 0){
					
					//obtengo sus campos	
					$campos = explode("###",$registro);
					
					$anuncio = array(
						'id_anuncio'=>$campos[0],
						'titulo'=>$campos[1],
						'cuerpo'=>$campos[2],
						'usuario'=>Usuarios::obtener_usuario($campos[3]), //se le pasa el id de usuario de la publicacion
						'fecha'=>formatear_fecha($campos[0]) //se le pasa el utc de la publicacion
					);	
					
					//agrego el anuncio leido al array
					array_push($anuncios, $anuncio);
				}
			}	
		}
		return array_reverse($anuncios); //se retorna lleno o vacio, en funcion de la lectura del archivo
	}

	//devuelve un array con todos las fechas, horarios y detalles de un turno de examenes
	public function lista_examenes(){
		$examenes = array();
		$indice = 1;
		while($registro = fgets($this->puntero_examenes)){
			$registro = substr($registro, 0, (strlen($registro) - 1) );
			//var_dump($registro);
			//si es el primer registro que se lee, se obtienen los detalles del turno 
			//(es el unico registro con formato diferente al resto)
			if($indice == 1){
				$detalles = explode("###",$registro);
				$examenes['detalles_turno']['nombre_turno'] = $detalles[0];
				$examenes['detalles_turno']['desde_turno'] = $detalles[1];
				$examenes['detalles_turno']['hasta_turno'] = $detalles[2];
				$examenes['detalles_turno']['inicio_insc_turno'] = $detalles[3];
			}else{

				$materia = explode("###",$registro);
				//var_dump($materia); die;
				$examenes['materias'][utf8_decode($materia[0])] = array(
																		'horario' => utf8_decode($materia[1]),
																		'lugar' => utf8_decode($materia[2]),
																		'fecha_examen' => utf8_decode($materia[3]),
																		'fecha_fin_insc' => utf8_decode($materia[4]),
																		'modificado' => utf8_decode($materia[5]),
																		'activo' => utf8_decode($materia[6]),
																		'anio' => utf8_decode($materia[7]),
																		'nombre_archivo' => utf8_decode($materia[8])
																	);
			
			}
			$indice++;
		}
		return $examenes;
		
	}

	public function get_aulas(){
		$aulas = array();
		while($registro = fgets($this->puntero_aulas)){
			$aula = explode("###",$registro);
			$aulas[$aula[0]] = $aula[1];
		}
		return $aulas;
	}

	public function get_examenes(){
		$aulas = $this->get_aulas();
		$examenes = array();
		$indice = 1;
		while($registro = fgets($this->puntero_examenes)){

			$examen = explode("###",$registro);
			
			//el primer registro contiene los detalles
			if($indice == 1){
				$examenes['detalles_turno']['nombre_turno'] = $examen[0];
				$examenes['detalles_turno']['desde_turno'] = $examen[1];
				$examenes['detalles_turno']['hasta_turno'] = $examen[2];
				$examenes['detalles_turno']['inicio_insc_turno'] = $examen[3];
			}else{

				$examenes['mesas'][utf8_decode($examen[0])] = array(
														'horario' => utf8_decode($examen[1]),
														'lugar' => utf8_decode($aulas[$examen[2]]),
														'fecha_examen' => utf8_decode($examen[3]),
														'fecha_fin_insc' => utf8_decode($examen[4]),
														'modificado' => utf8_decode($examen[5]),
														'activo' => utf8_decode($examen[6]),
														'anio' => utf8_decode($examen[7]),
														'nombre_archivo' => utf8_decode($examen[8])
													);
			}
			$indice++;
		}

		return $examenes;
	}

	//esta funcion re-escribe el archivo de examenes en dos partes...
	//primero, genera un array con todos los datos actualizados, tal como lo cargo el usuario
	//despues, en base a ese array, escribe el archivo de examenes
	public function guardar_turno($datos){
		
		$examenes = array();
		$indice = 1;
		while($registro = fgets($this->puntero_examenes)){
			//si es el primer registro que se lee, se obtienen los detalles del turno 
			//(es el unico registro con formato diferente al resto)
			if($indice == 1){
				$examenes['detalles_turno']['nombre_turno'] = $datos['nombre_turno'];
				$examenes['detalles_turno']['desde_turno'] = $datos['desde_turno'];
				$examenes['detalles_turno']['hasta_turno'] = $datos['hasta_turno'];
				$examenes['detalles_turno']['inicio_insc_turno'] = $datos['inicio_insc_turno'];
			}else{

				$materia = explode("###",$registro);
				$indice = trim($materia[8])."_modificado";
				if(array_key_exists($indice,$datos) ){
					$modif = 1;
				}else{
					$modif = 0;
				}

				$examenes['materias'][utf8_decode($materia[0])] = array(
																		'horario' => $datos[trim($materia[8])."_horario"],
																		'lugar' => $datos[trim($materia[8])."_lugar"],
																		'fecha_examen' => $datos[trim($materia[8])."_fecha_examen"],
																		'fecha_fin_insc' => $datos[trim($materia[8])."_fecha_fin_insc"],
																		'modificado' => $modif,
																		'activo' => 1,
																		'anio' => utf8_decode($materia[7]),
																		'nombre_archivo' => utf8_decode($materia[8])
																	);

			
			}
			$indice++;
		}
		//en este momento, tenemos en la variable $examenes todo el array con los datos listos para escribir al archivo
		//si el archivo está abierto, lo cierro
		if($this->puntero_examenes){
			fclose($this->puntero_examenes);
		}
		//ahora lo abro (se trunca a longitud 0)
		$archivo = fopen($this->archivo_examenes,'w+');
		$detalles = $examenes['detalles_turno']['nombre_turno']."###".
				    $examenes['detalles_turno']['desde_turno']."###".
				    $examenes['detalles_turno']['hasta_turno']."###".
				    $examenes['detalles_turno']['inicio_insc_turno'].PHP_EOL;
		fwrite($archivo,$detalles);
		foreach ($examenes['materias'] as $key => $value) {
			$mesa = $key."###".
					$value['horario']."###".
					$value['lugar']."###".
					$value['fecha_examen']."###".
					$value['fecha_fin_insc']."###".
					$value['modificado']."###".
					$value['activo']."###".
					$value['anio']."###".
					$value['nombre_archivo'];
			fwrite($archivo,$mesa);
		}
			

/*

		
  'materias' => 
    array (size=36)
      'Matemática I' => 
        array (size=8)
          'horario' => string '08:00' (length=5)
          'lugar' => string '0' (length=1)
          'fecha_examen' => string '30/09/2015' (length=10)
          'fecha_fin_insc' => string '28/09/2015' (length=10)
          'modificado' => int 1
          'activo' => int 1
          'anio' => string '1' (length=1)
          'nombre_archivo' => string 'matematicaI
*/
		return $examenes;

	}

	public function guardar_anuncio($titulo, $contenido, $id_publicador){
		//no permito que el anuncio contenga caracteres que son utilizados para
		//la gestion del archivo de anuncios
		$t = strtoupper(str_replace(array("###","%%","<","/>","</"), "", $titulo));
		$c = str_replace(array("###","%%","script"), "", $contenido);

		//genero el registro con su formato especifico
		$nuevo_registro = time()."###".$t."###".$c."###".$id_publicador."%%"; //aca hay que reemplazar por la sesion activa	
		
		//si puedo guardarlo, devuelvo EXITO
		if(is_writable($this->archivo_publicaciones)){
			if(fwrite($this->puntero_publicaciones,$nuevo_registro)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}



	public function eliminar_anuncio($id_anuncio){
		//flag para saber si se encontro y elimino el anuncio pasado como parametro
		$eliminado = FALSE;

		if($contenido = file_get_contents($this->archivo_publicaciones)){
			//variable que contendra todos los anuncios, excepto el eliminado
			$nuevo_contenido = "";

			$registros = explode("%%",$contenido);	
			foreach($registros as $registro){
				if(strlen(str_replace(" ", "", $registro)) > 0){
					$campos = explode("###",$registro);
					//si el id_anuncio pasado como parametro coincide con el actual
					//no lo guardamos, logrando un fichero nuevo, pero sin el eliminado
					if ($campos[0] != $id_anuncio ){
						$nuevo_contenido .= $registro."%%";
					}else{
						$eliminado = TRUE;
					}
				}
			}	
			
			//si se elimino el anuncio buscado, se vuelve a grabar el archivo, sino, se lo deja igual
			if($eliminado){
				file_put_contents($this->archivo_publicaciones, $nuevo_contenido);
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}


	//establece un puntero al archivo seleccionado
	private function leer_archivo($nombre,$atributo){
		//si el archivo existe, se lo abre para lectura/escritura (puntero al inicio del fichero)
		$this->$atributo = @fopen($nombre,'a+');	
	}


}

/* End of file publicador.php */
/* Location: ./application/libraries/publicador.php */