<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';
class usuarioApi extends Usuario implements IApiUsable
{
	public function TraerUno($request, $response, $args) {
		$id=$args['id'];
		$usuarioObj = Usuario::TraerUsuario($id);
		$newResponse = $response->withJson($usuarioObj, 200);  
		return $newResponse;
	}

	public function TraerTodos($request, $response, $args) {
		$usuarios = Usuario::TraerUsuarios();
		$newResponse = $response->withJson($usuarios, 200);  
		return $newResponse;
	}
	
	public function TraerMetricas($request, $response, $args) {
		$metricas = Usuario::Analytics();
		$newResponse = $response->withJson($metricas, 200);  
		return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miusuario = new Usuario();
		$miusuario->mail=$ArrayDeParametros['mail'];
		$miusuario->clave=$ArrayDeParametros['clave'];
		$miusuario->perfil=$ArrayDeParametros['perfil'];
		$miusuario->sueldo=$ArrayDeParametros['sueldo'];
		$miusuario->nombre=$ArrayDeParametros['nombre'];
		$miusuario->sexo=$ArrayDeParametros['sexo'];
		$miusuario->InsertarUsuario();
		$objDelaRespuesta = array(
			'mensaje'=>"Se ha ingresado el usuario",
			'status'=>'OK'
		);
		return $response->withJson($objDelaRespuesta, 200);
	}

	public function BorrarUno($request, $response, $args) {
		$id=$args['id'];
		$usuario= new Usuario();
		$usuario->id=$id;
		$cantidadDeBorrados=$usuario->BorrarUsuario();
		$objDelaRespuesta= new stdclass();
		if($cantidadDeBorrados>0) {
			$objDelaRespuesta = array(
				'mensaje'=>"Usuario eliminado.",
				'status'=>'OK'
			);
		} else {
			$objDelaRespuesta = array(
				'mensaje'=>"Error eliminando el usuario.",
				'status'=>'ERROR'
			);
		}
		return $response->withJson($objDelaRespuesta, 200);
	}
		
	public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
		$miusuario = new Usuario();
		$miusuario->id = $args['id'];
		$miusuario->mail=$ArrayDeParametros['mail'];
		$miusuario->clave=$ArrayDeParametros['clave'];
		$miusuario->perfil=$ArrayDeParametros['perfil'];
		$miusuario->sueldo=$ArrayDeParametros['sueldo'];
		$miusuario->nombre=$ArrayDeParametros['nombre'];
		$miusuario->sexo=$ArrayDeParametros['sexo'];
		$miusuario->GuardarUsuario();
		$objDelaRespuesta = array(
			'mensaje'=>"Usuario modificado.",
			'status'=>'OK'
		);
		return $response->withJson($objDelaRespuesta, 200);	
	}
}