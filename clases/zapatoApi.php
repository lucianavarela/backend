<?php
require_once 'zapato.php';
require_once 'IApiUsable.php';
class zapatoApi extends Zapato implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$zapatoObj=Zapato::TraerZapato($id);
		$newResponse = $response->withJson($zapatoObj, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$zapatos=Zapato::TraerZapatos();
		$newResponse = $response->withJson($zapatos, 200);  
		return $newResponse;
	}

	public function CargarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
        $zapato_nueva = new Zapato();
        $zapato_nueva->codigo = $ArrayDeParametros['codigo'];
        $zapato_nueva->nombre = $ArrayDeParametros['nombre'];
        $zapato_nueva->localVenta = $ArrayDeParametros['localVenta'];
        $zapato_nueva->genero = $ArrayDeParametros['genero'];
        $zapato_nueva->precioCosto = $ArrayDeParametros['precioCosto'];
        $zapato_nueva->GuardarZapato();
        $objDelaRespuesta = array(
            'mensaje'=>'Se guardo el zapato',
            'status'=>'OK'
        );
		
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function BorrarUno($request, $response, $args) {
        $zapato = Zapato::TraerZapato($args['id']);
		$cantidadDeBorrados=$zapato->BorrarZapato();
		
		$objDelaRespuesta= new stdclass();
		if($cantidadDeBorrados>0) {
			$objDelaRespuesta = array(
                'mensaje'=>'Zapato eliminado',
                'status'=>'OK'
            );
		} else {
			$objDelaRespuesta = array(
                'mensaje'=>'Error eliminando el zapato',
                'status'=>'ERROR'
            );
		}
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$mizapato=Zapato::TraerZapato($args['id']);
		if ($mizapato) {
			$mizapato->codigo=$ArrayDeParametros['codigo'];
			$mizapato->localVenta=$ArrayDeParametros['localVenta'];
			$mizapato->genero=$ArrayDeParametros['genero'];
			$mizapato->nombre = $ArrayDeParametros['nombre'];
			$mizapato->precioCosto = $ArrayDeParametros['precioCosto'];
			$mizapato->fechaIngreso = $ArrayDeParametros['fechaIngreso'];
			$mizapato->GuardarZapato();
			$objDelaRespuesta = array(
                'mensaje'=>'Zapato modificado',
                'status'=>'OK'
            );
		} else {
			$objDelaRespuesta = array(
                'mensaje'=>'Codigo de zapato inexistente',
                'status'=>'ERROR'
            );
		}
		return $response->withJson($objDelaRespuesta, 200);
	}
}