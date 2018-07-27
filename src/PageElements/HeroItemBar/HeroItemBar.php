<?php
namespace Fortifi\Ui\PageElements\HeroItemBar;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;

class HeroItemBar extends UiElement
{
  protected $items = [];

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/PageElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/PageElements/HeroItemBar');
    }
  }

  public function add($label, $value)
  {
    $this->items[$label] = $value;
    return $this;
  }

  protected function _produceHtml()
  {
    $itemBar = Div::create('')->addClass('f-hero-item-bar');
    foreach($this->items as $label => $value)
    {
      $itemBar->appendContent(Div::create([HeadingOne::create($value), Paragraph::create($label)]));
    }
    return $itemBar;
  }

}
