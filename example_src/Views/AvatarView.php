<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Avatar\TextAvatar;
use Packaged\Glimpse\Tags\Div;

class AvatarView extends AbstractUiExampleView
{
  /**
   * @group Text Avatars
   * @throws \Exception
   */
  final public function textAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_RED));
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_ORANGE));
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_YELLOW));
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_GREEN));
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_SKY));
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLUE));
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_INDIGO));
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_PINK));
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_GREY));
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLACK));
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_DEFAULT));
    return $divs;
  }

  /**
   * @group Text Avatars
   * @throws \Exception
   */
  final public function largeTextAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_RED)->sizeX2());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_ORANGE)->sizeX2());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_YELLOW)->sizeX2());
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_GREEN)->sizeX2());
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_SKY)->sizeX2());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLUE)->sizeX2());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_INDIGO)->sizeX2());
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_PINK)->sizeX2());
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_GREY)->sizeX2());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLACK)->sizeX2());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_DEFAULT)->sizeX2());
    return $divs;
  }
}
