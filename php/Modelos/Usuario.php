<?php
	class Usuario extends MongoHandler{
			
		private $Nombre, $Mail, $Pass, $Preferencias;
		
		public function __construct($nombre, $mail, $pass){
			$this->Mail = $mail;
			$this->Nombre = $nombre;
			$this->Pass = $pass;
			$this->conectar();
			$this->setCollections("Usuarios");
		}
		
		public function getLogin(){ return $this->Login(); }
		private function Login(){
			try{
				$existe = $this->getOne(array("Mail" => $this->Mail));
				if(empty($existe)){
					return array("Mensaje" => "Usuario No Existe!", 
						"Detalle" => "Comprueba el correo... escribiste bien ?", "Tiempo" => 3000);
				}else{
					if($existe["Pass"] == md5($this->Pass)){
						$_SESSION["Usuario"] = $existe["Nombre"];
						$_SESSION["Mail"] = $existe["Mail"];
						return array("Mensaje" => "Redirigiendo", "Detalle" => "", "Tiempo" => 2000);
					}else{
						return array("Mensaje" => "Pass Incorrecta", "Detalle" => "Escribe bien...", "Tiempo" => 2000);
					}
				}
			}catch(Exception $e){
				throw new RuntimeException("Error al Iniciar Sesi&oacute;n: $e");
			}
		}
		
		public function putGuardar(){ return $this->Guardar(); }
		private function Guardar(){
			try{
				$existe = $this->getOne(array("Mail" => $this->Mail));
				if (empty($existe)) {
					$this->insert(
						array(
							"Mail" => $this->Mail,
							"Nombre" => $this->Nombre,
							"Pass" => md5($this->Pass)
						)
					);
					$this->col->ensureIndex(array("Mail" => 1), array("unique" => TRUE));
					$this->col->ensureIndex(array("Nombre" => 1), array("unique" => TRUE));
					return array("Mensaje" => "Usuario Registrado!", 
						"Detalle" => "Ahora puedes hacer uso de todos los beneficios :) ", "Tiempo" => 2000);
				} else {
					return array("Mensaje" => "Mail Existe!", 
						"Detalle" => "El mail ingresado ya se encuentra en uso :( ", "Tiempo" => 3000);
				}
			}catch(Exception $e){
				throw new RuntimeException("Error al Registrar Usuario: $e");
			}
		}
	}
?>