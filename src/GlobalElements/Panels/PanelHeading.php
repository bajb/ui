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
  protected $_title;
  protected $_actions;
  protected $_icon;
  protected $_status;

  public static function create($title = '')
  {
    $heading = new static;
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
   * @param Link $action
   *
   * @return $this
   */
  public function addAction(Link $action)
  {
    $this->_actions[] = $action->addClass(Ui::MARGIN_MEDIUM_LEFT);
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
  public function addActions(array $actions)
  {
    foreach($actions as $action)
    {
      if(!$action instanceof Link)
      {
        throw new \Exception('addActions() array must contain Link() objects');
      }
      else
      {
        $this->addAction($action);
      }
    }
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
      ->addClass('heading-icon')
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
  public function addStatus($text = '', $url = null, $style = Ui::LABEL_SUCCESS)
  {
    if($url !== null)
    {
      $status = new Link($url, $text);
    }
    else
    {
      $status = Span::create($text);
    }

    $status->addClass(
      'heading-status',
      Ui::FLOAT_RIGHT,
      Ui::MARGIN_MEDIUM_LEFT,
      'label ' . $style . ' '. Ui::LABEL_AS_BADGE
    );
    $this->_status = $status;
    return $this;
  }

  /**
   * Builds the HTML output of the PanelHeading actions
   *
   * @return Div
   */
  protected function _buildActions()
  {
    return Div::create($this->_actions)
      ->addClass('heading-action', Ui::FLOAT_RIGHT, Ui::MARGIN_MEDIUM_LEFT);
  }

  protected function _produceHtml()
  {
    return Div::create(
      [
        $this->_icon,
        HeadingTwo::create($this->_title)->addClass(
          'heading-text',
          Ui::FLOAT_LEFT,
          Ui::MARGIN_NONE
        ),
        $this->_buildActions(),
        $this->_status
      ]
    )->addClass(
      'panel-heading',
      Ui::CLEARFIX
    );
  }
}
