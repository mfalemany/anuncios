<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	private $archivo_log = "assets/fake_bd/log.txt";
	private $archivo_usuarios = "assets/fake_bd/usuarios.json";  
	
	function __construct(){
		parent::__construct();
	}

	public function registrar_visita(){
		$puntero = fopen($this->archivo_log,"a+");
		fwrite($puntero, date('Y-m-d').";".$_SERVER['REMOTE_ADDR']."#");
		fclose($puntero);
	}

	public function obtener_todos(){

		$registros = json_decode(file_get_contents($this->archivo_usuarios));
		$usuarios = array();
		foreach ($registros as $key => $usuario) {
			$usuarios[$usuario->id_usuario] = array("usuario"=>$usuario->usuario,
													"clave"=>$usuario->clave,
													"nombre_pila"=>$usuario->nombre_pila);
			
		}
		return $usuarios;
	}

	public function es_valido($user,$pass){
		$registros = json_decode(file_get_contents($this->archivo_usuarios));
		$encontrado = array();
		foreach ($registros as $key => $usuario) {
			if($usuario->usuario == $user and $usuario->clave == sha1($pass)){
				$encontrado = array("id_usuario"=>$usuario->id_usuario,
						   		"usuario"=>$usuario->usuario,
								"nombre_pila"=>$usuario->nombre_pila);	
				break;
			}
		}
		return $encontrado;
	}
	

	
}

/* End of file usuarios_model.php */
/* Location: ./application/models/usuarios_models.php */