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
   * @param string $property
   * @param string $value
   *
   * @return static
   */
  public static function create($property, $value)
  {
    $obj = new static();
    $obj->setProperty($property);
    $obj->setValue($value);
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
   * @return Div
   */
  protected function _produceHtml()
  {
    $div = Div::create(
      [
        BoldText::create($this->_property),
        Span::create($this->_value),
      ]
    );
    $div->addClass('f-prop-value');
    return $div;
  }
}
