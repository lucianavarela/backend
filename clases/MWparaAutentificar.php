<?php
class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
	public function VerificarLogueado($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->esValido=false;
		if($request->isGet() || $request->isPost()) {
			$arrayConToken = $request->getHeader('HTTP_AUTHORIZATION');
			if($arrayConToken) {
				$token=$arrayConToken[0];
				try {
					AutentificadorJWT::VerificarToken($token);
					$objDelaRespuesta->esValido=true;
				} catch (Exception $e) {
					$objDelaRespuesta->excepcion=$e->getMessage();
					$objDelaRespuesta->esValido=false;
				}
			}
			if($objDelaRespuesta->esValido) {
				$payload=AutentificadorJWT::ObtenerData($token);
				$request = $request->withAttribute('usuario', $payload);
			}
            $response = $next($request, $response);
		} else {
            $arrayConToken = $request->getHeader('HTTP_AUTHORIZATION');
            $token=$arrayConToken[0];
            $objDelaRespuesta->esValido=true;
            
			try {
				AutentificadorJWT::VerificarToken($token);
				$objDelaRespuesta->esValido=true;
			} catch (Exception $e) {
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;
			}
			if($objDelaRespuesta->esValido) {
				$payload=AutentificadorJWT::ObtenerData($token);
				if($payload->perfil=="admin")
				{
					$response = $next($request, $response);
				}
				else
				{
					$objDelaRespuesta = array(
						'status'=>'ERROR',
						'mensaje'=>"Solo socios"
					);
					return $response->withJson($objDelaRespuesta, 200);
				}
			} else {
				$objDelaRespuesta = array(
					'status'=>'ERROR',
					'mensaje'=>"Solo usuarios registrados"
				);
				return $response->withJson($objDelaRespuesta, 200);
			}
		}

        return $response;
	}
	
	public function VerificarToken($request, $response, $next) {
        
		$objDelaRespuesta= new stdclass();
		$arrayConToken = $request->getHeader('HTTP_AUTHORIZATION');
		$token=$arrayConToken[0];
		$objDelaRespuesta->esValido=true;
		
		try {
			AutentificadorJWT::VerificarToken($token);
			$objDelaRespuesta->esValido=true;
		} catch (Exception $e) {
			$objDelaRespuesta->excepcion=$e->getMessage();
			$objDelaRespuesta->esValido=false;
		}
		if($objDelaRespuesta->esValido) {
			$payload=AutentificadorJWT::ObtenerData($token);
			$request = $request->withAttribute('usuario', $payload);
			$response = $next($request, $response);
		} else {
			$objDelaRespuesta = array(
				'status'=>'ERROR',
				'mensaje'=>"Por favor logueese para realizar esta accion."
			);
			return $response->withJson($objDelaRespuesta, 200);
		}

        return $response;
	}

	public function VerificarAdmin($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$perfil = $request->getAttribute('usuario')->perfil;
		if($perfil == "admin") {
			$response = $next($request, $response);
		}
		else
		{
			$objDelaRespuesta = array(
				'status'=>'ERROR',
				'mensaje'=>"Solo socios."
			);
			return $response->withJson($objDelaRespuesta, 200);
		}
        
        return $response;
	}

	public function VerificarUsuario($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$perfil = $request->getAttribute('usuario')->perfil;
		if($perfil == "barra" || $perfil == "cerveza" || $perfil == "cocina" || $perfil == "candy") {
			$response = $next($request, $response);
		}
		else
		{
			$objDelaRespuesta = array(
				'status'=>'ERROR',
				'mensaje'=>"Solo usuarios."
			);
			return $response->withJson($objDelaRespuesta, 200);
		}

        return $response;
	}

	public function VerificarMozo($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$perfil = $request->getAttribute('usuario')->perfil;
		if($perfil == "mozo") {
			$response = $next($request, $response);
		}
		else
		{
			$objDelaRespuesta = array(
				'status'=>'ERROR',
				'mensaje'=>"Solo mozos."
			);
			return $response->withJson($objDelaRespuesta, 200);
		}

        return $response;
	}
	
	public function FiltrarSueldos($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->esValido=false;
		$arrayConToken = $request->getHeader('HTTP_AUTHORIZATION');
		if(sizeof($arrayConToken) > 0) {
			$token=$arrayConToken[0];
			try {
				AutentificadorJWT::VerificarToken($token);
				$objDelaRespuesta->esValido=true;
			} catch (Exception $e) {
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;
			}
		}
		if($objDelaRespuesta->esValido) {
			$payload=AutentificadorJWT::ObtenerData($token);
			$response = $next($request, $response);
			if($payload->perfil != "admin") {
				$usuarios = json_decode($response->getBody()->__toString());
				if (is_array($usuarios)) {
					foreach ($usuarios as $usuario) {
						unset($usuario->sueldo);
					}
				} else {
					unset($usuarios->sueldo);
				}
				$nueva=$response->withJson($usuarios, 200);
				return $nueva;
			}
		} else {
			$response = $next($request, $response);
			$usuarios = json_decode($response->getBody()->__toString());
			if (is_array($usuarios)) {
				foreach ($usuarios as $usuario) {
					unset($usuario->sueldo);
				}
			} else {
				unset($usuarios->sueldo);
			}
			$nueva=$response->withJson($usuarios, 200);
			return $nueva;
		}
		
        return $response;
	}
	
	public function FiltrarVentas($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$usuario = $request->getAttribute('usuario');
		if($usuario->perfil != "admin") {
			$response = $next($request, $response);
			$ventas = json_decode($response->getBody()->__toString());
			if (is_array($ventas)) {
				foreach ($ventas as $key => $venta) {
					if ($venta->idUsuario != $usuario->id) {
						unset($ventas[$key]);
					}
				}
			} else {
				if ($ventas->idUsuario != $usuario->id) {
					$ventas = [];
				}
			}
			$nueva=$response->withJson($ventas, 200);
			return $nueva;
		} else if($usuario->perfil == "admin") {
			$response = $next($request, $response);
			return $response;
		} else {
			$objDelaRespuesta = array(
				'status'=>'ERROR',
				'mensaje'=>"Solo usuarios."
			);
			return $response->withJson($objDelaRespuesta, 200);
		}

        return $response;
	}
}