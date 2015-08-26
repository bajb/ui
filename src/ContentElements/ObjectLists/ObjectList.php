<?php
namespace Fortifi\Ui\ContentElements\ObjectLists;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Lists\UnorderedList;

class ObjectList extends UiElement
{
  /**
   * @var ObjectListCard[]
   */
  protected $_items = [];

  //0 = false, 1 = true, 2 = std border
  protected $_stacked = 0;

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/ObjectLists');
    }
  }

  /**
   * Add cards to the list
   *
   * @param ObjectListCard $card
   *
   * @return $this
   */
  public function addCard(ObjectListCard $card)
  {
    $this->_items[] = $card;
    return $this;
  }

  /**
   * Stack cards together
   *
   * @param bool $stack
   * @param bool $smallLeftBorder
   *
   * @return $this
   */
  public function setStacked($stack = true, $smallLeftBorder = true)
  {
    $this->_stacked = $stack ? ($smallLeftBorder ? 1 : 2) : 0;
    return $this;
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    $list = UnorderedList::create();
    $list->addClass('f-obj-lst');
    if($this->_stacked > 0)
    {
      $list->addClass('f-obj-lst-stacked');
      if($this->_stacked == 1)
      {
        $list->addClass('f-obj-lst-stacked-min-border');
      }
    }
    $list->addItems($this->_items);
    return $list;
  }

  /**
   * @return ObjectListCard[]
   */
  public function getItems()
  {
    return $this->_items;
  }
}
