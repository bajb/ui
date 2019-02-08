<?php
namespace Fortifi\Ui\PageElements\PageNavigation;

use Fortifi\Ui\GlobalElements\Panels\Panel;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Lists\ListItem;
use Packaged\Glimpse\Tags\Lists\UnorderedList;
use Packaged\SafeHtml\ISafeHtmlProducer;
use Packaged\SafeHtml\SafeHtml;

class PageNavigation extends UiElement
{
  protected $_items = [];
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
   * @param ResourceManager $resourceManager
   * @param bool            $vendor
   */
  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/PageElements.min.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/PageElements/PageNavigation.css');
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
    $menu = Panel::create($ul)->addClass('f-page-navigation')->setStyle();
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
      $menu->prependContent(Div::create($this->getTitle()));
    }
    return $menu;
  }
}
