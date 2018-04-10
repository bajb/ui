<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\Enums\Colour;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Core\HtmlTag;
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
    $propertyCount = mt_rand(0, count($this->_props));
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

    // add avatar
    $avatars = [
      FontIcon::create(FontIcon::USER),
      HtmlTag::createTag(
        'img',
        ['src' => 'https://pbs.twimg.com/profile_images/943069281171968000/UNiJSeWn_400x400.jpg']
      ),
      HtmlTag::createTag(
        'img',
        ['src' => 'https://media.giphy.com/media/5UMFdWbgwa3rtfYbXK/giphy.gif']
      ),
      HtmlTag::createTag(
        'img',
        ['src' => 'https://media.giphy.com/media/xUOwGiewfQAm3tcIA8/giphy.gif']
      ),
      HtmlTag::createTag(
        'img',
        ['src' => 'https://media.giphy.com/media/26DN81TqLPIzBlksw/giphy.gif']
      ),
      HtmlTag::createTag(
        'img',
        ['src' => 'https://media.giphy.com/media/xUOwFXS9fm76vBcuTC/giphy.gif']
      ),
    ];

    $card->setAvatar($avatars[rand(0, (count($avatars) - 1))]);

    // add actions
    $link = new PageletLink('/some-url', null);
    $link->setAjaxUri('/some-ajax-url');

    $actions = CardActionType::getValues();
    $idx = mt_rand(0, count($actions) - 1);
    $limit = 5;
    for($n = 0; $n < $limit; $n++)
    {
      $card->addAction($actions[$idx]);
      $idx = mt_rand(0, count($actions) - 1);
    }

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

    // set border colour
    $colours = Colour::getValues();
    $card->setColour($colours[rand(0, (count($colours) - 1))]);

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
    $cards->setGridColumnCount(3);

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
