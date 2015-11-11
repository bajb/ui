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
  const TICK = 'fa-check';
  const CROSS = 'fa-times';
  const BAN = 'fa-ban';

  const USER = 'fa-user';
  const EMAIL = 'fa-at';
  const PORTAL = 'fa-globe';
  const WORKFLOW = 'fa-random';
  const SECURITY = 'fa-lock';
  const BILLING = 'fa-money';

  const QUESTION = 'fa-question';
  const INCIDENT = 'fa-flash';
  const PROBLEM = 'fa-exclamation';
  const SUPPORT = 'fa-life-ring';

  const URGENCY = 'fa-heartbeat';
  const IMPACT = 'fa-arrow-up';

  const ATTACHMENT = 'fa-paperclip';

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
    return HtmlTag::createTag('i', ['class' => 'fa-stack fa'], $icons);
  }
}
