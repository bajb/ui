<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Avatar\Avatar;
use Fortifi\Ui\ContentElements\Avatar\TextAvatar;
use Packaged\Glimpse\Tags\Div;

class AvatarView extends AbstractUiExampleView
{
  /**
   * @group Image Avatars
   * @throws \Exception
   */
  final public function imageAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(
      Avatar::image('https://pbs.twimg.com/profile_images/943069281171968000/UNiJSeWn_400x400.jpg')->setColour(
        TextAvatar::COLOUR_RED
      )
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/5UMFdWbgwa3rtfYbXK/giphy.gif')->setColour(TextAvatar::COLOUR_ORANGE)
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/xUOwGiewfQAm3tcIA8/giphy.gif')->setColour(TextAvatar::COLOUR_YELLOW)
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/26DN81TqLPIzBlksw/giphy.gif')->setColour(TextAvatar::COLOUR_GREEN)
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/xUOwFXS9fm76vBcuTC/giphy.gif')->setColour(TextAvatar::COLOUR_SKY)
    );
    $divs->appendContent(
      Avatar::image('https://pbs.twimg.com/profile_images/943069281171968000/UNiJSeWn_400x400.jpg')->setColour(
        TextAvatar::COLOUR_BLUE
      )
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/5UMFdWbgwa3rtfYbXK/giphy.gif')->setColour(TextAvatar::COLOUR_INDIGO)
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/xUOwGiewfQAm3tcIA8/giphy.gif')->setColour(TextAvatar::COLOUR_PINK)
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/26DN81TqLPIzBlksw/giphy.gif')->setColour(TextAvatar::COLOUR_GREY)
    );
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/xUOwFXS9fm76vBcuTC/giphy.gif')->setColour(TextAvatar::COLOUR_BLACK)
    );
    $divs->appendContent(
      Avatar::image('https://pbs.twimg.com/profile_images/943069281171968000/UNiJSeWn_400x400.jpg')->setColour(
        TextAvatar::COLOUR_DEFAULT
      )
    );
    return $divs;
  }

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
