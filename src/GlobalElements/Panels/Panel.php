<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Packaged\Glimpse\Tags\Div;

class Panel extends PanelBase
{
  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panel = parent::_produceHtml();
    return $panel->addClass('f-panel');
  }
}
