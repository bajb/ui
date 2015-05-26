<?php
namespace Fortifi\Ui\PageElements\PageNavigation;

use Fortifi\Ui\ContentElements\ObjectLists\ObjectList;
use Fortifi\Ui\ContentElements\ObjectLists\ObjectListCard;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\ISafeHtmlProducer;
use Packaged\Glimpse\Core\SafeHtml;

class PageNavigation extends UiElement
{
  protected $_items;
  protected $_currentLink;

  /**
   * Require Assets
   *
   * @param AssetManager $assetManager
   * @param bool         $vendor
   */
  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/PageElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/PageElements/PageNavigation');
    }
  }

  public static function create($currentLink = null)
  {
    $nav = new static;
    $nav->_currentLink = $currentLink;
    return $nav;
  }

  public function addItem(ISafeHtmlProducer $content, $selected = false)
  {
    if(!$selected && $content instanceof HtmlTag)
    {
      if($content->getAttribute('href') == $this->_currentLink)
      {
        $selected = true;
      }
    }
    $this->_items[] = [$content, $selected];
    return $this;
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    $list = ObjectList::i();
    $list->setStacked(true, false);
    foreach($this->_items as $item)
    {
      $card = ObjectListCard::i();
      $card->setTitle($item[0]);
      if($item[1])
      {
        $card->setColour($card::COLOUR_SKY);
      }
      $list->addCard($card);
    }
    return $list;
  }
}
