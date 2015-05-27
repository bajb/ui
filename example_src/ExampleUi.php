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
    AssetManager::aliasType('esrc')->requireCss('css/theme');
  }

  public function defaultAction()
  {
    return new ExampleController();
  }
}
