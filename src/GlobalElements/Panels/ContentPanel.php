<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Packaged\Glimpse\Tags\Div;

class ContentPanel extends Panel
{
  public function getContent()
  {
    return Div::create($this->_content)->addClass('panel-body');
  }

  protected function _produceHtml()
  {
    $this->setStyle(self::STYLE_DEFAULT);
    return parent::_produceHtml();
  }
}
