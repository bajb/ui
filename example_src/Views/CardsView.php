<?php
namespace Fortifi\UiExample\Views;

use Carbon\Carbon;
use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Avatar\Avatar;
use Fortifi\Ui\ContentElements\Avatar\TextAvatar;
use Fortifi\Ui\ContentElements\Chips\Chip;
use Fortifi\Ui\ContentElements\Chips\Chips;
use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\Enums\Colour;
use Fortifi\Ui\GlobalElements\Cards\Card;
use Fortifi\Ui\GlobalElements\Cards\Cards;
use Fortifi\Ui\GlobalElements\Cards\ContentCard;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Elements\LineBreak;
use Packaged\Glimpse\Tags\Span;
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
      Avatar::i()->setContent(FontIcon::create(FontIcon::USER)),
      Avatar::image('https://pbs.twimg.com/profile_images/943069281171968000/UNiJSeWn_400x400.jpg'),
      Avatar::image('https://media.giphy.com/media/5UMFdWbgwa3rtfYbXK/giphy.gif'),
      Avatar::image('https://media.giphy.com/media/xUOwGiewfQAm3tcIA8/giphy.gif'),
      Avatar::image('https://media.giphy.com/media/26DN81TqLPIzBlksw/giphy.gif'),
      Avatar::image('https://media.giphy.com/media/xUOwFXS9fm76vBcuTC/giphy.gif'),
      TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_GREEN),
      TextAvatar::create("John Smith")->setColour(TextAvatar::COLOUR_RED),
    ];

    return $avatars[rand(0, (count($avatars) - 1))];
  }

  /**
   * @return Span
   */
  protected function _getInsecureIcon()
  {
    return FaIcon::layers(
      FaIcon::create(FaIcon::LOCK),
      FaIcon::create(FaIcon::CIRCLE_NOTCH)->grow(16)->addClass(Ui::TEXT_ORANGE)
    )->addClass(Ui::MARGIN_MEDIUM_LEFT);
  }

  /**
   * @return Span
   */
  protected function _getArchivedUserIcon()
  {
    return FaIcon::layers(
      FaIcon::create(FaIcon::USER),
      FaIcon::create(FaIcon::BAN)->grow(16)->addClass(Ui::TEXT_RED)
    )->addClass(Ui::MARGIN_MEDIUM_LEFT);
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
   * @return Card[]
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
    $card->setDescription("Job Role Description");

    $card->addProperty('role', $this->_getRandomJobTitle());
    $card->addProperty('email address', $this->_getRandomEmail(), true);
    $card->addProperty('email address', $this->_getRandomEmail(), true);
    $card->addProperty('email address', $this->_getRandomEmail(), true);

    $this->_addRandomActions($card, 5);

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
   * @return Cards
   */
  final public function noPropertiesCards()
  {
    $items = [];
    while(count($items) < 5)
    {
      $card = $this->_createQuickCard($this->_getRandomJobTitle());
      $this->_addRandomActions($card, 2);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->addCards($items);
    return $cards;
  }

  /**
   * @group Cards
   * @return Cards
   */
  final public function employeeRolesCards()
  {
    $items = [];
    while(count($items) < 5)
    {
      $card = $this->_createQuickCard($this->_getRandomJobTitle());
      $card->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry.");
      $card->addProperty('email address', $this->_getRandomEmail(), true);
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
      $card->addProperty(
        'Created',
        $this->_getRandomHumanDate(),
        date('Y-m-d H:i', strtotime('-' . mt_rand(1, 48) . ' months'))
      );
      $card->addProperty('Email Address', $this->_getRandomEmail());
      $this->_addRandomActions($card, 1);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->stacked();
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
      $card->setColour(Card::COLOUR_RED);
      $card->setColourBackground(true);
      $card->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry.");
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
    $cards->setLayout($cards::LAYOUT_GRID);
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
      $card->addProperty('Payment Method', FaIcon::create(FaIcon::CC_PAYPAL)->sizeX2());

      // create actions
      $this->_addRandomActions($card);

      $items[] = $card;
    }

    $cards = Cards::i();
    $cards->addCards($items);
    return $cards;
  }

  /**
   * @group Cards
   */
  final public function contentCards()
  {
    $cards = Cards::i();
    //$cards = Cards::i()->setLayout(Cards::LAYOUT_GRID);

    $longDesc = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque suscipit tortor ut leo pharetra dignissim. Fusce nunc nibh, dictum nec neque in, interdum iaculis quam. Vestibulum finibus, quam quis euismod sollicitudin, dui velit tempus felis, sit amet consequat nunc lacus sit amet ante. Aenean vitae justo interdum quam consequat mollis sed at lectus. Cras auctor a metus eget ultricies. Vestibulum ut mattis quam. Mauris hendrerit facilisis purus, et maximus quam dapibus vel. Sed hendrerit, magna sit amet tempus sagittis, purus velit finibus neque, non aliquet tortor ipsum eu risus. Donec dapibus massa odio, eget rutrum neque euismod eget. Sed vitae dui justo. Pellentesque ac felis dictum, tempor magna in, pulvinar est. Nulla at purus ligula.

Donec porttitor, turpis ac varius posuere, sem dolor aliquam nunc, nec bibendum tortor mi ac mi. Cras quam sapien, tristique sed nisl ut, rhoncus pretium quam. Vivamus porta varius molestie. Donec et justo nisi. Aenean a pretium nunc, ut ornare nunc. Ut ullamcorper lacus lectus, in ultrices mi pharetra at. Cras fermentum ultrices nisi posuere rhoncus. Proin bibendum metus nunc, vitae bibendum dui cursus sit amet. Aliquam erat volutpat. Integer commodo nibh justo, laoreet pulvinar metus imperdiet vel. Etiam a lobortis dolor, a gravida neque. Nam nec tellus lacus.

Pellentesque elementum velit sed nulla rutrum, eget porttitor orci efficitur. Donec sollicitudin blandit iaculis. Quisque vitae enim eu enim aliquet porttitor tristique at velit. Sed vulputate dolor id enim finibus placerat. Vestibulum ligula turpis, luctus ac laoreet a, tempor eu nunc. Vestibulum ac aliquet magna. Cras porttitor vel augue ut tristique.";

    $card = Card::i();
    $card->setAvatar($this->_getAvatar());
    $card->setLabel("Label Here");
    $card->setTitle("This is a standard card");
    $cards->addCard($card);
    $card->setDescription($longDesc);
    $card->addProperty("ABC", "DESHDKHF ");
    $card->addProperty("ABC", "DESHDKHF ");
    $card->addIcon($this->_getArchivedUserIcon());
    $this->_addRandomActions($card);

    $card = ContentCard::i();
    $cards->addCard($card);
    $card->setAvatar($this->_getAvatar());
    $card->addIcon($this->_getInsecureIcon());
    $card->setLabel("Label Here");
    $card->setTitle("This is a content card");
    $card->setDescription($longDesc);
    $card->addProperty("ABC", "DESHDKHFF ");
    $card->addProperty("ABC", "DESHDKHFF ");
    $this->_addRandomActions($card);

    $card = ContentCard::i();
    $cards->addCard($card);
    $card->setTitle('Non spaced content');
    $card->setAvatar(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_GREEN)->sizeMedium());
    $card->addIcon($this->_getInsecureIcon());
    $card->setLabel("Label Here");
    $card->setDescription(
      '{"event":"purchase.created","sig":"dfjklkyrdcvb,kyrsxcvbnmkurdv","uuid":"whp-b3ea015b717ekjgfkjgf3.86828014","rqid":"1-whr-b3ea015b717wefwegwegwf61.55725332","timestamp":1534161569,"data":{"offerFid":"","uniqueReference":"AE8M-WEKH-GHXN-SAIF-WEKH-1813","amount":119.95,"setupAmount":0,"totalAmount":143.94,"taxAmount":23.99,"nextRenewalAmount":143.94,"discount":0,"setupDiscount":0,"cycleTerm":1,"cycleExact":"","cycleType":4,"quantity":1,"createdTime":1534161569,"nextRenewDate":1565654400,"customerFid":"FID:CST:31651321656:VtefwlrICjB","productFid":"FID:PROD:32165161981:B5A9w26sOHu7","priceFid":"FID:PROD:PRCE:34634634634:FajsIRm","currency":"GBP","totalAmountUsd":183.54702947772,"exchangeRate":1.2751634672622,"fid":"FID:PCHS:SUBS:63126151912151:8LSppuj","id":1487831,"displayName":"Pro Plus","description":"3PROD2"}}'
    );

    return $cards;
  }

  /**
   * @group Cards
   */
  final public function standaloneCards()
  {
    $longDesc = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque suscipit tortor ut leo pharetra dignissim. Fusce nunc nibh, dictum nec neque in, interdum iaculis quam. Vestibulum finibus, quam quis euismod sollicitudin, dui velit tempus felis, sit amet consequat nunc lacus sit amet ante. Aenean vitae justo interdum quam consequat mollis sed at lectus. Cras auctor a metus eget ultricies. Vestibulum ut mattis quam. Mauris hendrerit facilisis purus, et maximus quam dapibus vel. Sed hendrerit, magna sit amet tempus sagittis, purus velit finibus neque, non aliquet tortor ipsum eu risus. Donec dapibus massa odio, eget rutrum neque euismod eget. Sed vitae dui justo. Pellentesque ac felis dictum, tempor magna in, pulvinar est. Nulla at purus ligula.";
    $card1 = Card::i();
    $card1->setAvatar($this->_getAvatar());
    $card1->setLabel("Label Here");
    $card1->setTitle("This is a standard card");
    $card1->setDescription($longDesc);
    $card1->addProperty("ABC", "DESHDKHF ");
    $card1->addProperty("ABC", "DESHDKHF ");
    $card1->addIcon($this->_getArchivedUserIcon());
    $this->_addRandomActions($card1);

    $card2 = ContentCard::i();
    $card2->setAvatar($this->_getAvatar());
    $card2->addIcon($this->_getInsecureIcon());
    $card2->setLabel("Label Here");
    $card2->setTitle("This is a content card");
    $card2->setDescription($longDesc);
    $card2->addProperty("ABC", "DESHDKHFF ");
    $card2->addProperty("ABC", "DESHDKHFF ");
    $card2->setColour('#2B80FF');
    $this->_addRandomActions($card2);

    return [$card1, LineBreak::create(), $card2];
  }

  /**
   * @group Cards
   */
  final public function customProperty()
  {
    $card1 = Card::i();
    $card1->setAvatar($this->_getAvatar());
    $card1->setLabel("Label Here");
    $card1->setTitle("This is a standard card");
    $card1->addCustomProperty(
      Chips::i()->setChips(
        [
          Chip::i()->setName("My Chip"),
          Chip::i()->setName("Second Chip")->setColor('#B20000'),
          Chip::i()->setName("Third Chip")->setColor('#5A0BB5'),
        ]
      )
    );
    $card1->addIcon($this->_getArchivedUserIcon());
    $this->_addRandomActions($card1);

    return $card1;
  }
}
