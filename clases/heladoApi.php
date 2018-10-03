<?php
require_once 'resultado.php';
require_once 'IApiUsable.php';
class resultadoApi extends Helado implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$resultados_filtrados = Helado::TraerHelado($id);
		$newResponse = $response->withJson($resultados_filtrados, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$resultados = Helado::TraerHelados();
		$newResponse = $response->withJson($resultados, 200);  
		return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miresultado = new Helado();
		$miresultado->sabor=$request->getAttribute('jugador')->id;
		$miresultado->tipo=$ArrayDeParametros['tipo'];
		$miresultado->kilos=$ArrayDeParametros['kilos'];
		$miresultado->foto=$ArrayDeParametros['foto'];
		$miresultado->InsertarHelado();
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="Se ha ingresado el resultado";
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function BorrarUno($request, $response, $args) {
		$id=$args['id'];
		$resultado= new Helado();
		$resultado->id=$id;
		$cantidadDeBorrados=$resultado->BorrarHelado();
		$objDelaRespuesta= new stdclass();
		if($cantidadDeBorrados>0) {
			$objDelaRespuesta->respuesta="Helado eliminado";
			return $response->withJson($objDelaRespuesta, 200);
		} else {
			$objDelaRespuesta->respuesta="Error eliminando el resultado";
			return $response->withJson($objDelaRespuesta, 400);
		}
	}
		
	public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miresultado = new Helado();
		$miresultado->id = $args['id'];
		$miresultado->sabor=$ArrayDeParametros['sabor'];
		$miresultado->tipo=$ArrayDeParametros['tipo'];
		$miresultado->kilos=$ArrayDeParametros['kilos'];
		$miresultado->foto=$ArrayDeParametros['foto'];
		$miresultado->GuardarHelado();
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="Helado cargado";
		return $response->withJson($objDelaRespuesta, 200);	
	}
}