<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\Ui\Interfaces\ILayout;
use Fortifi\Ui\Traits\DataAttributesTrait;
use Fortifi\Ui\Traits\SetIdTrait;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class Cards extends UiElement implements ILayout
{
  use SetIdTrait;
  use DataAttributesTrait;

  /** @var Card[] */
  protected $_cards = [];
  /** @var string */
  protected $_layout = self::LAYOUT_LIST;
  /** @var int */
  protected $_columns = 4;

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
   * @return Card[]
   */
  public function getCards()
  {
    return $this->_cards;
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

  /**
   * @param int $columns
   *
   * @return $this
   */
  public function setGridColumnCount($columns = 4)
  {
    $this->_columns = $columns;
    return $this;
  }

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
      $assetManager->requireJs('assets/js/GlobalElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/Cards');
      $assetManager->requireJs('assets/js/GlobalElements/copy-to-clipboard');
    }
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $cards = Div::create()->addClass('ui-cards');
    $cards->addClass($this->_layout);

    if($this->_layout === self::LAYOUT_GRID)
    {
      $cards->setAttribute('data-columns', $this->_columns);
    }

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

    $this->_applyDataAttributes($cards);
    $this->_applyId($cards);

    return $cards;
  }

}
