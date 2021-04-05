<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publicar extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in')){
			
			$this->load->model("usuarios_model");
			$this->load->model("anuncios_model");
			$this->load->model("examenes_model");
			$this->load->model("normativas_model");
			$this->load->helper("funciones");	
		}else{
			redirect('login');	
		}
		

	}
	
	public function index(){
		//obtengo una lista de todos los usuarios del sistema
		$usuarios = $this->usuarios_model->obtener_todos();
		//obtengo todos los usuarios
		$anuncios = $this->anuncios_model->obtener_todos();

		$data = array('anuncios'=>json_encode($anuncios),"usuarios"=>$usuarios);
		$this->load->view("includes/cabecera_view", array('titulo'=>"Publicar"));
		$this->load->view("includes/botonera_view");
		$this->load->view("publicar/publicar_view",$data);
		
	
	}

	public function examenes(){
		$data = array('examenes'=>$this->examenes_model->get_examenes(),'aulas'=>$this->examenes_model->get_aulas());
		$this->load->view("includes/cabecera_view", array('titulo'=>"Examenes"));
		$this->load->view("includes/botonera_view");
		$this->load->view("publicar/publicar_examenes_view",$data);
	}

	public function normativas(){
		$this->load->view("includes/cabecera_view", array('titulo'=>"Normativas"));
		$this->load->view("includes/botonera_view");
		$this->load->view("publicar/publicar_normativas_view");
	}

	public function guardar_turno(){
		if($this->input->post()){
			$this->examenes_model->guardar_turno($this->input->post());
		}
		redirect("publicar/examenes");
	}

	function guardar_normativa(){
		if($this->input->post()){
			$datos = $this->normativas_model->guardar_normativa($this->input->post());
			if($datos['error']){
				$datos['notificacion'] = $datos['error'];
				$datos['post'] = $this->input->post();
			}else{
				$datos['notificacion'] = "Guardado con &eacute;xito!";
				$this->load->view("includes/cabecera_view", array('titulo'=>"Normativas"));
				$this->load->view("includes/botonera_view");
				$this->load->view("publicar/publicar_normativas_view",$datos);
			}
		}
		
	}

	public function eliminar(){
		if($this->anuncios_model->eliminar_anuncio ($this->input->post('id_anuncio'))){
			echo json_encode(array("exito",TRUE));
		}else{
			echo json_encode(array("exito",FALSE));
		}
	}

	public function guardar(){
		$id_anuncio = ($this->input->post('id_anuncio')) ? $this->input->post('id_anuncio') : NULL;
		if($this->anuncios_model->guardar_anuncio($this->input->post('titulo'), str_replace("<p>&nbsp;<\/p>","",$this->input->post('editor1')), $this->session->userdata("id_usuario"),$this->input->post('carrera'),$id_anuncio)){
			redirect("publicar/");
		}
	}

	public function subir_archivo(){
		//echo json_encode(array("resultado",$_FILES['userfile']));

		$config['upload_path'] = './assets/pdfs/temp/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|bmp';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload() ){
			echo json_encode(array('resultado' => $this->upload->display_errors()));
		}else{
			echo json_encode(array('resultado' => $this->upload->data()));
		}
	}

	function borrar_listas_inscriptos(){
		$this->examenes_model->borrar_listas_inscriptos(); 
	}

	
}

/* End of file publicar.php */
/* Location: ./application/controllers/publicar.php */