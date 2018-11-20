<?php
require_once 'venta.php';
require_once 'IApiUsable.php';
class ventaApi extends Venta implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$ventaObj=Venta::TraerVenta($id);
		$newResponse = $response->withJson($ventaObj, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$ventas=Venta::TraerVentas();
		$newResponse = $response->withJson($ventas, 200);  
		return $newResponse;
	}

	public function CargarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$usuario = $request->getAttribute('usuario');
		if ($usuario) {
			$venta_nueva = new Venta();
			$venta_nueva->tipo = $ArrayDeParametros['tipo'];
			$venta_nueva->idUsuario = $usuario->id;
			$venta_nueva->nombreServicio = $ArrayDeParametros['nombreServicio'];
			$venta_nueva->mbServicio = $ArrayDeParametros['mbServicio'];
			$venta_nueva->importe = $ArrayDeParametros['importe'];
			$venta_nueva->GuardarVenta();
			$objDelaRespuesta = array(
				'mensaje'=>'Se guardo el venta',
				'status'=>'OK'
			);
		} else {
			$objDelaRespuesta = array(
				'mensaje'=>'Error, no logueado.',
				'status'=>'ERROR'
			);
		}
		
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function BorrarUno($request, $response, $args) {
        $venta = Venta::TraerVenta($args['id']);
		$cantidadDeBorrados=$venta->BorrarVenta();
		
		$objDelaRespuesta= new stdclass();
		if($cantidadDeBorrados>0) {
			$objDelaRespuesta = array(
                'mensaje'=>'Venta eliminado',
                'status'=>'OK'
            );
		} else {
			$objDelaRespuesta = array(
                'mensaje'=>'Error eliminando el venta',
                'status'=>'ERROR'
            );
		}
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miventa=Venta::TraerVenta($args['id']);
		if ($miventa) {
			$miventa->tipo=$ArrayDeParametros['tipo'];
			$miventa->nombreServicio=$ArrayDeParametros['nombreServicio'];
			$miventa->mbServicio=$ArrayDeParametros['mbServicio'];
			$miventa->idUsuario = $ArrayDeParametros['idUsuario'];
			$miventa->importe = $ArrayDeParametros['importe'];
			$miventa->fecha = $ArrayDeParametros['fecha'];
			$miventa->GuardarVenta();
			$objDelaRespuesta = array(
                'mensaje'=>'Venta modificado',
                'status'=>'OK'
            );
		} else {
			$objDelaRespuesta = array(
                'mensaje'=>'Codigo de venta inexistente',
                'status'=>'ERROR'
            );
		}
		return $response->withJson($objDelaRespuesta, 200);
	}
}