<?php
namespace Fortifi\Ui\ContentElements\Chips;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\Helpers\ColourHelper;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Span;

class Chip extends UiElement
{
  /**
   * @var FaIcon
   */
  protected $_icon;
  /**
   * @var Link
   */
  protected $_action;
  protected $_name;
  protected $_value;
  protected $_color;
  protected $_borderColor;
  protected $_textColor = 'f-chip-dt';

  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/ContentElements.min.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/ContentElements/Chip.css');
    }
  }

  /**
   * @return FaIcon
   */
  public function getIcon()
  {
    return $this->_icon;
  }

  /**
   * @param FaIcon $icon
   *
   * @return Chip
   */
  public function setIcon(FaIcon $icon)
  {
    $this->_icon = $icon;
    return $this;
  }

  /**
   * @return Link
   */
  public function getAction()
  {
    return $this->_action;
  }

  /**
   * @param Link $action
   *
   * @return Chip
   */
  public function setAction(Link $action)
  {
    $this->_action = $action;
    return $this;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->_name;
  }

  /**
   * @param string $name
   *
   * @return Chip
   */
  public function setName($name)
  {
    $this->_name = $name;
    return $this;
  }

  /**
   * @return string
   */
  public function getValue()
  {
    return $this->_value;
  }

  /**
   * @param string $value
   *
   * @return Chip
   */
  public function setValue($value)
  {
    $this->_value = $value;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getColor()
  {
    return $this->_color;
  }

  /**
   * @param mixed $color
   *
   * @return Chip
   */
  public function setColor($color)
  {
    $this->_color = $color;
    if(ColourHelper::hexToRgb($color) !== false)
    {
      $this->_textColor = 'f-chip-' . (ColourHelper::contrastText($color) == 'white' ? 'lt' : 'dt');
    }
    return $this;
  }

  /**
   * @return mixed
   */
  public function getBorderColor()
  {
    return $this->_borderColor;
  }

  /**
   * @param mixed $borderColor
   *
   * @return Chip
   */
  public function setBorderColor($borderColor)
  {
    $this->_borderColor = $borderColor;
    return $this;
  }

  protected function _produceHtml()
  {
    $content = [
      $this->_icon ? Span::create($this->_icon)->addClass('f-chip-icon') : null,
      Span::create($this->_name)->addClass('name'),
      $this->_value ? Span::create($this->_value)->addClass('value') : null,
      $this->_action ? $this->_action->addClass('f-chip-action') : null,
    ];
    $chip = Div::create(array_filter($content))->addClass('f-chip');

    if($this->_textColor)
    {
      $chip->addClass($this->_textColor);
    }

    $style = '';
    if($this->_color)
    {
      $style .= '--chip-color: ' . $this->_color . ';';
    }

    if($this->_borderColor)
    {
      $style .= '--chip-border-color: ' . $this->_borderColor . ';';
    }

    if($style)
    {
      $chip->setAttribute('style', $style);
    }
    return $chip;
  }

}
