<?php
	class Cuenta extends MongoHandler{

		public function __construct(){
			$this->conectar();
			$this->setCollections("Cuentas");
		}

		public function putIngreso($id, $usuario, $fecha, $monto, $detalle){
			try{
				$valores = array(
					"Fecha" => $fecha,
					"Monto" => intval($monto),
					"Detalle" => $detalle
				);
				$this -> update(
					array("Usuario" => $usuario), 
					array('$addToSet' => array("Ingresos" => $valores))
				);
				return array("Mensaje" => "Ingreso Agregado!", 
						"Detalle" => ":) ", "Tiempo" => 2000);
			}catch(Exception $e){
				throw new RuntimeException("Error al Agregar Ingreso: $e");
			}
		}

		public function putEgreso($id, $usuario, $fecha, $monto, $detalle){
			try{
				$valores = array(
					"Fecha" => $fecha,
					"Monto" => intval($monto),
					"Detalle" => $detalle
				);
				$this -> update(
					array("Usuario" => $usuario), 
					array('$addToSet' => array("Egresos" => $valores))
				);
				return array("Mensaje" => "Egreso Agregado!", 
						"Detalle" => ":) ", "Tiempo" => 2000);
			}catch(Exception $e){
				throw new RuntimeException("Error al Agregar Ingreso: $e");
			}
		}

		public function getCuenta($usuario, $mes, $agno){
			$meses = array("January" => "Enero");
			return $this->getOne(
				array(
					"Usuario" => $usuario,
					"Mes" => $meses[$mes],
					"Agno" => $agno
				)
			);
		}

		public function putCuenta($usuario, $mes, $agno, $monto){
			try {
				$existe = $this->getOne(array("Usuario" => $usuario,"Mes" => $mes,"Agno" => $agno));
				if (empty($existe)) {
					$this->insert(
						array(
							"Usuario" => $usuario, 
							"Mes" => $mes,
							"Agno" => $agno,
							"Monto" => intval($monto),
							"Ingresos" => array(),
							"Egresos" => array()
						)
					);
					$this -> col -> ensureIndex(array("Usuario" => 1));
					return array("Mensaje" => "Mes Abierto!", 
						"Detalle" => "Ahora puedes agregar detalles de ingresos o salidas al mes :) ", "Tiempo" => 2000);
				}else{
					return array("Mensaje" => "Mes Abierto!", 
						"Detalle" => "El Mes ya se encuentra Abierto. ", "Tiempo" => 3000);
				}
			} catch (Exception $e) {
				throw new RuntimeException("Error al Abrir Mes: $e");
			}
		}
	}
?>