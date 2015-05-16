<?php
namespace Fortifi\UiExample\Controllers;

use Cubex\View\LayoutController;
use Fortifi\Ui\ProjectSupport\FortifiUiLayout;
use Fortifi\UiExample\Views\ColoursView;
use Fortifi\UiExample\Views\ObjectListsView;
use Fortifi\UiExample\Views\PageNavigationView;
use Fortifi\UiExample\Views\TextView;

class ExampleController extends LayoutController
{

  protected function _init()
  {
    $this->setLayout(new FortifiUiLayout($this));
  }

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
      case 'objectlist':
        return new ObjectListsView();
      default:
        return 'Coming Soon';
    }
  }

  public function getRoutes()
  {
    return [':page' => 'defaultAction'];
  }
}
