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

  public static function create($content = null)
  {
    $panel = new static;
    $panel->_content = $content;
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

  public function setContent($content)
  {
    if(!$content instanceof PanelContent)
    {
      $content = PanelContent::create($content);
    }
    $this->_content = $content;
    return $this;
  }

  public function setHeading($content)
  {
    if(!$content instanceof PanelHeading)
    {
      $content = PanelHeading::create($content);
    }
    $this->_heading = $content;
    return $this;
  }

  public function setFooter($content)
  {
    if(!$content instanceof PanelFooter)
    {
      $content = PanelFooter::create($content);
    }
    $this->_footer = $content;
    return $this;
  }

  public function setStyle($style = self::STYLE_DEFAULT)
  {
    $this->_style = $style;
    return $this;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panel = Div::create(
      [$this->_heading, $this->_content, $this->_footer]
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
