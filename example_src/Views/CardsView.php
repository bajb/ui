<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;

class CardsView extends AbstractUiExampleView
{

  /**
   * @return Card
   */
  protected function _getCard()
  {
    // create Title
    $title = PageletLink::create('/some-url', 'Some Title');
    $title->setAjaxUri('/some-ajax-url');

    $card = Card::i();
    $card->setTitle($title);
    $card->setLabel('Label');
    $card->setDescription('The description');

    // add actions
    $card->addAction();
    $card->addAction(CardActionType::ACTION_TYPE_EDIT, '/edit', '/edit-ajax');
    $card->addAction(CardActionType::ACTION_TYPE_CREATE, '/create', '/create-ajax');

    return $card;
  }

  /**
   * @return Cards[]
   */
  protected function _getCards()
  {
    return [
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
      $this->_getCard(),
    ];
  }

  /**
   * @group Cards
   */
  final public function cardsGrid()
  {
    $cards = Cards::i();
    $cards->setLayout($cards::LAYOUT_GRID);
    $cards->addCards($this->_getCards());

    return $cards;
  }

  /**
   * @group Cards
   */
  final public function cardsList()
  {
    $cards = Cards::i();
    $cards->setLayout($cards::LAYOUT_LIST);
    $cards->addCards($this->_getCards());

    return $cards;
  }
}
