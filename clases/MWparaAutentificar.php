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
	public function VerificarToken($request, $response, $next) {
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";
		$headers = $request->getHeaders();
		
		foreach ($headers as $name => $values) {
			if ($name == 'HTTP_AUTHORIZATION') {
				$token=$values[0];
				$objDelaRespuesta->esValido=true;
				try {
					AutentificadorJWT::verificarToken($token);
					$objDelaRespuesta->esValido=true;
				} catch (Exception $e) {
					$objDelaRespuesta->excepcion=$e->getMessage();
					$objDelaRespuesta->esValido=false;
				}
				if($objDelaRespuesta->esValido) {
					$payload=AutentificadorJWT::ObtenerData($token);
					$request = $request->withAttribute('jugador', $payload);
					$response = $next($request, $response);
				} else {
					$objDelaRespuesta->respuesta="Por favor logueese para realizar esta accion!";
					$objDelaRespuesta->elToken=$token;
				}
			}
		}
        
        if($objDelaRespuesta->respuesta!="") {
			$objDelaRespuesta->respuesta="Por favor logueese para realizar esta accion!";
			$nueva=$response->withJson($objDelaRespuesta, 201);
			return $nueva;
        }

        return $response;
	}

}