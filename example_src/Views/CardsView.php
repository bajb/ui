<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Packaged\Helpers\Arrays;

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

  /**
   * @param Card $card
   *
   * @return Card
   */
  protected function _addCardProperties(Card $card)
  {
    $properties = Arrays::shuffleAssoc($this->_props);
    $propertyCount = rand(0, count($this->_props));
    $x = 0;
    foreach($properties as $name => $value)
    {
      if($x >= $propertyCount)
      {
        break;
      }
      $card->addProperty($name, $value);
      $x++;
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
    $card->setLabel('Label that could be really long and obscure icons that appear');
    $card->setDescription(
      'The description. This could be really long, or it could be really shirt. ' .
      'Either way, we should make sure it looks ok when used inside a card, ' .
      'because we would not want it to break the layout now, would we, eh?'
    );
    $this->_addCardProperties($card);

    // add actions
    $card->addAction(CardActionType::ACTION_TYPE_EDIT, '/edit', '/edit-ajax');
    $card->addAction(CardActionType::ACTION_TYPE_IS_DEFAULT, '/is-default', '/is-default-ajax');
    $card->addAction(CardActionType::ACTION_TYPE_CREATE, '/create', '/create-ajax');
    $card->addAction(CardActionType::ACTION_TYPE_DELETE, '/delete', '/delete-ajax');

    // add icons
    $banUser = FontIcon::stack(
      FontIcon::create(FontIcon::USER),
      FontIcon::create(FontIcon::BAN)->addClass(Ui::TEXT_RED)
    );
    $insecure = FontIcon::stack(
      FontIcon::create(FontIcon::LOCK),
      FontIcon::create('fa-circle-o')->addClass(Ui::TEXT_ORANGE)
    );

    $card->addIcon($banUser);
    $card->addIcon($insecure);

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
