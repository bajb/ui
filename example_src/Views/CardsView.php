<?php
namespace Fortifi\UiExample\Views;

use Carbon\Carbon;
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
    'name'            => 'Richard Gooding',
    'email'           => 'richard.gooding@fortifi.io',
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
    $propertyCount = mt_rand(0, count($properties));
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
   * @return mixed
   */
  protected function _getAvatar()
  {
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

    return $avatars[rand(0, (count($avatars) - 1))];
  }

  /**
   * @return HtmlTag
   */
  protected function _getInsecureIcon()
  {
    return FontIcon::stack(
      FontIcon::create(FontIcon::LOCK),
      FontIcon::create('fa-circle-o')->addClass(Ui::TEXT_ORANGE)
    );
  }

  /**
   * @return HtmlTag
   */
  protected function _getArchivedUserIcon()
  {
    return FontIcon::stack(
      FontIcon::create(FontIcon::USER),
      FontIcon::create(FontIcon::BAN)->addClass(Ui::TEXT_RED)
    );
  }

  /**
   * @return string
   */
  protected function _getRandomActionType()
  {
    $actions = CardActionType::getValues();
    return $actions[mt_rand(0, count($actions) - 1)];
  }

  /**
   * @return string
   */
  protected function _getRandomEmail()
  {
    $items = [
      'chris.sparshott@fortifi.io',
      'b@bajb.net',
      'admin@development.local',
      'james.eagle@justdevelop.it',
      't@jdi.io',
      'richard.gooding@justdevelop.it',
    ];

    return $items[mt_rand(0, (count($items) - 1))];
  }

  /**
   * @return string
   */
  protected function _getRandomDisplayName()
  {
    $items = [
      'Chris Sparshott',
      'Richard Gooding',
      'Brooke Bryan',
      'Tom Kay',
    ];

    return $items[mt_rand(0, (count($items) - 1))];
  }

  /**
   * @return string
   */
  protected function _getRandomJobTitle()
  {
    $items = [
      'developer',
      'support manager',
      'support agent',
      'billing supervisor',
      'affiliate marketing manager',
      'jobsworth',
      'tea bitch',
    ];

    return $items[rand(0, (count($items) - 1))];
  }

  /**
   * @return string
   */
  protected function _getRandomColour()
  {
    $colours = Colour::getValues();
    return $colours[mt_rand(0, (count($colours) - 1))];
  }

  /**
   * @param Card $card
   * @param int  $qty
   *
   * @return Card
   */
  protected function _addRandomActions(Card $card, $qty = 3)
  {
    $link = new PageletLink('/some-url', null);
    $link->setAjaxUri('/some-ajax-url');

    $actions = [];
    while(count($actions) < $qty)
    {
      $actions[] = $card->addAction($this->_getRandomActionType(), $link);
    }

    return $card;
  }

  /**
   * @return string
   */
  protected function _getRandomHumanDate()
  {
    return Carbon::createFromTimestamp(strtotime('-' . mt_rand(1, 48) . ' months'))->diffForHumans();
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
    $card->setLabel('Label that could be really long and obscure icons that appear');
    $card->setTitle($title);
    $card->setDescription(
      'The description. This could be really long, or it could be really shirt. ' .
      'Either way, we should make sure it looks ok when used inside a card, ' .
      'because we would not want it to break the layout now, would we, eh?'
    );
    $this->_addCardProperties($card);

    // add avatar
    $card->setAvatar($this->_getAvatar());

    // add actions
    $link = new PageletLink('/some-url', null);
    $link->setAjaxUri('/some-ajax-url');

    $this->_addRandomActions($card);

    // add icons
    $card->addIcon($this->_getArchivedUserIcon());
    $card->addIcon($this->_getInsecureIcon());

    // set border colour
    $card->setColour($this->_getRandomColour());

    return $card;
  }

  /**
   * @param      $title
   * @param null $label
   * @param null $description
   *
   * @return Card
   */
  protected function _createQuickCard($title, $label = null, $description = null)
  {
    $card = Card::i();
    $card->setTitle($title);

    if($label)
    {
      $card->setLabel($label);
    }

    if($description)
    {
      $card->setDescription($description);
    }

    return $card;
  }

  /**
   * @return Cards[]
   */
  protected function _getCards()
  {
    $cards = [];
    while(count($cards) < 10)
    {
      $cards[] = $this->_getCard();
    }
    return $cards;
  }

  /**
   * @return Card
   */
  protected function _createEmployeeCard()
  {
    $card = $this->_createQuickCard($this->_getRandomDisplayName(), $this->_getRandomJobTitle());
    $card->setAvatar($this->_getAvatar());
    $card->addIcon($this->_getInsecureIcon());
    $card->addIcon($this->_getArchivedUserIcon());

    $card->addProperty('role', $this->_getRandomJobTitle());
    $card->addProperty('email address', $this->_getRandomEmail(), true);
    $card->addProperty('email address', $this->_getRandomEmail(), true);
    $card->addProperty('email address', $this->_getRandomEmail(), true);

    $this->_addRandomActions($card);

    return $card;
  }

  /**
   * ================================================
   *
   * Create cards for output
   *
   * ================================================
   */

  /**
   * @group Cards
   */
  final public function employeeRolesCards()
  {
    $items = [];
    while(count($items) < 5)
    {
      $card = $this->_createQuickCard($this->_getRandomJobTitle());
      $this->_addRandomActions($card, 1);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->addCards($items);
    return $cards;
  }

  /**
   * @group Cards
   */
  final public function departmentQueueCards()
  {
    $items = [];
    while(count($items) < 5)
    {
      $card = $this->_createQuickCard($this->_getRandomJobTitle());
      $card->addProperty('Created', $this->_getRandomHumanDate());
      $this->_addRandomActions($card, 1);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->addCards($items);
    return $cards;
  }

  /**
   * @group Cards
   */
  final public function eventManagementCards()
  {
    $type = ['First Occurrence', 'Standard', 'Built in'];

    $items = [];
    while(count($items) < 5)
    {
      $card = $this->_createQuickCard(
        'Customer Subscription Renewal Hard Fail',
        'CUSTOMER.SUBSCRIPTION.RENEWAL.HARD.FAIL'
      );
      $card->addProperty('type', $type[(mt_rand(0, count($type) - 1))]);
      $card->addProperty('type', $type[(mt_rand(0, count($type) - 1))]);
      $card->addProperty('type', $type[(mt_rand(0, count($type) - 1))]);
      $card->addProperty('type', $type[(mt_rand(0, count($type) - 1))]);
      $this->_addRandomActions($card, 2);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->addCards($items);
    $cards->stacked();
    return $cards;
  }

  /**
   * @group Cards
   */
  final public function employeeCards()
  {
    $items = [];
    while(count($items) < 5)
    {
      $items[] = $this->_createEmployeeCard();
    }

    $cards = Cards::i();
    $cards->addCards($items);
    return $cards;
  }

  /**
   * @group Cards
   */
  final public function paymentMethodCards()
  {
    $items = [];
    while(count($items) < 5)
    {
      $card = $this->_createQuickCard(
        'Account Balance',
        null,
        'Automatic, PayPal ID: FER2RX8U6SNTW, Email: sales-lowbuyer@fortifi.uk'
      );

      $icon = HtmlTag::createTag('i');
      $icon->addClass('fa', 'fa-icon', 'fa-cc-paypal');
      $icon->setAttribute('style', 'font-size: 28px;');

      $card->addProperty('Payment Method', $icon);

      // create actions
      $this->_addRandomActions($card);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->addCards($items);
    return $cards;
  }
}
