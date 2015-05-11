<?php
//Defining PHP_START will allow cubex to add an execution time header
define('PHP_START', microtime(true));

//Include the composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

//Create an instance of cubex, with the web root defined
$cubex = new \Cubex\Cubex(__DIR__);
$cubex->boot();

//Create and configure a new dispatcher
$dispatcher = new \Packaged\Dispatch\Dispatch(
  $cubex,
  $cubex->getConfiguration()->getSection('dispatch')
);

//Set the correct working directory for dispatcher
$dispatcher->setBaseDirectory(dirname(__DIR__));

//Load in the cache of file hashes to improve performance of dispatched assets
$fileHash = 'conf/dispatch.filehash.ini';
if(file_exists($fileHash))
{
  $hashTable = parse_ini_file($fileHash, false);
  if(!empty($hashTable))
  {
    $dispatcher->setFileHashTable($hashTable);
  }
}

//Inject dispatch to handle assets
$app = (new \Stack\Builder());
$app = $app->push([$dispatcher, 'prepare'])->resolve($cubex);

//Create a request object
$request = \Cubex\Http\Request::createFromGlobals();

//Tell Cubex to handle the request, and do its magic
$response = $app->handle($request);

$response->headers->set('Access-Control-Allow-Origin', '*');

//Send the generated response to the user
$response->send();

//Shutdown Cubex
$app->terminate($request, $response);
