<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Normativas extends CI_Controller {

	private $cant_visitas;
	

	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Anuncios FCA"));
		$this->load->view("includes/menu_view");
		$this->load->view("normativas/normativas_view");
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */