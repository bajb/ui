<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\Ui\Enums\Cards\CardMaxProperties;
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
   * @return $this
   */
  public function stacked()
  {
    $this->_stacked = true;
    return $this;
  }

  /**
   * @param int $columns
   *
   * @return $this
   */
  public function setGridColumnCount($columns = 1)
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

      // If any child card contains more than CardMaxProperties, Layout type is GRID and column display should be 1
      if($minPropertiesCount > CardMaxProperties::LIST_CARD)
      {
        $this->_layout = self::LAYOUT_GRID;
        $this->_columns = 1;
      }

      // define local layout vars
      $isGrid = ($this->_layout === self::LAYOUT_GRID);
      $isList = ($this->_layout === self::LAYOUT_LIST);
      $isSingleColumn = ($this->_columns == 1);

      // set layout style
      $cards->addClass($this->_layout);

      if($isGrid)
      {
        $cards->setAttribute('data-columns', $this->_columns);
      }

      // additional attributes for potential styling
      $cards->setAttribute('data-action-count', $minActionsCount);
      $cards->setAttribute('data-property-count', $minPropertiesCount);

      // stack cards
      if($this->_stacked && ($isList || ($isGrid && $isSingleColumn)))
      {
        $cards->addClass('stacked');
      }
    }

    $this->_applyDataAttributes($cards);
    $this->_applyId($cards);

    return $cards;
  }

}
