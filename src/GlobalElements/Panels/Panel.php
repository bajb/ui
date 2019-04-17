<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Div;

class Panel extends UiElement
{
  const STYLE_PLAIN = 'panel-plain';
  const STYLE_DEFAULT = 'panel-default';
  const STYLE_PRIMARY = 'panel-primary';
  const STYLE_INFO = 'panel-info';
  const STYLE_SUCCESS = 'panel-success';
  const STYLE_WARNING = 'panel-warning';
  const STYLE_DANGER = 'panel-danger';

  protected $_classes = [];
  protected $_attributes = [];
  protected $_style = self::STYLE_PLAIN;
  protected $_bodyPadding;

  protected $_header;
  protected $_content = [];

  protected $_title;
  protected $_icon;
  protected $_actions;
  protected $_status;

  public static function create($content = null)
  {
    $panel = new static;
    $panel->_content[] = $content;
    return $panel;
  }

  /**
   * Require Assets
   *
   * @param ResourceManager $resourceManager
   * @param bool            $vendor
   */
  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/GlobalElements.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/GlobalElements/Panels.css');
    }
  }

  public function addClass($class)
  {
    $this->_classes[] = $class;
    return $this;
  }

  public function addAttribute($key, $value)
  {
    $this->_attributes[$key] = $value;
  }

  public function setContent($content)
  {
    if(!is_array($content))
    {
      $content = [$content];
    }
    $this->_content = $content;
    return $this;
  }

  public function prependContent($content)
  {
    array_unshift($this->_content, $content);
    return $this;
  }

  public function appendContent($content)
  {
    $this->_content[] = $content;
    return $this;
  }

  /**
   * $content can be of type String or PanelHeader
   *
   * @param $content
   *
   * @return $this
   */
  public function setHeader($content)
  {
    if($content instanceof PanelHeader)
    {
      $this->_header = $content;
    }
    else if(is_scalar($content))
    {
      $this->_header = PanelHeader::create($content);
    }
    else if(is_array($content))
    {
      $this->_header = PanelHeader::create($content);
    }
    return $this;
  }

  public function setStyle($style = self::STYLE_PLAIN)
  {
    $this->_style = $style;
    return $this;
  }

  public function getContent()
  {
    return $this->_content;
  }

  public function getHeader()
  {
    return $this->_header;
  }

  public function getStyle()
  {
    return $this->_style;
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $panel = Div::create([$this->getHeader(), $this->getContent()])
      ->addClass('f-panel', 'panel', $this->getStyle());

    foreach($this->_classes as $class)
    {
      $panel->addClass($class);
    }

    foreach($this->_attributes as $key => $value)
    {
      $panel->setAttribute($key, $value);
    }

    return $panel;
  }
}
