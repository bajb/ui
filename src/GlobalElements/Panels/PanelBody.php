<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;

class PanelBody extends PanelBase
{
  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panelBody = parent::_produceHtml();
    return $panelBody->addClass(
      'panel-body', $this->_bgColour, Ui::BORDER_RADIUS_BOTTOM_MEDIUM)
      ->setAttribute('style', $this->_border);
  }
}
