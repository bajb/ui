<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

class PanelContent extends UiElement
{
  protected $_content;

  public static function create($content = '')
  {
    $panelBody = new static;
    $panelBody->_content = $content;
    return $panelBody;
  }

  protected function _produceHtml()
  {
    return Div::create($this->_content)->addClass('panel-body');
  }
}
