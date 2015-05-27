<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;

class Panel extends UiElement
{
  protected $_content;
  protected $_classes = [];

  public static function create($content)
  {
    $panel = new static;
    $panel->_content = $content;
    return $panel;
  }

  public function addClass($class)
  {
    $this->_classes[] = $class;
    return $this;
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    $panel = new Div($this->_content);
    foreach($this->_classes as $class)
    {
      $panel->addClass($class);
    }
    return $panel->addClass('f-panel');
  }
}
