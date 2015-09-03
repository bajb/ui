<?php
namespace Fortifi\Ui\ContentElements\Flipper;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class Flipper extends UiElement
{
  protected $_width;
  protected $_height;
  protected $_frontContent;
  protected $_backContent;

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/flipper');
    }
  }

  public static function create($width, $height, $front, $back)
  {
    $flipper = new static;
    $flipper->_width = $width;
    $flipper->_height = $height;
    $flipper->_frontContent = $front;
    $flipper->_backContent = $back;
    return $flipper;
  }

  protected function _produceHtml()
  {
    return Div::create(
      [
        Div::create($this->_frontContent)->addClass('front'),
        Div::create($this->_backContent)->addClass('back'),
      ]
    )
      ->addClass('flip-container')
      ->setAttribute('ontouchstart', 'this.classList.toggle(\'hover\')')
      ->setAttribute(
        'style',
        'width:' . $this->_width . ';height:' . $this->_height
      );
  }
}
