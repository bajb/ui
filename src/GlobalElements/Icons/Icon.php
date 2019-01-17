<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Text\ItalicText;

abstract class Icon extends UiElement
{
  protected $_icon;
  protected $_classes = [];
  protected $_color;

  public static function create($icon)
  {
    $icn = new static();
    $icn->_icon = $icon;
    return $icn;
  }

  abstract protected function _processIconIncludes(AssetManager $assetManager);

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/GlobalElements');
    }
    else
    {
      $this->_processIconIncludes($assetManager);
    }
  }

  public function addClass($class)
  {
    $this->_classes[] = $class;
    return $this;
  }

  public function setColor($color)
  {
    $this->_color = $color;
    return $this;
  }

  /**
   * @return HtmlTag
   */
  protected function _produceHtml()
  {
    $icon = ItalicText::create();
    $icon->addClass($this->_icon);
    foreach($this->_classes as $class)
    {
      $icon->addClass($class);
    }
    if($this->_color)
    {
      $icon->setAttribute('style', 'color:' . $this->_color);
    }
    return $icon;
  }
}
