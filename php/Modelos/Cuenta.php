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

		public function getAgnos($usuario){
			return $this ->get(
				array("Usuario" => $usuario),
				array("Agno" => 1, "_id" => 0)
			);
		}

		public function getMeses($usuario, $agno){
			return $this ->get(
				array(
					"Usuario" => $usuario,
					"Agno" => intval($agno)
				),
				array("Mes" => 1, "_id" => 0)
			);
		}

		public function getSumaEgresos($id){
			return $this -> col -> aggregate(
				array('$match' => array('_id' => $id)),
				array('$unwind' => '$Egresos'),
				array('$group' => array(
						"_id" => null,
						"suma" => array(
							'$sum' => '$Egresos.Monto'
						)
					)
				)
			);
		}

		public function getSumaIngresos($id){
			return $this -> col -> aggregate(
				array('$match' => array('_id' => $id)),
				array('$unwind' => '$Ingresos'),
				array('$group' => array(
						"_id" => null,
						"suma" => array(
							'$sum' => '$Ingresos.Monto'
						)
					)
				)
			);
		}

		public function getCuenta($usuario, $mes, $agno, $check = false){
			if (!$check) {
				$meses = array(
					"January"=>"Enero", 
					"February"=>"Febrero", 
					"March"=>"Marzo",
					"April"=>"Abril", 
					"May"=>"Mayo", 
					"June"=>"Junio", 
					"July"=>"Julio", 
					"August"=>"Agosto", 
					"September"=>"Septiembre", 
					"October"=>"October",
					"November"=>"Noviembre", 
					"December"=>"Diciembre", 
				);
				return $this->getOne(
					array(
						"Usuario" => $usuario,
						"Mes" => $meses[$mes],
						"Agno" => intval($agno)
					)
				);
			}else{
				return $this->getOne(
					array(
						"Usuario" => $usuario,
						"Mes" => $mes,
						"Agno" => intval($agno)
					)
				);
			}
		}

		public function putCuenta($usuario, $mes, $agno, $monto){
			try {
				$existe = $this->getOne(array("Usuario" => $usuario,"Mes" => $mes,"Agno" => $agno));
				if (empty($existe)) {
					$this->insert(
						array(
							"Usuario" => $usuario, 
							"Mes" => $mes,
							"Agno" => intval($agno),
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