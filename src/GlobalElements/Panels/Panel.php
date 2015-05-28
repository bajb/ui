<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;

class Panel extends PanelBase
{
  protected $_content;
  protected $_bgColour = Ui::BG_WHITE;
  protected $_classes = [];
  protected $_attributes = [];

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
    $panel = parent::_produceHtml();
    return $panel->addClass('f-panel');
  }
}
