<?php
namespace Fortifi\Ui\ContentElements\Statistics;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;

class Statistic extends UiElement
{
  protected $_title;
  protected $_value;
  /** @var FaIcon */
  protected $_icon;

  public static function create($title, $value, FaIcon $icon = null)
  {
    $stat = static::i();
    $stat->_title = $title;
    $stat->_value = $value;
    $stat->_icon = $icon;
    return $stat;
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

    return Div::create($content)->addClass('f-statistic');
  }

}
