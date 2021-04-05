<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Normativas_model extends CI_Model {
	
	private $archivo_normativas = "./assets/fake_bd/normativas.json";
	
	function __construct(){
		parent::__construct();
		
	}

	function guardar_normativa($normativa){
		$no_permitidos = array(' ','!','\\','"','$','%','&','/','(',')','=','\'','*','^','"',':',';','_','.','-','{','}','[',']');
		
		$nombre_archivo = strtolower(str_replace($no_permitidos,'',$normativa['nombre']));
		if( ! $this->subir_archivo($nombre_archivo)){
			return array('error'=>trim($this->upload->display_errors()));	
		}
	
		$normativas = json_decode(file_get_contents($this->archivo_normativas),TRUE);
		$normativas = ($normativas == NULL) ? array() : $normativas;
		$normativas[] = array(
			"nombre"      => $normativa['nombre'],
			"descripcion" => $normativa['descripcion'],
			"categoria"   => $normativa['categoria'],
			"archivo"     => $nombre_archivo);

		$archivo = fopen($this->archivo_normativas,"w+");
		fwrite($archivo,json_encode($normativas));
		fclose($archivo);
		
	}

	function obtener_todas(){
		$normativas = json_decode(file_get_contents($this->archivo_normativas),TRUE);
		$por_categoria = array();
		foreach ($normativas as $normativa) {
			$por_categoria[$normativa['categoria']][] = $normativa;
		}
		return $por_categoria;
	}

	function subir_archivo($nombre_archivo){
		$config['upload_path']   = './assets/pdfs/perm/';
		$config['allowed_types'] = 'pdf';
		$config['file_name']     = $nombre_archivo;
		$this->load->library('upload', $config);

		return $this->upload->do_upload('archivo');
	}

	function eliminar_archivo($nombre_archivo){
		//Elimino el archivo
		unlink("./assets/pdfs/perm/$nombre_archivo.pdf");
		//y lo saco del json
		$normativas = json_decode(file_get_contents($this->archivo_normativas),TRUE);
		$final = array();
		foreach($normativas as $indice => $normativa){
			//Se guardan todos menos el que coincida
			if($normativa['archivo'] != $nombre_archivo){
				$final[] = $normativa;
			}
		}
		$archivo = fopen($this->archivo_normativas,"w+");
		fwrite($archivo,json_encode($final));
		fclose($archivo);
	}

}

/* End of file normativas_model.php */
/* Location: ./application/normativas/normativas_models.php */