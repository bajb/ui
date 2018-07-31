<?php
namespace Fortifi\Ui\PageElements\HeroProgress;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class HeroProgress extends UiElement
{
  protected $_items = [];

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/PageElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/PageElements/HeroProgress');
      $assetManager->requireJs('https://use.fontawesome.com/releases/v5.0.13/js/all.js');
    }
  }

  public function addItem(HeroProgressItem $item)
  {
    $this->_items[] = $item;
    return $this;
  }

  protected function _produceHtml()
  {
    $progress = Div::create('')->addClass('f-hero-progress');
    foreach($this->_items as $item)
    {
      $progress->appendContent($item);
    }
    return $progress;
  }

}
