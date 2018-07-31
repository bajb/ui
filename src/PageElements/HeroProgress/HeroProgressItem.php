<?php
namespace Fortifi\Ui\PageElements\HeroProgress;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\StrongText;

class HeroProgressItem extends UiElement
{
  const STATE_DONE = 'done';
  const STATE_CURRENT = 'current';
  const STATE_NONE = '';

  const DEFAULT_CLASS = 'f-hero-progress-pending';

  protected $_title;
  protected $_info;
  /**
   * @var FaIcon
   */
  protected $_icon;
  protected $_state;
  protected $_link;

  protected $_class = self::DEFAULT_CLASS;

  /**
   * @return mixed
   */
  public function getTitle()
  {
    return $this->_title;
  }

  /**
   * @param mixed $title
   *
   * @return HeroProgressItem
   */
  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getInfo()
  {
    return $this->_info;
  }

  /**
   * @param mixed $label
   *
   * @return HeroProgressItem
   */
  public function setInfo($label)
  {
    $this->_info = $label;
    return $this;
  }

  /**
   * @return FaIcon
   */
  public function getIcon()
  {
    return $this->_icon;
  }

  /**
   * @param FaIcon $icon
   *
   * @return HeroProgressItem
   */
  public function setIcon(FaIcon $icon)
  {
    $this->_icon = $icon;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getState()
  {
    return $this->_state;
  }

  /**
   * @param mixed $state
   *
   * @return HeroProgressItem
   */
  public function setState($state)
  {
    if($state == self::STATE_DONE && (!$this->_class || $class = self::DEFAULT_CLASS))
    {
      $this->setClass(Ui::BG_WHITE);
    }
    $this->_state = $state;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getLink()
  {
    return $this->_link;
  }

  /**
   * @param mixed $link
   *
   * @return HeroProgressItem
   */
  public function setLink($link)
  {
    $this->_link = $link;
    return $this;
  }

  /**
   * @return array|string
   */
  public function getClass()
  {
    return $this->_class;
  }

  /**
   * @param string|array $class
   *
   * @return HeroProgressItem
   */
  public function setClass($class)
  {
    $this->_class = $class;
    return $this;
  }

  protected function _produceHtml()
  {
    $content = [
      StrongText::create($this->_title),
      Div::create(Div::create($this->_icon->sizeX2())->addClass($this->_class)),
      Span::create($this->_info),
    ];
    if($this->_link instanceof PageletLink)
    {
      $content = $this->_link->setContent($content);
    }
    return Div::create($content)->addClass('f-hero-progress-item', $this->_state);
  }

}
