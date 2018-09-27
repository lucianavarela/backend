<?php
class Login
{
    public static function UserLogin($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
        $jugador = Jugador::ValidarJugador($ArrayDeParametros['usuario'], $ArrayDeParametros['clave']);
        if($jugador) {
            $token = AutentificadorJWT::CrearToken($jugador);
            $objDelaRespuesta = array(
                'token'=>$token,
                'nombre'=>$jugador->nombre
            );
            return $response->withJson($objDelaRespuesta, 200);
        } else {
            $objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta='Usuario inexistente';
            return $response->withJson($objDelaRespuesta, 201);
        }
    }

    public static function UserSignUp($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $jugador = new Jugador();
		$jugador->usuario=$ArrayDeParametros['usuario'];
		$jugador->clave=$ArrayDeParametros['clave'];
		$jugador->nombre=$ArrayDeParametros['nombre'];
		$jugador->InsertarJugador();
        if($jugador) {
            $token = AutentificadorJWT::CrearToken($jugador);
            $objDelaRespuesta = array(
                'token'=>$token,
                'nombre'=>$jugador->nombre
            );
            return $response->withJson($objDelaRespuesta, 200);
        } else {
            $objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta='No se pudo crear el usuario';
            return $response->withJson($objDelaRespuesta, 201);
        }
    }
}