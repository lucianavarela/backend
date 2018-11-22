<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once './composer/vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/MWparaAutentificar.php';
require_once './clases/MWparaCors.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/login.php';
require_once './clases/IApiUsable.php';
require_once './clases/usuario.php';
require_once './clases/usuarioApi.php';
require_once './clases/venta.php';
require_once './clases/ventaApi.php';
require_once './clases/zapato.php';
require_once './clases/zapatoApi.php';
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/login/', \login::class . ':UserLogin')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->post('/signup/', \login::class . ':UserSignUp')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->group('/api', function () use ($app) {
  $app->group('/usuario', function () use ($app) {
    $this->get('/', \usuarioApi::class . ':TraerTodos')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->get('/{id}', \usuarioApi::class . ':TraerUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->post('/', \usuarioApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->delete('/{id}', \usuarioApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->put('/{id}', \usuarioApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
  });
  $app->group('/venta', function () use ($app) {
    $this->get('/', \ventaApi::class . ':TraerTodos')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->get('/{juego}', \ventaApi::class . ':TraerUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->post('/', \ventaApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->delete('/{id}', \ventaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->put('/{id}', \ventaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
  });
  $app->group('/zapato', function () use ($app) {
    $this->get('/', \zapatoApi::class . ':TraerTodos');
    $this->get('/{juego}', \zapatoApi::class . ':TraerUno');
    $this->post('/', \zapatoApi::class . ':CargarUno');
    $this->delete('/{id}', \zapatoApi::class . ':BorrarUno');
    $this->put('/{id}', \zapatoApi::class . ':ModificarUno');
  });
})->add(\MWparaAutentificar::class . ':VerificarLogueado');

$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
          ->withHeader('Access-Control-Allow-Origin', '*')
          ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
          ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
  $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
  return $handler($req, $res);
});

$app->run();