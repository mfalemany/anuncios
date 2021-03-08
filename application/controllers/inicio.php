<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	private $cant_visitas;
	

	function __construct(){
		parent::__construct();

		//se cargan los modelos necesarios para ingresar y publicar
		$this->load->model("usuarios_model");
		$this->load->model("anuncios_model");
		$this->load->model("examenes_model");

		//obtengo la cantidad de visitas actual
		$this->cant_visitas = cantidad_visitas();
	}
	
	public function index(){
		//registro la visita
		$this->usuarios_model->registrar_visita();

		//obtengo una lista de todos los usuarios del sistema
		$usuarios = $this->usuarios_model->obtener_todos();
		$this->load->view("includes/cabecera_view", array('titulo'=>"Anuncios FCA"));
		$this->load->view("includes/menu_view");
		
		//obtengo todos los anuncios
		$anuncios = $this->anuncios_model->obtener_todos();
		
		$data = array('anuncios'=>json_encode($anuncios),"usuarios"=>$usuarios);
		$this->load->view("inicio_view", $data);

		$this->load->view("includes/footer_view",array("cantidad_visitas"=>$this->cant_visitas['total'],'visitas_mes_actual'=>$this->cant_visitas['actual']));
	}

	public function reglamentos(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Anuncios FCA"));
		$this->load->view("includes/menu_view");
		
		$this->load->view('reglamento_virtual_view');
		$this->load->view('includes/footer_view');
	}

	public function cronograma($fecha){
		$fecha = ($fecha) ? $fecha : date('Y-m-d');

		ob_start(); //Inicio de captura de buffer
		get_rest("/clases/$fecha");
		$datos['clases'] = json_decode(ob_get_contents()); // Lo almaceno en una variable
		
		ob_end_clean(); // Finalizo la captura de buffer y lo limpio
		$this->load->view('cronograma_view',$datos);
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */