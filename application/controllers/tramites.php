<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tramites extends CI_Controller {
	
	private $cantidad_visitas;

	function __construct(){
		parent::__construct();
		$this->cant_visitas = cantidad_visitas();
	}
	
	public function index(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Guia de Tramites"));
		$this->load->view("includes/menu_view");
		$this->load->view("tramites/tramites_view");
		$this->load->view("includes/footer_view",array("cantidad_visitas"=>$this->cant_visitas['total'],'visitas_mes_actual'=>$this->cant_visitas['actual']));
	}
}

/* End of file tramites.php */
/* Location: ./application/controllers/tramites.php */