<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\PageElements\PageNavigation\PageNavigation;
use Packaged\Glimpse\Tags\Link;

class PageNavigationView extends AbstractUiExampleView
{
  /**
   * @group MenuItem
   */
  final public function standardMenu()
  {
    $nav = PageNavigation::create();
    $nav->setTitle('Menu Title');
    $nav->addItem(new Link('#', 'Item One'));
    $nav->addItem(new Link('#', 'Item Two'), true);
    return $nav;
  }
}
