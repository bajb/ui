<?php
namespace Fortifi\Ui\PageElements\HeroSticker;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class HeroSticker extends UiElement
{
  protected $_class = [];
  protected $_content;
  protected $_hasBorder = true;
  protected $_isFlat = false;
  protected $_backgroundImage;

  public function addClass($class)
  {
    $this->_class[$class] = $class;
    return $this;
  }

  public function removeClass($class)
  {
    unset($this->_class[$class]);
    return $this;
  }

  public function clearClasses()
  {
    $this->_class = [];
    return $this;
  }

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/PageElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/PageElements/HeroSticker');
    }
  }

  /**
   * @return bool
   */
  public function hasBorder()
  {
    return $this->_hasBorder;
  }

  /**
   * @return HeroSticker
   */
  public function disableBorder()
  {
    $this->_hasBorder = false;
    return $this;
  }

  /**
   * @return HeroSticker
   */
  public function enableBorder()
  {
    $this->_hasBorder = true;
    return $this;
  }

  /**
   * @return bool
   */
  public function isFlat()
  {
    return $this->_isFlat;
  }

  /**
   * @param bool $isFlat
   *
   * @return HeroSticker
   */
  public function setFlat($isFlat = true)
  {
    $this->_isFlat = $isFlat;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getBackgroundImage()
  {
    return $this->_backgroundImage;
  }

  /**
   * @param mixed $backgroundImage
   *
   * @return HeroSticker
   */
  public function setBackgroundImage($backgroundImage)
  {
    $this->_backgroundImage = $backgroundImage;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @param mixed $content
   *
   * @return HeroSticker
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  protected function _produceHtml()
  {
    $sticker = Div::create($this->_content)->addClass('f-hero-sticker');
    if(!$this->_hasBorder)
    {
      $sticker->addClass(Ui::BORDER_NONE);
    }
    if($this->isFlat())
    {
      $sticker->addClass('f-hero-sticker-flat');
    }
    if($this->_backgroundImage)
    {
      $sticker->setAttribute('style', 'background-image: url(\'' . $this->_backgroundImage . '\'); ');
    }
    return $sticker;
  }

}
