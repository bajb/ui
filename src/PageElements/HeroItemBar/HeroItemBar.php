<?php
namespace Fortifi\Ui\PageElements\HeroItemBar;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;

class HeroItemBar extends UiElement
{
  protected $items = [];

  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/PageElements.min.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/PageElements/HeroItemBar.css');
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
