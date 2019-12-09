<?php
define('PHP_START', microtime(true));

use Cubex\Cubex;
use Fortifi\UiExample\ExampleUi;

$loader = require_once(dirname(__DIR__) . '/vendor/autoload.php');
$cubex = new Cubex(dirname(__DIR__), $loader);
return $cubex->handle(new ExampleUi($cubex));
