<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
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
   * @param AssetManager $assetManager
   * @param bool         $vendor
   */
  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/GlobalElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/GlobalElements/Panels');
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
    $this->_content = (array)$content;
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
   * @throws \Exception
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
