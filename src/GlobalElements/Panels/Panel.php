<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

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

  public function addClass($class)
  {
    $this->_classes[] = $class;
    return $this;
  }

  public function setContent($content)
  {
    $this->_content[] = $content;
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
   * @param $content
   *
   * @return $this
   * @throws \Exception
   */
  public function setHeader($content)
  {
    if(!$content instanceof PanelHeader)
    {
      if(gettype($content) === 'string')
      {
        $this->_header = PanelHeader::create($content);
      }
    }
    else
    {
      $this->_header = $content;
    }
    return $this;
  }

  public function setStyle($style = self::STYLE_DEFAULT)
  {
    $this->_style = $style;
    return $this;
  }

  public function getContent()
  {
    $this->setStyle(self::STYLE_PLAIN);
    $this->addClass(Ui::BG_NONE);
    $this->addClass(Ui::BOX_SHADOW_NONE);
    return $this->_content;
  }

  public function getHeader()
  {
    if($this->_header && !$this->_header instanceof PanelHeader)
    {
      throw new \Exception('Returned property must be of type PanelHeader');
    }
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
      ->addClass('panel', $this->getStyle());

    foreach($this->_classes as $class)
    {
      $panel->addClass($class);
    }

    return $panel;
  }
}
