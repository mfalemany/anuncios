<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bolillero extends CI_Controller {
	function __construct(){
		parent::__construct();
		
	}

	function index(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Bolillero FCA"));
		$this->load->view('bolillero_view');
		
	}

}
