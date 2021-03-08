<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examenes extends CI_Controller {
	
	private $cantidad_visitas;

	function __construct(){
		header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->cant_visitas = cantidad_visitas();
		$this->load->model("examenes_model");

	}
	
	public function index(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Examenes"));
		$this->load->view("includes/menu_view");
		$data = array('examenes' => $this->examenes_model->get_examenes(),"aulas"=> $this->examenes_model->get_aulas());

		$this->load->view("examenes/examenes_view",$data);
		
		$this->load->view("includes/footer_view",array("cantidad_visitas"=>$this->cant_visitas['total'],'visitas_mes_actual'=>$this->cant_visitas['actual']));
	}

	public function wrapper($funcion,$parametros){
		
		$parametros = urldecode($parametros);
		$parametros = explode('||',$parametros);
		$parametros = array_map('rawurlencode',$parametros);
		$parametros = implode('/',$parametros);

		$url = "http://10.30.1.13:83/rest/$funcion/$parametros";
		
		//Se setea el manejador de errores
		set_error_handler(array($this,'manejador_errores'));
		//se reduce el tiempo de espera (nunca debería tardar mas de este tiempo)
		ini_set('default_socket_timeout', 10);
		//ini_set('display_errors','0');
		$respuesta = file_get_contents($url);
		restore_error_handler();

		//La variable $http_response_header[0] contiene las cabeceras de la lectura hecha por file_get_contents. Si se recibe OK, se manda la respuesta, sino, la cabecera recibida
		if(strpos($http_response_header[0], 'OK') >= 0){
			echo $respuesta;
		}
	
	}
	private function manejador_errores($codigo, $mensaje){
		header("HTTP/1.0 418 Connection Timeout");
		return FALSE;
	}
	
}

/* End of file examenes.php */
/* Location: ./application/controllers/examenes.php */