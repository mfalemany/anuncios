<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuarios{
	static $archivo_usuarios = "assets/fake_bd/usuarios.txt";
	static $puntero_usuarios;
	public $error;
/*
 * Formato de tabla USUARIOS: id_usuario###usuario###clave###nombre_pila %% id_usuario###usuario###clave###nombre_pila
*/
	function __construct(){
		//lee el archivo especificado en 'archivo_usuarios' y guarda un puntero al mismo en puntero_usuarios
		
	}	


	public function obtener_usuario($id_usuario){
		self::$puntero_usuarios = fopen(self::$archivo_usuarios,'a+');	
		$usuario = array();
		if($contenido = file_get_contents(self::$archivo_usuarios)){
			$registros = explode("%%",$contenido);	

			foreach($registros as $registro){
				$campos = explode("###",$registro);
				
				if($campos[0] == $id_usuario){
					$usuario = array(
						'id_usuario'=>$campos[0],
						'usuario'=>$campos[1],
						'clave'=>$campos[2],
						'nombre_pila'=>$campos[3]
					);
				}
			}	
		}
	

		return $usuario; //aca se devuelve vacio o lleno, segun si se cumplio el IF
	}

	public function es_valido($usuario, $clave){
		self::$puntero_usuarios = fopen(self::$archivo_usuarios,'a+');	
		$encontrado = array();
		if($contenido = file_get_contents(self::$archivo_usuarios)){
			$registros = explode("%%",$contenido);	

			foreach($registros as $registro){
				$campos = explode("###",$registro);
				
				if(@strtolower($campos[1]) == strtolower(str_replace(" ","",$usuario))){
					if (sha1($clave) == @$campos[2]) {
							$encontrado = array(
							'id_usuario'=>$campos[0],
							'usuario'=>$usuario,
							'nombre_pila'=>$campos[3]
						);	
					}
					
				}
			}	
		}

		return $encontrado; //aca se devuelve vacio o lleno, segun si se cumplio el IF
	}

	public function cambiar_clave($clave_actual,$clave_nueva,$id_usuario){
		
		$this->error = "";
		self::$puntero_usuarios = fopen(self::$archivo_usuarios,'a+');	
		if($contenido = file_get_contents(self::$archivo_usuarios)){
			$registros = explode("%%",$contenido);	

			//trunco el archivo a cero para volver a escribirlo
			self::$puntero_usuarios = fopen(self::$archivo_usuarios,'w');
			
			foreach($registros as $registro){
				if(strlen(trim(str_replace(" ", "", $registro))) > 0){
					
					$campos = explode("###",$registro);
					
					//si es el usuario que estoy buscando
					if($campos[0] == $id_usuario){
						//y si coincide la clave actual ingresada
						if($campos[2] == sha1($clave_actual)){
							//echo "coincide la clave<br>";
							$registro_modificado = $campos[0]."###".$campos[1]."###".sha1($clave_nueva)."###".$campos[3]."%%"; 
							fwrite(self::$puntero_usuarios,$registro_modificado);										
						}else{
							// No se pudo actualizar la clave, entonces guardo el registro como estaba
							$registro_sin_modificar = $campos[0]."###".$campos[1]."###".$campos[2]."###".$campos[3]."%%"; 
							fwrite(self::$puntero_usuarios,$registro_sin_modificar);	
							//pero registro cual fue el error
							$this->error = "Las clave actual ingresada es incorrecta!";
						}
					}else{
						//echo "NO coincide el usuario<br>";
						$registro_sin_modificar = $campos[0]."###".$campos[1]."###".$campos[2]."###".$campos[3]."%%"; 
						fwrite(self::$puntero_usuarios,$registro_sin_modificar);	
					}
				}
			}
			
		}
		if(strlen($this->error) > 0){
			return FALSE;
		}else{
			return TRUE;
		}
		
	}

}
/* End of file usuarios.php */
/* Location: ./application/libraries/usuarios.php */
