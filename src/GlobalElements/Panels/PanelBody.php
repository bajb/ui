<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

class PanelBody extends UiElement
{
  protected $_content;

  public static function create($content)
  {
    $panel = new static;
    $panel->_content = $content;
    return $panel;
  }

  /**
   * @var $panel Div
   *
   * @return Div
   */
  protected function _produceHtml()
  {
    return Div::create($this->_content)->addClass(
      'panel-body',
      Ui::BG_WHITE
    );
  }
}
