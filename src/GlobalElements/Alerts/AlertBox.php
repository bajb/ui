<?php
namespace Fortifi\Ui\GlobalElements\Alerts;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class AlertBox extends UiElement
{
  const STYLE_INFO = 'alert-info';
  const STYLE_SUCCESS = 'alert-success';
  const STYLE_WARNING = 'alert-warning';
  const STYLE_DANGER = 'alert-danger';

  protected $_classes = [];
  protected $_attributes = [];
  protected $_style = self::STYLE_INFO;
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
      $assetManager->requireCss('assets/css/GlobalElements/Alerts');
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

  public function setStyle($style = self::STYLE_INFO)
  {
    $this->_style = $style;
    return $this;
  }

  public function getContent()
  {
    return $this->_content;
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
    $panel = Div::create($this->getContent())
      ->addClass('f-alert', 'alert', $this->getStyle());

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
