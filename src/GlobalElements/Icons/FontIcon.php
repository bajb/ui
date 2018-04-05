<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\Interfaces\IIcons;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;

class FontIcon extends Icon implements IIcons
{
  /**
   * @return HtmlTag
   */
  protected function _produceHtml()
  {
    $icon = parent::_produceHtml();
    $icon->addClass('fa', 'fa-fw', 'f-icon', $this->_icon);
    return $icon;
  }

  protected function _processIconIncludes(AssetManager $assetManager)
  {
    $assetManager->requireCss('assets/css/GlobalElements/FontIcons');
  }

  /**
   * @param FontIcon[] ...$icons
   *
   * @return HtmlTag
   */
  public static function stack(...$icons)
  {
    foreach($icons as $k => $icon)
    {
      $icon->addClass('fa-stack-' . ($k == 0 ? 1 : 2) . 'x');
    }
    return HtmlTag::createTag('i', ['class' => ['fa-stack', 'fa']], $icons);
  }
}
