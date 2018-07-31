<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Dropdowns\Dropdown;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;

class DropdownView extends AbstractUiExampleView
{
  /**
   * @group Dropdowns
   */
  final public function urlDropdown()
  {
    $d = Dropdown::i();
    $d->setAction(FontIcon::create(FontIcon::SETTINGS));
    //$d->setAction('test');
    $d->setUrl('/dropdowns/content');
    return $d;
  }

  /**
   * @group Dropdowns
   */
  final public function contentDropdown()
  {
    $d = Dropdown::i();
    $d->setAction('test');
    $d->setContent('this is some content');
    return $d;
  }
}
