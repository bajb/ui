<?php
namespace Fortifi\Ui\PageElements\Hero;

use Fortifi\Ui\PageElements\HeroItemBar\HeroItemBar;
use Fortifi\Ui\PageElements\HeroSticker\HeroSticker;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class Hero extends UiElement
{
  protected $_sticker;
  protected $_itemBar;
  protected $_content;

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/PageElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/PageElements/Hero');
    }
  }

  /**
   * @return HeroSticker
   */
  public function getSticker()
  {
    return $this->_sticker;
  }

  /**
   * @param HeroSticker $sticker
   *
   * @return Hero
   */
  public function setSticker(HeroSticker $sticker)
  {
    $this->_sticker = $sticker;
    return $this;
  }

  /**
   * @return HeroItemBar
   */
  public function getItemBar()
  {
    return $this->_itemBar;
  }

  /**
   * @param HeroItemBar $itemBar
   *
   * @return Hero
   */
  public function setItemBar(HeroItemBar $itemBar)
  {
    $this->_itemBar = $itemBar;
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
   * @return Hero
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  protected function _produceHtml()
  {
    $wrap = Div::create();
    $hero = Div::create($wrap)->addClass('f-hero');
    if($this->_sticker)
    {
      $wrap->appendContent($this->_sticker);
      $hero->addClass('with-sticker');
    }
    if($this->_itemBar)
    {
      $wrap->appendContent($this->_itemBar);
      $hero->addClass('with-item-bar');
    }
    $wrap->appendContent($this->_content);
    return $hero;
  }
}
