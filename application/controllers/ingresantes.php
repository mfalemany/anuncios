<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingresantes extends CI_Controller {
	
	private $cantidad_visitas;

	function __construct(){
		parent::__construct();
		$this->cant_visitas = cantidad_visitas();
	}
	
	public function index(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Ingresantes"));
		$this->load->view("includes/menu_view");
		$this->load->view("ingresantes/ingresantes_view");
		$this->load->view("includes/footer_view",array("cantidad_visitas"=>$this->cant_visitas['total'],'visitas_mes_actual'=>$this->cant_visitas['actual']));
	}

	function insc_curs()
	{
		$this->load->view("includes/cabecera_view", array('titulo'=>"Instructivo"));
		$this->load->view("includes/menu_view");
		$this->load->view('ingresantes/instructivos/insc_curs.php');
	}
}

/* End of file ingresantes.php */
/* Location: ./application/controllers/ingresantes.php */