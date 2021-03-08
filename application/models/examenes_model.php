<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examenes_model extends CI_Model {
	private $archivo_aulas = "assets/fake_bd/aulas.json";
	private $archivo_examenes = "assets/fake_bd/turno_examenes.json";
	function __construct(){
		parent::__construct();
	}

	public function get_aulas(){
		$registros = json_decode(file_get_contents($this->archivo_aulas));

		$aulas = array();
		foreach ($registros as $key => $aula) {
			
			$aulas[$aula->id] = array(
							"nombre"=>$aula->nombre,
							"activo"=>$aula->activo,
							"capacidad"=>$aula->capacidad);
			
			
		}
		return $aulas;
	}

	public function get_examenes(){
		$aulas = $this->get_aulas();
		$examenes = json_decode(file_get_contents($this->archivo_examenes));
		foreach($examenes as &$turno_carrera){
			foreach ($turno_carrera->turno->mesas as $key => &$value) {
				if($value->activo == 1){
					$value->materia = utf8_decode($value->materia);
				}
			}	
		}
		return $examenes;
	}

	public function guardar_turno(){
		$publicado = $this->get_examenes();
		
		$turno = $this->input->post();
		foreach($publicado as &$carrera_turno){
			$carrera_turno->turno->detalles->nombre_turno = $turno['nombre_turno_'.$carrera_turno->codigo_carrera];
			$carrera_turno->turno->detalles->desde_turno = $turno['desde_turno_'.$carrera_turno->codigo_carrera];
			$carrera_turno->turno->detalles->hasta_turno = $turno['hasta_turno_'.$carrera_turno->codigo_carrera];
			$carrera_turno->turno->detalles->fecha_inicio_insc = $turno['inicio_insc_turno_'.$carrera_turno->codigo_carrera];	
			$carrera_turno->turno->detalles->turno = $turno['turno_'.$carrera_turno->codigo_carrera];	
			$carrera_turno->turno->detalles->llamado = $turno['llamado_'.$carrera_turno->codigo_carrera];	
		
			foreach ($carrera_turno->turno->mesas as $key => &$value) {
				$value->materia = utf8_encode($value->materia);
				$value->horario = $turno[$value->nombre_archivo."_horario"];
				$value->lugar = $turno[$value->nombre_archivo."_lugar"];
				$value->fecha_examen = $turno[$value->nombre_archivo."_fecha_examen"];
				$value->fecha_cierre = $turno[$value->nombre_archivo."_fecha_fin_insc"];
				$value->lugar = $turno[$value->nombre_archivo."_lugar"];
				if(array_key_exists($value->nombre_archivo."_modificado",$turno)){
					$value->modificado = "1";
				}else{
					$value->modificado = "0";
				}
				
			}
		}
		
		$archivo = fopen($this->archivo_examenes,'w+');
		fwrite($archivo, json_encode($publicado));
		fclose($archivo);

	}

	function borrar_listas_inscriptos(){
		$ruta = "./assets/pdfs/examenes/";
		$directorio = opendir($ruta);
		while($archivo = readdir($directorio)){
			if( ! is_dir($archivo) ){
				if($archivo != "." && $archivo != ".." && strtolower($archivo) != "index.php"){
					unlink($ruta . $archivo);
				}
			}
			
		}
	}
	

	
	

	
}

/* End of file examenes_model.php */
/* Location: ./application/models/examenes_models.php */