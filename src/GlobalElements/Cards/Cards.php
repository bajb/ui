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
  /** @var bool */
  protected $_stacked = false;

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
   * @param Card $card
   *
   * @return $this
   */
  public function prependCard(Card $card)
  {
    if($card instanceof Card)
    {
      array_unshift($this->_cards, $card);
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
   * @param bool $value
   *
   * @return $this
   */
  public function stacked($value = true)
  {
    $this->_stacked = $value;
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
    }
  }

  /**
   * @return Div
   */
  protected function _produceHtml()
  {
    $cards = Div::create()->addClass('ui-cards');

    if($this->_cards)
    {
      $minActionsCount = 0;
      $minPropertiesCount = 0;

      foreach($this->_cards as $card)
      {
        if($card instanceof Card)
        {
          /**
           * Define action count for all cards in this collection.
           * This is required for consistent .actions column widths.
           */
          $actionsItems = count($card->getActionTypes());
          $minActionsCount = (($actionsItems > $minActionsCount) ? $actionsItems : $minActionsCount);

          /**
           * Define property count for all cards in this collection.
           * This is predominantly used as a tag for now.
           */
          $propertyCount = $card->getPropertyCount();
          $minPropertiesCount = (($propertyCount > $minPropertiesCount) ? $propertyCount : $minPropertiesCount);

          $cards->appendContent($card);
        }
      }

      // set layout style
      $cards->addClass($this->_layout);

      // additional attributes for potential styling
      $cards->setAttribute('data-action-count', $minActionsCount);
      $cards->setAttribute('data-property-count', $minPropertiesCount);

      if($this->_stacked)
      {
        $cards->addClass('stacked');
      }
    }

    $this->_applyDataAttributes($cards);
    $this->_applyId($cards);

    return $cards;
  }

}
