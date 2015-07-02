<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\ObjectLists\ObjectList;
use Fortifi\Ui\ContentElements\ObjectLists\ObjectListCard;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Elements\LineBreak;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Text\HeadingOne;

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
      $card = ObjectListCard::i();
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

    $card = ObjectListCard::i();
    $card->setTitle('One Action');
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::EDIT));
    $result[] = $card;

    $card = ObjectListCard::i();
    $card->setTitle('Two Actions');
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::EDIT));
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::DELETE));
    $result[] = $card;

    $card = ObjectListCard::i();
    $card->setTitle('Three Actions');
    $card->setColour(ObjectListCard::COLOUR_RED);
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::EDIT));
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::DELETE));
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::LOCK), true);
    $result[] = $card;

    return $result;
  }

  /**
   * @group RightContent
   */
  final public function rightContentCards()
  {
    $result = [];

    $card = ObjectListCard::i();
    $card->setTitle('One Action');
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::EDIT));
    $card->setRightContent(
      FontIcon::create(FontIcon::CURRENT_DEFAULT)->addClass(Ui::TEXT_ORANGE)
    );
    $result[] = $card;

    return $result;
  }

  /**
   * @group RightContent
   */
  final public function columnContentCards()
  {
    $result = [];

    $card = ObjectListCard::i();
    $card->setTitle('One Action');
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::EDIT));
    $card->setRightContent(
      FontIcon::create(FontIcon::CURRENT_DEFAULT)->addClass(Ui::TEXT_ORANGE)
    );
    $card->appendColumn("Column 1");
    $card->appendColumn("Column 2");
    $card->appendColumn("Column 3");
    $result[] = $card;

    return $result;
  }

  /**
   * @group subTitledCards
   */
  final public function subTitleCards()
  {
    $result = [];

    $card = ObjectListCard::i();
    $card->setTitle('One Action');
    $card->setSubTitle('Secondary Title');
    $card->addAction(new Link('#'), FontIcon::create(FontIcon::EDIT));
    $card->setRightContent(
      FontIcon::create(FontIcon::CURRENT_DEFAULT)->addClass(Ui::TEXT_ORANGE)
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

    $list = ObjectList::i();
    $list->setStacked(true);
    $card = ObjectListCard::i();
    $card->setTitle('Stacked Card');
    $list->addCard($card);
    $list->addCard($card);
    $card = clone $card;
    $card->setColour(ObjectListCard::COLOUR_BLUE);
    $list->addCard($card);
    $result[] = $list;

    $result[] = LineBreak::create();

    $list = ObjectList::i();
    $list->setStacked(true, false);
    $card = ObjectListCard::i();
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
