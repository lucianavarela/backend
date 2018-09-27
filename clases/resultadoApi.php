<?php
require_once 'resultado.php';
require_once 'IApiUsable.php';
class resultadoApi extends Resultado implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$juego=$args['juego'];
		$resultados_filtrados = Resultado::TraerFiltrados($juego);
		$newResponse = $response->withJson($resultados_filtrados, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$resultados = Resultado::TraerResultados();
		$newResponse = $response->withJson($resultados, 200);  
		return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miresultado = new Resultado();
		$miresultado->idUser=$request->getAttribute('jugador')->id;
		$miresultado->juego=$ArrayDeParametros['juego'];
		$miresultado->nivel=$ArrayDeParametros['nivel'];
		$miresultado->tiempo=$ArrayDeParametros['tiempo'];
		$miresultado->InsertarResultado();
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="Se ha ingresado el resultado";
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function BorrarUno($request, $response, $args) {
		$id=$args['id'];
		$resultado= new Resultado();
		$resultado->id=$id;
		$cantidadDeBorrados=$resultado->BorrarResultado();
		$objDelaRespuesta= new stdclass();
		if($cantidadDeBorrados>0) {
			$objDelaRespuesta->respuesta="Resultado eliminado";
			return $response->withJson($objDelaRespuesta, 200);
		} else {
			$objDelaRespuesta->respuesta="Error eliminando el resultado";
			return $response->withJson($objDelaRespuesta, 400);
		}
	}
		
	public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miresultado = new Resultado();
		$miresultado->id = $args['id'];
		$miresultado->idUser=$ArrayDeParametros['idUser'];
		$miresultado->juego=$ArrayDeParametros['juego'];
		$miresultado->nivel=$ArrayDeParametros['nivel'];
		$miresultado->tiempo=$ArrayDeParametros['tiempo'];
		$miresultado->GuardarResultado();
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="Resultado cargado";
		return $response->withJson($objDelaRespuesta, 200);	
	}
}