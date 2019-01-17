<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\HeadingTwo;
use Packaged\SafeHtml\ISafeHtmlProducer;

class PanelHeader extends UiElement
{
  const BG_INFO = Ui::BG_INFO_LIGHT;
  const BG_SUCCESS = Ui::BG_SUCCESS_LIGHT;
  const BG_WARNING = Ui::BG_WARNING_LIGHT;
  const BG_DANGER = Ui::BG_DANGER_LIGHT;
  const BG_MUTED = '';

  const STATUS_OPEN = 'Open';
  const STATUS_CLOSED = 'Closed';
  const STATUS_HELD = 'Held';

  protected $_title;
  protected $_actions;
  protected $_icon;
  protected $_status;
  protected $_bgColour;

  public static function create($title = null)
  {
    $heading = new static();
    $heading->_title = $title;
    return $heading;
  }

  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

  /**
   * Add singular action to PanelHeading
   *
   * @param HtmlTag $action
   * @param string  $withClass if HTML Tag
   *
   * @return $this
   */
  public function addAction(HtmlTag $action, $withClass = Ui::MARGIN_MEDIUM_LEFT)
  {
    if($withClass)
    {
      $action->addClass($withClass);
    }
    $this->addCustomAction($action);
    return $this;
  }

  public function addCustomAction(ISafeHtmlProducer $action)
  {
    $this->_actions[] = $action;
    return $this;
  }

  /**
   * Process array of actions to add to PanelHeading
   *
   * @param array $actions
   *
   * @return $this
   * @throws \Exception
   */
  public function setActions(array $actions)
  {
    foreach($actions as $action)
    {
      if($action instanceof ISafeHtmlProducer)
      {
        $this->addAction($action);
      }
      else
      {
        throw new \Exception('setActions() array must contain ISafeHtmlProducer objects');
      }
    }
    return $this;
  }

  public function setBgColour($colour = self::BG_MUTED)
  {
    $this->_bgColour = $colour;
    return $this;
  }

  /**
   * @param string $icon
   *
   * @return $this
   */
  public function addIcon($icon = FontIcon::EDIT)
  {
    $this->_icon = FontIcon::create($icon)
      ->addClass('panel-heading-icon')
      ->addClass(Ui::FLOAT_LEFT)
      ->addClass(Ui::MARGIN_SMALL_TOP);
    return $this;
  }

  /**
   *
   *
   * @param string $text
   * @param null   $url
   * @param string $style
   *
   * @return $this
   */
  public function setStatus(
    $text = self::STATUS_OPEN, $url = null, $style = Ui::LABEL_SUCCESS
  )
  {
    switch($text)
    {
      case self::STATUS_CLOSED:
        $style = Ui::LABEL_DANGER;
        break;
      case self::STATUS_HELD:
        $style = Ui::LABEL_WARNING;
        break;
      case self::STATUS_OPEN:
        $style = Ui::LABEL_SUCCESS;
        break;
    }

    $status = $url ? new Link($url, $text) : Span::create($text);

    $status->addClass(
      'heading-status',
      Ui::FLOAT_RIGHT,
      Ui::MARGIN_MEDIUM_LEFT,
      'label ' . $style . ' ' . Ui::LABEL_AS_BADGE
    );
    $this->_status = $status;
    return $this;
  }

  protected function _renderTitle()
  {
    return HeadingTwo::create($this->getTitle())
      ->addClass('heading-text', Ui::FLOAT_LEFT, Ui::MARGIN_NONE);
  }

  protected function _renderActions()
  {
    return Div::create($this->getActions())
      ->addClass('heading-action', Ui::FLOAT_RIGHT, Ui::MARGIN_MEDIUM_LEFT);
  }

  public function getTitle()
  {
    return $this->_title;
  }

  public function getIcon()
  {
    return $this->_icon;
  }

  public function getStatus()
  {
    return $this->_status;
  }

  public function getBgColour()
  {
    return $this->_bgColour;
  }

  /**
   * Builds the HTML output of the PanelHeading actions
   *
   * @return Div
   */
  public function getActions()
  {
    return $this->_actions;
  }

  protected function _produceHtml()
  {
    return Div::create(
      [
        $this->getIcon(),
        $this->_renderTitle(),
        $this->_renderActions(),
        $this->getStatus(),
      ]
    )->addClass(
      'f-panel-heading',
      'panel-heading',
      $this->getBgColour(),
      Ui::CLEARFIX
    );
  }
}
