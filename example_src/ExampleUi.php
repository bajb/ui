<?php
namespace Fortifi\UiExample;

use Cubex\Kernel\CubexKernel;
use Fortifi\Ui\UI;
use Fortifi\UiExample\Controllers\ExampleController;
use Packaged\Dispatch\AssetManager;

class ExampleUi extends CubexKernel
{
  public function __construct()
  {
    UI::boot(AssetManager::aliasType('root'));
  }

  public function defaultAction()
  {
    return new ExampleController();
  }
}
