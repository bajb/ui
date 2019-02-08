<?php
namespace Fortifi\Ui\ContentElements\Flipper;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Div;

class Flipper extends UiElement
{
  protected $_width;
  protected $_height;
  protected $_frontContent;
  protected $_backContent;
  protected $_vertical = false;

  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/ContentElements.min.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/ContentElements/flipper.css');
    }
  }

  public static function create(
    $front, $back, $width = '100px', $height = '16px'
  )
  {
    $flipper = new static;

    $flipper->_frontContent = $front;
    $flipper->_backContent = $back;

    if(is_int($width))
    {
      $width = $width . 'px';
    }
    $flipper->_width = $width;

    if(is_int($height))
    {
      $height = $height . 'px';
    }
    $flipper->_height = $height;

    return $flipper;
  }

  public function setVertical($vertical = true)
  {
    $this->_vertical = $vertical;
    return $this;
  }

  protected function _produceHtml()
  {
    $div = Div::create(
      [
        Div::create($this->_frontContent)->addClass('front'),
        Div::create($this->_backContent)->addClass('back'),
      ]
    );
    $div->addClass('flip-container')
      ->setAttribute('ontouchstart', 'this.classList.toggle(\'hover\')')
      ->setAttribute(
        'style',
        'width:' . $this->_width . ';height:' . $this->_height
      );
    if($this->_vertical)
    {
      $div->addClass('vertical');
    }
    return $div;
  }
}
