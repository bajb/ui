<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\SafeHtml;

abstract class Icon extends UiElement
{
  protected $_icon;
  protected $_classes = [];

  public static function create($icon)
  {
    $icn = new static;
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

  /**
   * @return HtmlTag
   */
  protected function _produceHtml()
  {
    $icon = HtmlTag::createTag('i');
    $icon->addClass($this->_icon);

    foreach($this->_classes as $class)
    {
      $icon->addClass($class);
    }
    return $icon;
  }
}
