<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\HeadingTwo;

class Panel extends UiElement
{
  protected $_heading;
  protected $_headingBg = '#EEF0F4';
  protected $_headingBorder = 'border: 1px solid #d8d8d8';
  protected $_title;
  protected $_icon;
  protected $_actions;
  protected $_status;

  protected $_content;
  protected $_bodyPadding;
  protected $_bgColour = Ui::BG_WHITE;
  protected $_border = 'border: 1px solid #ddd';
  protected $_borderRadius;
  protected $_classes = [];
  protected $_attributes = [];

  public static function create($content, $title = null, $bodyPadding = true)
  {
    $panel = new static;
    $panel->_content = $content;
    $panel->_title = $title;
    $panel->_bodyPadding = $bodyPadding;
    return $panel;
  }

  protected function _buildBody()
  {
    if($this->_bodyPadding)
    {
      return Div::create($this->_content)
        ->addClass(
          'panel-body',
          $this->_bgColour,
          Ui::BORDER_RADIUS_BOTTOM_MEDIUM
        )
        ->setAttribute('style', $this->_border);
    }

    return $this->_content;
  }

  protected function _buildHeading()
  {
    if($this->_title)
    {
      return Div::create(
        [
          $this->_icon,
          HeadingTwo::create($this->_title)->addClass(
            'heading-text',
            Ui::FLOAT_LEFT,
            Ui::MARGIN_NONE
          ),
          $this->_actions,
          $this->_status
        ]
      )->addClass(
        'panel-heading',
        Ui::CLEARFIX,
        Ui::BORDER_BOTTOM_NONE
      )->setAttribute(
        'style',
        $this->_headingBg . '; ' . $this->_headingBorder
      );
    }

    return false;
  }

  public function addClass($class)
  {
    $this->_classes[] = $class;
    return $this;
  }

  public function setAttribute($property, $value)
  {
    $this->_attributes[$property][] = [$property, $value];
    return $this;
  }

  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

  /**
   * @param $obj
   *
   * @return $this
   */
  public function addAction($obj)
  {
    $actions = [];
    if(is_array($obj))
    {
      foreach($obj as $action)
      {
        $actions[] = Span::create($action)->addClass(Ui::MARGIN_MEDIUM_LEFT);
      }
    }
    else
    {
      $actions = $obj;
    }
    $this->_actions = Div::create($actions)->addClass(
      'heading-action',
      Ui::FLOAT_RIGHT
    );
    return $this;
  }

  public function addIcon($icon = FontIcon::EDIT)
  {
    $this->_icon = FontIcon::create($icon)
      ->addClass('heading-icon')
      ->addClass(Ui::FLOAT_LEFT)
      ->addClass(Ui::MARGIN_SMALL_TOP);
    return $this;
  }

  public function addStatus($text = '', $url = null)
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
      Ui::MARGIN_MEDIUM_LEFT
    );
    $this->_status = $status;
    return $this;
  }

  public function headingBg($bg = '#EEF0F4')
  {
    $this->_headingBg = 'background: ' . $bg;
    return $this;
  }

  public function headingBorder($border = '1px solid #d8d8d8')
  {
    $this->_headingBorder = 'border: ' . $border;
    return $this;
  }

  /**
   * Set border radius on panels with no heading
   *
   * @param string $borderRadius
   *
   * @return $this
   */
  public function setBorderRadius($borderRadius = Ui::BORDER_RADIUS_TOP_MEDIUM)
  {
    $this->addClass($borderRadius);
    return $this;
  }

  public function removeBgColour()
  {
    $this->_bgColour = null;
    return $this;
  }

  public function removeBorder()
  {
    $this->_border = null;
    return $this;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panel = Div::create([$this->_buildHeading(), $this->_buildBody()]);
    return $panel->addClass('f-panel');
  }
}
