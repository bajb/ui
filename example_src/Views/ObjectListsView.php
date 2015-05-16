<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\ObjectLists\ObjectList;
use Fortifi\Ui\ContentElements\ObjectLists\ObjectListCard;
use Fortifi\Ui\GlobalElements\Icons\Icon;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Elements\LineBreak;
use Packaged\Glimpse\Tags\Link;

class ObjectListsView extends AbstractUiExampleView
{
  /**
   * @group Colours
   */
  final public function colourCards()
  {
    $colours = [
      ObjectListCard::COLOUR_DEFAULT,
      ObjectListCard::COLOUR_RED,
      ObjectListCard::COLOUR_ORANGE,
      ObjectListCard::COLOUR_YELLOW,
      ObjectListCard::COLOUR_GREEN,
      ObjectListCard::COLOUR_SKY,
      ObjectListCard::COLOUR_BLUE,
      ObjectListCard::COLOUR_INDIGO,
      ObjectListCard::COLOUR_PINK,
      ObjectListCard::COLOUR_GREY,
      ObjectListCard::COLOUR_BLACK,
    ];
    $result = [];
    foreach($colours as $colour)
    {
      $card = new ObjectListCard();
      $card->setColour($colour);
      $card->setTitle(ucfirst($colour));
      $result[] = $card;
    }
    return $result;
  }

  /**
   * @group Actions
   */
  final public function actionCards()
  {
    $result = [];

    $card = new ObjectListCard();
    $card->setTitle('One Action');
    $card->addAction(new Link('#'), new Icon(Icon::EDIT));
    $result[] = $card;

    $card = new ObjectListCard();
    $card->setTitle('Two Actions');
    $card->addAction(new Link('#'), new Icon(Icon::EDIT));
    $card->addAction(new Link('#'), new Icon(Icon::DELETE));
    $result[] = $card;

    $card = new ObjectListCard();
    $card->setTitle('Three Actions');
    $card->setColour(ObjectListCard::COLOUR_RED);
    $card->addAction(new Link('#'), new Icon(Icon::EDIT));
    $card->addAction(new Link('#'), new Icon(Icon::DELETE));
    $card->addAction(new Link('#'), new Icon(Icon::LOCK), true);
    $result[] = $card;

    return $result;
  }

  /**
   * @group RightContent
   */
  final public function rightContentCards()
  {
    $result = [];

    $card = new ObjectListCard();
    $card->setTitle('One Action');
    $card->addAction(new Link('#'), new Icon(Icon::EDIT));
    $card->setRightContent(
      (new Icon(Icon::CURRENT_DEFAULT))->addClass(Ui::TEXT_ORANGE)
    );
    $result[] = $card;

    return $result;
  }

  /**
   * @group subTitledCards
   */
  final public function subTitleCards()
  {
    $result = [];

    $card = new ObjectListCard();
    $card->setTitle('One Action');
    $card->setSubTitle('Secondary Title');
    $card->addAction(new Link('#'), new Icon(Icon::EDIT));
    $card->setRightContent(
      (new Icon(Icon::CURRENT_DEFAULT))->addClass(Ui::TEXT_ORANGE)
    );
    $result[] = $card;

    return $result;
  }

  /**
   * @group ListStyles
   */
  final public function stackedList()
  {
    $result = [];

    $list = new ObjectList();
    $list->setStacked(true);
    $card = new ObjectListCard();
    $card->setTitle('Stacked Card');
    $list->addCard($card);
    $list->addCard($card);
    $card = clone $card;
    $card->setColour(ObjectListCard::COLOUR_BLUE);
    $list->addCard($card);
    $result[] = $list;

    $result[] = LineBreak::create();

    $list = new ObjectList();
    $list->setStacked(true, false);
    $card = new ObjectListCard();
    $card->setTitle('Stacked Card');
    $list->addCard($card);
    $list->addCard($card);
    $card = clone $card;
    $card->setColour(ObjectListCard::COLOUR_INDIGO);
    $list->addCard($card);
    $result[] = $list;

    return $result;
  }
}
