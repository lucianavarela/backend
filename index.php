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
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/login/', \login::class . ':UserLogin');
$app->post('/signup/', \login::class . ':UserSignUp');
$app->group('/api', function () use ($app) {
  $app->group('/jugador', function () use ($app) {
    $this->get('/', \jugadorApi::class . ':TraerTodos');
    $this->get('/{id}', \jugadorApi::class . ':TraerUno');
    $this->post('/', \jugadorApi::class . ':CargarUno');
    $this->delete('/{id}', \jugadorApi::class . ':BorrarUno');
    $this->put('/{id}', \jugadorApi::class . ':ModificarUno');
  });
  $app->group('/resultado', function () use ($app) {
    $this->get('/', \resultadoApi::class . ':TraerTodos');
    $this->get('/{juego}', \resultadoApi::class . ':TraerUno');
    $this->post('/', \resultadoApi::class . ':CargarUno');
    $this->delete('/{id}', \resultadoApi::class . ':BorrarUno');
    $this->put('/{id}', \resultadoApi::class . ':ModificarUno');
  });
})->add(\MWparaAutentificar::class . ':VerificarToken')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->run();