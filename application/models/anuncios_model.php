<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anuncios_model extends CI_Model {
	
	private $archivo_anuncios = "assets/fake_bd/publicaciones.json";

	function __construct(){
		parent::__construct();
	}

	public function obtener_todos(){
		$registros = json_decode(file_get_contents($this->archivo_anuncios));
		$anuncios = array();
		foreach ($registros as $key => $anuncio) {
			if($anuncio->titulo){
				$anuncios[] = array("titulo"=>$anuncio->titulo,
									"contenido"=>$anuncio->contenido,
									"autor"=>$anuncio->autor,
									"utc"=>$anuncio->utc,
									"carrera"=>$anuncio->carrera);
			}
			
		}
		return array_reverse($anuncios);
	}

	public function guardar_anuncio($titulo,$contenido, $id_usuario, $carrera, $id_anuncio = NULL){
		$registros = json_decode(file_get_contents($this->archivo_anuncios));
		$anuncios = array();
		foreach ($registros as $key => $anuncio) {
			$anuncios[$anuncio->utc] = array("titulo"=>$anuncio->titulo,
								"contenido"=>$anuncio->contenido,
								"autor"=>$anuncio->autor,
								"utc"=>$anuncio->utc,
								"carrera"=>$anuncio->carrera);
		}
		if($id_anuncio){
			$indice = (array_key_exists($id_anuncio,$anuncios)) ? $id_anuncio : $anuncio->utc;
		}
		$anuncios[$indice] = array("titulo"=>strtoupper($titulo),
							"contenido"=>$contenido,
							"autor"=>$id_usuario,
							"utc"=>time(),
							"carrera"=>$carrera);
		$archivo = fopen($this->archivo_anuncios,"w+");
		fwrite($archivo,json_encode($anuncios));
		fclose($archivo);
		return TRUE;
	}

	public function eliminar_anuncio($id_anuncio){
		$registros = json_decode(file_get_contents($this->archivo_anuncios));
		$anuncios = array();
		foreach ($registros as $key => $anuncio) {
			if($anuncio->utc != $id_anuncio){
				$anuncios[] = array("titulo"=>$anuncio->titulo,
									"contenido"=>$anuncio->contenido,
									"autor"=>$anuncio->autor,
									"utc"=>$anuncio->utc,
									"carrera"=>$anuncio->carrera);
			}
		}
		$archivo = fopen($this->archivo_anuncios,"w+");
		fwrite($archivo,json_encode($anuncios));
		fclose($archivo);
		redirect("publicar");
	}



	

	
}

/* End of file anuncios_model.php */
/* Location: ./application/models/anuncios_models.php */