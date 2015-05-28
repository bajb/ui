<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

abstract class PanelBase extends UiElement
{
  const BORDER_RAD_TOP = 'top';
  const BORDER_RAD_BOTTOM = 'bottom';

  protected $_content;
  protected $_bgColour = Ui::BG_WHITE;
  protected $_border = 'border: 1px solid #ddd';
  protected $_borderRadius;
  protected $_classes = [];
  protected $_attributes = [];

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

  public function setAttribute($property, $value)
  {
    $this->_attributes[$property][] = [$property, $value];
    return $this;
  }

  /**
   * $bgColour should use class constants Ui::BG_*
   * @param $bgColour
   *
   * @return $this
   */
  public function setBgColour($bgColour)
  {
    if(substr($bgColour, 0, 5) === 'f-bg-')
    {
      $this->_bgColour = $bgColour;
    }
    else
    {
      $this->_bgColour = null;
      $this->setAttribute('style', 'background-color: '. $bgColour);
    }

    return $this;
  }

  /**
   * Set border radius on panels with no heading
   *
   * @param string $borderRadius
   *
   * @return $this
   */
  public function setBorderRadius($borderRadius = Ui::BORDER_RADIUS_TOP_MEDIUM)
  {
    $this->addClass($borderRadius);
    return $this;
  }

  public function removeBgColour()
  {
    $this->_bgColour = null;
    return $this;
  }

  public function removeBorder()
  {
    $this->_border = null;
    return $this;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panel = Div::create($this->_content);
    foreach($this->_classes as $class)
    {
      $panel->addClass($class);
    }

    $this->_bgColour ? $this->addClass($this->_bgColour) : null;

    foreach($this->_classes as $class)
    {
      $this->addClass($class);
    }

    foreach($this->_attributes as $prop => $val)
    {
      $this->setAttribute($prop, $val);
    }

    return $panel;
  }
}
