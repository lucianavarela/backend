<?php
require_once 'vehiculo.php';
require_once 'IApiUsable.php';
class vehiculoApi extends Vehiculo implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$vehiculo = Vehiculo::TraerVehiculo($id);
		$newResponse = $response->withJson($vehiculo, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$vehiculos = Vehiculo::TraerVehiculos();
		$newResponse = $response->withJson($vehiculos, 200);  
		return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
		try {
			$ArrayDeParametros = $request->getParsedBody();
			$mivehiculo = new Vehiculo();
			$mivehiculo->modelo=$ArrayDeParametros['modelo'];
			$mivehiculo->marca=$ArrayDeParametros['marca'];
			$mivehiculo->cantidadPuertas=$ArrayDeParametros['cantidadPuertas'];
			$mivehiculo->rutaDeFoto=$ArrayDeParametros['rutaDeFoto'];
			$mivehiculo->InsertarVehiculo();
			$objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta="Se ha ingresado el vehiculo";
			return $response->withJson($objDelaRespuesta, 200);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}

	public function BorrarUno($request, $response, $args) {
		try {
			$id=$args['id'];
			$vehiculo= new Vehiculo();
			$vehiculo->id=$id;
			$cantidadDeBorrados=$vehiculo->BorrarVehiculo();
			$objDelaRespuesta= new stdclass();
			if($cantidadDeBorrados>0) {
				$objDelaRespuesta->respuesta="Vehiculo eliminado";
				return $response->withJson($objDelaRespuesta, 200);
			} else {
				$objDelaRespuesta->respuesta="Error eliminando el vehiculo";
				return $response->withJson($objDelaRespuesta, 400);
			}
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}
		
	public function ModificarUno($request, $response, $args) {
		try {
			$ArrayDeParametros = $request->getParsedBody();
			$mivehiculo = new Vehiculo();
			$mivehiculo->id = $args['id'];
			$mivehiculo->modelo=$ArrayDeParametros['modelo'];
			$mivehiculo->marca=$ArrayDeParametros['marca'];
			$mivehiculo->cantidadPuertas=$ArrayDeParametros['cantidadPuertas'];
			$mivehiculo->rutaDeFoto=$ArrayDeParametros['rutaDeFoto'];
			$mivehiculo->GuardarVehiculo();
			$objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta="Vehiculo cargado";
			return $response->withJson($objDelaRespuesta, 200);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}
}