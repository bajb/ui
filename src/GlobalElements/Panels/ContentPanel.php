<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Packaged\Glimpse\Tags\Div;

class ContentPanel extends Panel
{
  public function getContent()
  {
    return Div::create($this->_content)->addClass('panel-body');
  }
}
