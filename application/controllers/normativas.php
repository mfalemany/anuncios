<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Normativas extends CI_Controller {

	private $cant_visitas;
	

	function __construct(){
		parent::__construct();
		$this->load->model('normativas_model');
	}
	
	public function index(){
		$normativas = $this->normativas_model->obtener_todas();
		$this->load->view("includes/cabecera_view", array('titulo'=>"Normativas"));
		$this->load->view("includes/menu_view");
		$this->load->view("normativas/normativas_view",array('normativas'=>$normativas) );
		$this->load->view('includes/footer_view');
	}

	function eliminar($nombre_archivo){
		if($this->session->userdata('logged_in')){
			$this->normativas_model->eliminar_archivo($nombre_archivo);
			redirect('/normativas');
		}
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */