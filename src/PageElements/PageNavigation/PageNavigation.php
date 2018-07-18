<?php
namespace Fortifi\Ui\PageElements\PageNavigation;

use Fortifi\Ui\GlobalElements\Panels\ContentPanel;
use Fortifi\Ui\GlobalElements\Panels\PanelHeader;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\ISafeHtmlProducer;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Lists\ListItem;
use Packaged\Glimpse\Tags\Lists\UnorderedList;

class PageNavigation extends UiElement
{
  protected $_items;
  protected $_title;
  protected $_currentLink;

  /**
   * @return mixed
   */
  public function getTitle()
  {
    return $this->_title;
  }

  /**
   * @param mixed $title
   *
   * @return PageNavigation
   */
  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

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
    $nav = new static();
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
    $ul = new UnorderedList();
    $ul->addClass('menu-panel-items');
    $menu = ContentPanel::create($ul)->setStyle();
    foreach($this->_items as $item)
    {
      $listItem = ListItem::create($item[0]);
      if(isset($item[1]) && $item[1])
      {
        $listItem->addClass('selected');
      }
      $ul->addItem($listItem);
    }
    /** @var Div $header */
    if(!empty($this->getTitle()))
    {
      $header = PanelHeader::create($this->getTitle())->produceSafeHTML();
      $header->removeClass('f-panel-heading');
      $menu->prependContent($header);
    }
    return $menu;
  }
}
