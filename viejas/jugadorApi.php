<?php
require_once 'jugador.php';
require_once 'IApiUsable.php';
class jugadorApi extends Jugador implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$jugadorObj = Jugador::TraerJugador($id);
		$newResponse = $response->withJson($jugadorObj, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$jugadores = Jugador::TraerJugadores();
		$newResponse = $response->withJson($jugadores, 200);  
		return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
		try {
			$ArrayDeParametros = $request->getParsedBody();
			$mijugador = new Jugador();
			$mijugador->usuario=$ArrayDeParametros['usuario'];
			$mijugador->clave=$ArrayDeParametros['clave'];
			$mijugador->nombre=$ArrayDeParametros['nombre'];
			$mijugador->InsertarJugador();
			$objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta="Se ha ingresado el jugador";
			return $response->withJson($objDelaRespuesta, 200);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}

	public function BorrarUno($request, $response, $args) {
		try {
			$id=$args['id'];
			$jugador= new Jugador();
			$jugador->id=$id;
			$cantidadDeBorrados=$jugador->BorrarJugador();
			$objDelaRespuesta= new stdclass();
			if($cantidadDeBorrados>0) {
				$objDelaRespuesta->respuesta="Jugador eliminado";
				return $response->withJson($objDelaRespuesta, 200);
			} else {
				$objDelaRespuesta->respuesta="Error eliminando el jugador";
				return $response->withJson($objDelaRespuesta, 400);
			}
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}
		
	public function ModificarUno($request, $response, $args) {
		try {
			$ArrayDeParametros = $request->getParsedBody();
			$mijugador = new Jugador();
			$mijugador->id = $args['id'];
			$mijugador->usuario=$ArrayDeParametros['usuario'];
			$mijugador->clave=$ArrayDeParametros['clave'];
			$mijugador->nombre=$ArrayDeParametros['nombre'];
			$mijugador->GuardarJugador();
			$objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta="Jugador cargado";
			return $response->withJson($objDelaRespuesta, 200);
		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	}
}