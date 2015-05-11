<?php
namespace Fortifi\UiExample\Controllers;

use Cubex\View\LayoutController;
use Fortifi\UiExample\Views\ColoursView;

class ExampleController extends LayoutController
{
  public function defaultAction($page = null)
  {
    switch($page)
    {
      case 'colours':
        return new ColoursView();
      default:
        return 'Coming Soon';
    }
  }

  public function getRoutes()
  {
    return [':page' => 'defaultAction'];
  }
}
