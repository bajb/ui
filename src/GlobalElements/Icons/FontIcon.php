<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;

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
   * @return HtmlTag
   */
  protected function _produceHtml()
  {
    $icon = parent::_produceHtml();
    $icon->addClass('fa', 'fa-fw', 'f-icon', $this->_icon);
    return $icon;
  }

  protected function _processIconIncludes(AssetManager $assetManager)
  {}
}
