<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller {

	public $error;

	function __construct(){
		parent::__construct();
		$this->load->model("usuarios_model");
	}
	
	public function index(){
		if($this->session->userdata("logged_in")){
			redirect("publicar/");
		}
		$this->load->view("includes/cabecera_view", array('titulo'=>"Login"));
		$this->load->view("publicar/login_view");
	}

	public function login($usuario,$clave){
		$usuario = $this->usuarios_model->es_valido($usuario, $clave);
		if(count($usuario) > 0){
			$datos = array(
                   'id_usuario'  => $usuario['id_usuario'],
                   'username'  => $usuario['usuario'],
                   'nombre_pila'  => $usuario["nombre_pila"],
                   'logged_in' => TRUE
               );
				$this->session->set_userdata($datos);

			redirect("publicar");
		}else{
			$this->error = TRUE;
			$this->index();
			
		}
	}
	public function verifico_login(){
		$this->login($this->input->post('usuario'),$this->input->post('pass'));	
	}

	public function cerrar_sesion(){
		$this->session->sess_destroy();
		redirect('login/');
	}

	public function cambio_clave(){
		if(!$this->session->userdata("logged_in")){
			redirect("login/");
		}
		$this->load->view("includes/cabecera_view", array('titulo'=>"Cambio de Clave"));
		$this->load->view("publicar/cambio_clave_view",array('usuario'=>$this->session->userdata('nombre_pila')));
	
	}

	public function cambiar_clave(){
		if(!$this->session->userdata("logged_in")){
			redirect("login/");
		}
		$this->error = array();
		
		if(strlen(trim($this->input->post("actual"))) == 0){
			$this->error = array("descripcion"=>"El campo 'Clave Actual' se recibió vacío.");
		}
		if(strlen(trim($this->input->post("nueva"))) == 0){
			$this->error = array("descripcion"=>"El campo 'Clave Nueva' se recibió vacío.");
		}
		if(strlen(trim($this->input->post("rep_nueva"))) == 0){
			$this->error = array("descripcion"=>"El campo 'Repetir Clave' se recibió vacío.");
		}
		if($this->input->post("nueva") != $this->input->post("rep_nueva")){
			$this->error = array("descripcion"=>"Las claves introducidas no coinciden");
		}
		
		if(count($this->error) == 0){

			if($this->usuarios->cambiar_clave($this->input->post("actual"), $this->input->post("nueva"), $this->session->userdata('id_usuario'))){
				$this->cerrar_sesion();
			}else{
				$this->error = array("descripcion"=>$this->usuarios->error);
			}
		}
		$this->cambio_clave();

	}

	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */