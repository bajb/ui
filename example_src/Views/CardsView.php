<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;

class CardsView extends AbstractUiExampleView
{
  protected $_props = [
    'name'            => 'Chris Sparshott',
    'email'           => 'chris.sparshott@fortifi.io',
    'role'            => 'Admin',
    'created'         => '2015-11-26',
    'auto responders' => '26',
    'mailshots'       => '7',
  ];

  protected function _addCardProperties(Card $card, $propertyCount = 2)
  {
    $x = 1;
    foreach($this->_props as $name => $value)
    {
      if($x >= $propertyCount)
      {
        break;
      }
      $card->addProperty($name, $value);
    }
    return $card;
  }

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
    $this->_addCardProperties($card);

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
    $cards->setGridColumnCount(5);

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
