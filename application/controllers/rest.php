<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rest extends CI_Controller {

	private $url_assets;

	function __construct(){
		parent::__construct();
		$this->load->model("usuarios_model");
		$this->load->model("anuncios_model");
		$this->url_assets = base_url('/assets/fake_bd/');
		header('Access-Control-Allow-Methods: GET');
	}

	function index(){
		$this->responder(json_decode($this->get_archivo_json('publicaciones')));
		echo "Endpoints disponibles: <br>";
		$clase = get_class($this);
		foreach(get_class_methods($clase) as $metodo){
			if( ! in_array($metodo, array(__FUNCTION__, '__construct', 'get_instance'))){
				echo $metodo."<br>";
			}
		} ;
		
	}
	private function responder($body,$status = 'HTTP/1.1 200 OK', $content_type = 'application/json'){
		header($status);
		if(strpos('200 OK',$status) < 0){
			header('Content-type: text/html');
			die($body);
		}
		header("Content-type: $content_type; charset=utf-8");
		echo  json_encode($body); die;
		echo (strtolower($content_type) == 'application/json') ? json_encode($body) : $body;
	}

	private function get_archivo_json($archivo,$ruta = NULL){
		$ruta = $ruta ? $ruta : $this->url_assets;
		$contenido = file_get_contents("$ruta/$archivo.json");

		if($contenido === FALSE){
			$this->responder("Ocurrió un error al intentar obtener el archivo '$archivo'.",$http_response_header[0],substr($http_response_header[0],9,3),'text/html');
		}
		return $contenido;
	}

	function anuncios(){
		$anuncios = $this->get_archivo_json('publicaciones');
		//Se hace un json_decode porque en la función responder se codifica automáticamente.
		$this->responder(json_decode($anuncios));
	}

	function cantidad_anuncios(){
		$cantidad = count(json_decode($this->get_archivo_json('publicaciones')));
		$this->responder($cantidad,200,'text/html');
	}

	function turno_examen(){
		$turno = $this->get_archivo_json('turno_examenes');
		$this->responder(json_decode($turno));
	}

	function exigir_autenticacion(){
		// ============= VERIFICACIÓN AUTENTICACIÓN ===================================
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="Publicar"');
			$this->responder('No autorizado','HTTP/1.1 401 Unauthorized','text/html');
		}else {
			if( ! $this->usuarios_model->es_valido($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
				$this->responder('Credenciales no válidas','HTTP/1.1 401 Unauthorized','text/html');
			}
		}
		// ============================================================================
	}

	/* HAY QUE MEJORAR ESTO */
	//Se usa para publicar anuncios desde otros sitemas: Aulario
	function publicar(){
		header('Access-Control-Allow-Methods: POST');
		//header("Access-Control-Allow-Origin: *");

		$this->exigir_autenticacion();
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			//error_reporting(0);
			//ini_set('display_errors', 0);
			$params_recibidos = file_get_contents('php://input');
			$params = json_decode($params_recibidos,TRUE);


			if(json_last_error() != 0){
				$this->responder('JSON recibido mal formado. json_last_error: '.json_last_error().". Recibido: $params_recibidos",'HTTP/1.1 400 Bad Request','text/html');
			}
			
			if(isset($params['titulo']) && strlen($params['titulo']) > 0){
				$titulo = $params['titulo'];
			}else{
				$this->responder('No se recibió un título para la publicación','HTTP/1.1 400 Bad Request','text/html');
			}

			if(isset($params['cuerpo']) && strlen($params['cuerpo']) > 0){
				$cuerpo = nl2br($params['cuerpo']);
			}else{
				$this->responder('No se recibió un cuerpo para la publicación','HTTP/1.1 400 Bad Request','text/html');
			}
			$carrera = (isset($params['carrera']) && strlen($params['carrera']) > 0) ? $params['carrera'] : 'todas';

			if($this->anuncios_model->guardar_anuncio($titulo, $cuerpo, $params['usuario'], $carrera)){
				
				$this->responder('Publicado con exito','HTTP/1.1 200 OK','text/html');
			}else{
				$this->responder('Ocurrió un error al intentar guardar el anuncio','HTTP/1.1 200 OK','text/html');	
			}
		}
	}


	//Wrapper para la API de guarani2. Se debe estár logueado.
	function wrapper($metodo,$parametros){
		//Decodifico la URL y genero un array de parámetros
		$parametros = rawurldecode($parametros);
		$parametros = explode('||',$parametros);
		$url = "/$metodo";
		foreach ($parametros as $parametro) {
			$url .= "/".rawurlencode($parametro);
		}
		get_rest($url);

	}

	/**
	 * Establece la solicitud y devuelve la respuesta (Utiliza file_get_contents)
	 */
/*	private function get($url){
		//La URL a la que se realizará la llamada
		$url = URL_BASE_GUARANI_REST.$url;
		
		//Se setea el manejador de errores
		set_error_handler(array($this,'manejador_errores'));
		//se reduce el tiempo de espera (nunca deber? tardar mas de este tiempo)
		ini_set('default_socket_timeout', 10);
		//ini_set('display_errors','0');
		$respuesta = file_get_contents($url);
		restore_error_handler();

		//La variable $http_response_header[0] contiene las cabeceras de la lectura hecha por file_get_contents. Si se recibe OK, se manda la respuesta, sino, la cabecera recibida
		if(strpos($http_response_header[0], 'OK') >= 0){
			echo $respuesta;
		}
	}*/



}

