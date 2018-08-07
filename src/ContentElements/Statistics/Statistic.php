<?php
namespace Fortifi\Ui\ContentElements\Statistics;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

class Statistic extends UiElement
{
  protected $_title;
  protected $_value;
  /** @var FaIcon */
  protected $_icon;
  /**
   * @var PageletLink
   */
  protected $_link;
  protected $_append;

  public static function create($title, $value, FaIcon $icon = null)
  {
    $stat = static::i();
    $stat->_title = $title;
    $stat->_value = $value;
    $stat->_icon = $icon;
    return $stat;
  }

  public function setLink(PageletLink $link)
  {
    $this->_link = $link;
    return $this;
  }

  public function appendContent($content)
  {
    $this->_append = $content;
    return $this;
  }

  protected function _produceHtml()
  {
    $content = [];
    if($this->_icon)
    {
      //$this->_icon->sizeX2();
      $this->_icon->sizeLarge();
      $content[] = Div::create($this->_icon)->addClass('f-statistic-icon');
    }

    $content[] = Div::create(
      [
        Div::create($this->_value)->addClass('f-statistic-value'),
        Div::create($this->_title)->addClass('f-statistic-title'),
      ]
    );

    if($this->_append)
    {
      $content[] = Div::create($this->_append)->addClass('f-statistic-append');
    }

    if($this->_link)
    {
      return $this->_link->setContent($content)->addClass('f-statistic');
    }
    else
    {
      return Div::create($content)->addClass('f-statistic');
    }
  }

}
