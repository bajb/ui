<?php
namespace Fortifi\UiExample\Controllers;

use Cubex\View\LayoutController;
use Fortifi\UiExample\Views\ColoursView;
use Fortifi\UiExample\Views\PageNavigationView;

class ExampleController extends LayoutController
{
  public function defaultAction($page = null)
  {
    switch($page)
    {
      case 'colours':
        return new ColoursView();
      case 'navigation':
        return new PageNavigationView();
      default:
        return 'Coming Soon';
    }
  }

  public function getRoutes()
  {
    return [':page' => 'defaultAction'];
  }
}
