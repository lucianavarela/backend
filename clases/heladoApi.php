<?php
require_once 'helado.php';
require_once 'IApiUsable.php';
class heladoApi extends Helado implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$helados_filtrados = Helado::TraerHelado($id);
		$newResponse = $response->withJson($helados_filtrados, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$helados = Helado::TraerHelados();
		$newResponse = $response->withJson($helados, 200);  
		return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$mihelado = new Helado();
		$mihelado->sabor=$request->getAttribute('jugador')->id;
		$mihelado->tipo=$ArrayDeParametros['tipo'];
		$mihelado->kilos=$ArrayDeParametros['kilos'];
		$mihelado->foto=$ArrayDeParametros['foto'];
		$mihelado->InsertarHelado();
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="Se ha ingresado el helado";
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function BorrarUno($request, $response, $args) {
		$id=$args['id'];
		$helado= new Helado();
		$helado->id=$id;
		$cantidadDeBorrados=$helado->BorrarHelado();
		$objDelaRespuesta= new stdclass();
		if($cantidadDeBorrados>0) {
			$objDelaRespuesta->respuesta="Helado eliminado";
			return $response->withJson($objDelaRespuesta, 200);
		} else {
			$objDelaRespuesta->respuesta="Error eliminando el helado";
			return $response->withJson($objDelaRespuesta, 400);
		}
	}
		
	public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$mihelado = new Helado();
		$mihelado->id = $args['id'];
		$mihelado->sabor=$ArrayDeParametros['sabor'];
		$mihelado->tipo=$ArrayDeParametros['tipo'];
		$mihelado->kilos=$ArrayDeParametros['kilos'];
		$mihelado->foto=$ArrayDeParametros['foto'];
		$mihelado->GuardarHelado();
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="Helado cargado";
		return $response->withJson($objDelaRespuesta, 200);	
	}
}