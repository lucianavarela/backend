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
require_once './clases/jugador.php';
require_once './clases/jugadorApi.php';
require_once './clases/resultado.php';
require_once './clases/resultadoApi.php';
require_once './clases/vehiculo.php';
require_once './clases/vehiculoApi.php';
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/login/', \login::class . ':UserLogin')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->post('/signup/', \login::class . ':UserSignUp')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->group('/api', function () use ($app) {
  $app->group('/jugador', function () use ($app) {
    $this->get('/', \jugadorApi::class . ':TraerTodos')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->get('/{id}', \jugadorApi::class . ':TraerUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->post('/', \jugadorApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->delete('/{id}', \jugadorApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->put('/{id}', \jugadorApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
  });
  $app->group('/resultado', function () use ($app) {
    $this->get('/', \resultadoApi::class . ':TraerTodos')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->get('/{juego}', \resultadoApi::class . ':TraerUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->post('/', \resultadoApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->delete('/{id}', \resultadoApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
    $this->put('/{id}', \resultadoApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarToken');
  });
  $app->group('/vehiculo', function () use ($app) {
    $this->get('/', \vehiculoApi::class . ':TraerTodos');
    $this->get('/{id}', \vehiculoApi::class . ':TraerUno');
    $this->post('/', \vehiculoApi::class . ':CargarUno');
    $this->delete('/{id}', \vehiculoApi::class . ':BorrarUno');
    $this->put('/{id}', \vehiculoApi::class . ':ModificarUno');
  });
})->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
  $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
  return $handler($req, $res);
});
$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->run();