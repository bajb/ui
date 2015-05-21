<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\SafeHtml;

class Icon extends UiElement
{
  protected $_icon;
  protected $_classes = [];

  public static function create($icon)
  {
    $icn = new static;
    $icn->_icon = $icon;
    return $icn;
  }

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/GlobalElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/GlobalElements/Icons');
    }
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
    $icon = HtmlTag::createTag(
      'i',
      [
        'class' => [
          'f-icon' => 'f-icon',
          'fa'     => 'fa',
          'fa-fw'  => 'fa-fw',
        ]
      ]
    );
    $icon->addClass($this->_icon);
    $icon->setAttribute('title', $this->_icon);

    foreach($this->_classes as $class)
    {
      $icon->addClass($class);
    }
    return $icon;
  }
}
