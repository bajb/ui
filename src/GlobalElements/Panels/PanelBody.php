<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;

class PanelBody extends PanelBase
{
  protected $_content;
  protected $_classes = [];
  protected $_attributes = [];
  protected $_bgColour = Ui::BG_WHITE;

  public static function create($content)
  {
    $panel = new static;
    $panel->_content = $content;
    return $panel;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panelBody = parent::_produceHtml();
    return $panelBody->addClass('panel-body', Ui::BG_WHITE, Ui::BORDER_RADIUS_BOTTOM_MEDIUM)
      ->setAttribute('style', $this->_border);
  }
}
