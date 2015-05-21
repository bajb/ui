<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\SafeHtml;

class FontIcon extends Icon
{
  const EDIT = 'fa-pencil';
  const DELETE = 'fa-times';
  const LOCK = 'fa-lock';
  const UNLOCK = 'fa-unlock';
  const MAKE_DEFAULT = 'fa-star-o';
  const CURRENT_DEFAULT = 'fa-star';

  /**
   * Policies
   */
  const COMMISSION = 'fa-money';
  const TRAFFIC_BLOCKS = 'fa-shield';
  const ACTION_VISIBILITY = 'fa-child';
  const REVERSALS = 'fa-undo';
  const TQP = 'fa-random';
  const AUTO_TQP = 'fa-line-chart';

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
