<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\Interfaces\IIcons;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Text\ItalicText;

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

  protected function _processIconIncludes(ResourceManager $resourceManager)
  {
    $resourceManager->requireCss('assets/css/GlobalElements/FontIcons.css');
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
    return ItalicText::create($icons)->addClass('fa', 'fa-stack');
  }
}
