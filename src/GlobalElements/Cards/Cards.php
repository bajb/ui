<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\Ui\Interfaces\ILayout;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Lists\UnorderedList;

class Cards extends UiElement implements ILayout
{
  /** @var array */
  protected $_cards = [];
  /** @var string */
  protected $_layout = self::LAYOUT_LIST;

  /**
   * @param Card $card
   *
   * @return $this
   */
  public function addCard(Card $card)
  {
    if($card instanceof Card)
    {
      $this->_cards[] = $card;
    }
    return $this;
  }

  /**
   * @param Card[] $cards
   *
   * @return $this
   */
  public function addCards(array $cards)
  {
    foreach($cards as $card)
    {
      if($card instanceof Card)
      {
        $this->_cards[] = $card;
      }
    }
    return $this;
  }

  /**
   * @param string $layout
   *
   * @return $this
   */
  public function setLayout($layout = self::LAYOUT_LIST)
  {
    $this->_layout = $layout;
    return $this;
  }

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/Cards');
    }
  }

  /**
   * @return UnorderedList
   */
  protected function _produceHtml()
  {
    $cards = UnorderedList::create()->addClass('ui-cards');
    $cards->addClass($this->_layout);

    if($this->_cards)
    {
      foreach($this->_cards as $card)
      {
        if($card instanceof Card)
        {
          $cards->appendContent($card);
        }
      }
    }
    return $cards;
  }

}
