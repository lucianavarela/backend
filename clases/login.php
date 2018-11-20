<?php
class Login
{
    public static function UserLogin($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
        $usuario = Usuario::ValidarUsuario(
            $ArrayDeParametros['mail'], $ArrayDeParametros['clave'],$ArrayDeParametros['nombre'], $ArrayDeParametros['perfil']);
        if($usuario) {
            $token = AutentificadorJWT::CrearToken($usuario);
            $objDelaRespuesta = array(
                'token'=>$token,
                'status'=>'OK'
            );
        } else {
			$objDelaRespuesta = array(
                'mensaje'=>'Usuario inexistente',
                'status'=>'ERROR'
            );
        }
        return $response->withJson($objDelaRespuesta, 200);
    }
}