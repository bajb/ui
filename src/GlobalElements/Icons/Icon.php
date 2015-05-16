<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\SafeHtml;

class Icon extends UiElement
{
  const EDIT = 'fa-pencil';
  const DELETE = 'fa-times';
  const LOCK = 'fa-lock';
  const UNLOCK = 'fa-unlock';

  protected $_icon;

  public function __construct($icon)
  {
    $this->_icon = $icon;
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
    return $icon;
  }
}
