<?php
define('PHP_START', microtime(true));

use Cubex\Context\Context;
use Cubex\Cubex;
use Cubex\Routing\Router;
use Fortifi\UiExample\ExampleUi;
use Packaged\Dispatch\Dispatch;

$loader = require_once(dirname(__DIR__) . '/vendor/autoload.php');
$cubex = new Cubex(dirname(__DIR__), $loader);
//$launcher->listen(Cubex::EVENT_HANDLE_START, function (Context $ctx) { /* Configure your request here  */ });

$dispatchPath = "/_r";
$d = Dispatch::bind(new Dispatch(dirname(__DIR__), $dispatchPath));
$d->addAlias('root', 'assets_src');
$d->addAlias('esrc', 'example_src');
$router = Router::i();
$router->handleFunc(
  $dispatchPath,
  function (Context $c) {
    return Dispatch::instance()->handle($c->getRequest());
  }
);

$router->handle("/", new ExampleUi());
$cubex->handle($router);
