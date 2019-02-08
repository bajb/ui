<?php
namespace Fortifi\UiExample;

use Cubex\Controller\Controller;
use Fortifi\Ui\Ui;
use Fortifi\UiExample\Controllers\ExampleController;
use Packaged\Dispatch\ResourceManager;

class ExampleUi extends Controller
{
  public function getRoutes()
  {
    return 'default';
  }

  public function __construct()
  {
    Ui::boot(ResourceManager::alias('root'));
    ResourceManager::alias('esrc')->requireCss('css/theme.css');
  }

  public function getDefault()
  {
    return new ExampleController();
  }
}
