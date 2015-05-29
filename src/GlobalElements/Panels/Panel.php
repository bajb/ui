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
  const STYLE_DEFAULT = 'panel-default';
  const STYLE_PLAIN = 'panel-plain';
  const STYLE_PRIMARY = 'panel-primary';
  const STYLE_INFO = 'panel-info';
  const STYLE_SUCCESS = 'panel-success';
  const STYLE_WARNING = 'panel-warning';
  const STYLE_DANGER = 'panel-danger';

  protected $_classes = [];
  protected $_attributes = [];
  protected $_style = self::STYLE_DEFAULT;
  protected $_bodyPadding;

  protected $_heading;
  protected $_content;
  protected $_footer;

  protected $_headingBg = '#EEF0F4';
  protected $_headingBorder = 'border: 1px solid #d8d8d8';
  protected $_title;
  protected $_icon;
  protected $_actions;
  protected $_status;

  public static function create($content, $title = null, $bodyPadding = true)
  {
    $panel = new static;
    $panel->_content = $content;
    $panel->_title = $title;
    $panel->_bodyPadding = $bodyPadding;
    return $panel;
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

  public function setStyle($style = self::STYLE_DEFAULT)
  {
    $this->_style = $style;
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
    if(!is_array($obj))
    {
      $actions = $obj;
    }
    else
    {
      foreach($obj as $action)
      {
        $actions[] = Span::create($action)->addClass(Ui::MARGIN_MEDIUM_LEFT);
      }
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

  public function addFooter($content)
  {
    $this->_footer = $content;
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

  public function removeBodyPadding()
  {
    $this->_bodyPadding = false;
    return $this;
  }

  protected function _buildHeading()
  {
    if(!$this->_title)
    {
      return false;
    }

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
      Ui::CLEARFIX
    );
  }

  protected function _buildBody()
  {
    if(!$this->_bodyPadding)
    {
      return $this->_content;
    }

    return Div::create($this->_content)->addClass(
      'panel-body'
    );
  }

  protected function _buildFooter()
  {
    $class = 'f-panel-footer';
    if(!$this->_footer)
    {
      return false;
    }

    if($this->_bodyPadding)
    {
      $class = 'panel-footer';
    }

    return Div::create($this->_footer)->addClass($class);
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panel = Div::create(
      [$this->_buildHeading(), $this->_buildBody(), $this->_buildFooter()]
    )->addClass('panel', $this->_style);

    if($this->_style === self::STYLE_PLAIN)
    {
      $panel->addClass(Ui::BG_NONE, Ui::BORDER_NONE, Ui::BOX_SHADOW_NONE);
    }

    foreach($this->_classes as $class)
    {
      $panel->addClass($class);
    }

    return $panel;
  }
}
