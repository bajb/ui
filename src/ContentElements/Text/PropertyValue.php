<?php
namespace Fortifi\Ui\ContentElements\Text;

use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\BoldText;

class PropertyValue extends UiElement
{
  /**
   * @var string
   */
  protected $_property;
  /**
   * @var string
   */
  protected $_value;
  /**
   * @var bool
   */
  protected $_force = false;

  /**
   * @param string $property
   * @param string $value
   * @param bool   $force
   *
   * @return static
   */
  public static function create($property, $value, $force = false)
  {
    $obj = new static();
    $obj->setProperty($property);
    $obj->setValue($value);
    $obj->setForce($force);
    return $obj;
  }

  /**
   * @param string $property
   */
  public function setProperty($property)
  {
    $this->_property = $property;
  }

  /**
   * @param string $value
   */
  public function setValue($value)
  {
    $this->_value = $value;
  }

  /**
   * @param bool $bool
   */
  public function setForce($bool)
  {
    $this->_force = $bool;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    if($this->_force || $this->_value)
    {
      $div = Div::create(
        [
          BoldText::create('Field'),
          Span::create('Value')
        ]
      );
      $div->addClass('f-prop-value');
      return $div;
    }
    else
    {
      return null;
    }
  }
}
