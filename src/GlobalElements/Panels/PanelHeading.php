<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\HeadingTwo;

class PanelHeading extends UiElement
{
  const ICON_PENCIL = 'fa-pencil';

  const STATUS_SUCCESS = 'success';
  const STATUS_PRIMARY = 'primary';
  const STATUS_INFO = 'info';
  const STATUS_WARNING = 'warning';
  const STATUS_DANGER = 'danger';
  const STATUS_DEFAULT = 'default';

  protected $_text;
  protected $_icon;
  protected $_status;
  protected $_actions = [];
  protected $_content = [];

  public static function create($title = '')
  {
    $panelHeading = new static;
    $panelHeading->_text = HeadingTwo::create($title)->addClass(
      'heading-text',
      Ui::FLOAT_LEFT,
      Ui::MARGIN_NONE
    );
    return $panelHeading;
  }

  public function setStatus($text = '', $url = null)
  {
    if($url !== null)
    {
      $status = new Link('#', $text);
    }
    else
    {
      $status = Span::create($text);
    }

    $status->addClass(
      'heading-status',
      Ui::FLOAT_RIGHT,
      Ui::MARGIN_MEDIUM_LEFT
    );
    $this->_status = $status;
    return $this;
  }

  public function addIcon($icon = FontIcon::EDIT)
  {
    $this->_icon = FontIcon::create($icon);
    $this->_icon->addClass('heading-icon');
    $this->_icon->addClass(Ui::FLOAT_LEFT);
    $this->_icon->addClass(Ui::MARGIN_SMALL_TOP);
    return $this;
  }

  /**
   * @param $action
   *
   * @return $this
   */
  public function addAction($action)
  {
    $actions[] = $action;
    $this->_actions = Div::create($actions)->addClass(
      'heading-action',
      Ui::FLOAT_RIGHT,
      Ui::MARGIN_MEDIUM_LEFT
    );
    return $this;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    return Div::create(
      [
        $this->_icon,
        $this->_text,
        $this->_actions,
        $this->_status
      ]
    )->addClass('panel-heading', Ui::CLEARFIX);
  }
}
