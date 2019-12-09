<?php
namespace Fortifi\UiExample;

use Cubex\Application\Application;
use Cubex\Cubex;
use Fortifi\UiExample\Controllers\ExampleController;
use Packaged\Dispatch\Dispatch;
use Packaged\Routing\Handler\Handler;

class ExampleUi extends Application
{
  public function __construct(Cubex $cubex)
  {
    parent::__construct($cubex);
  }

  protected function _initialize()
  {
    $dispatch = new Dispatch($this->getCubex()->getContext()->getProjectRoot(), '_r');
    $dispatch->addAlias('root', 'assets_src');
    $dispatch->addAlias('esrc', 'example_src');
    Dispatch::bind($dispatch);
  }

  protected function _defaultHandler(): Handler
  {
    return new ExampleController();
  }
}
