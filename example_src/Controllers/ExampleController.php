<?php
namespace Fortifi\UiExample\Controllers;

use Cubex\View\LayoutController;
use Fortifi\UiExample\Views\ColoursView;
use Fortifi\UiExample\Views\PageNavigationView;
use Fortifi\UiExample\Views\TextView;

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
      case 'text':
        return new TextView();
      default:
        return 'Coming Soon';
    }
  }

  public function getRoutes()
  {
    return [':page' => 'defaultAction'];
  }
}
