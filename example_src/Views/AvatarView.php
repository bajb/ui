<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Avatar\Avatar;
use Fortifi\Ui\ContentElements\Avatar\TextAvatar;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
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
  final public function smallTextAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_RED)->sizeSmall());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_ORANGE)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_YELLOW)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_GREEN)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_SKY)->sizeSmall());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLUE)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_INDIGO)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_PINK)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_GREY)->sizeSmall());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLACK)->sizeSmall());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_DEFAULT)->sizeSmall());
    return $divs;
  }

  /**
   * @group Text Avatars
   * @throws \Exception
   */
  final public function mediumTextAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_RED)->sizeMedium());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_ORANGE)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_YELLOW)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_GREEN)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_SKY)->sizeMedium());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLUE)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_INDIGO)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Dave John Smith")->setColour(TextAvatar::COLOUR_PINK)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Brooke Bryan")->setColour(TextAvatar::COLOUR_GREY)->sizeMedium());
    $divs->appendContent(TextAvatar::create("BB")->setColour(TextAvatar::COLOUR_BLACK)->sizeMedium());
    $divs->appendContent(TextAvatar::create("Somereallylongname")->setColour(TextAvatar::COLOUR_DEFAULT)->sizeMedium());
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

  /**
   * @group Content Avatars
   * @throws \Exception
   */
  final public function contentAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(Avatar::i()->setContent(FontIcon::create(FontIcon::USER)));
    $divs->appendContent(Avatar::i()->setContent(FontIcon::create(FontIcon::USER))->sizeX2());
    return $divs;
  }

  /**
   * @group Small Avatars
   * @throws \Exception
   */
  final public function smallAvatars()
  {
    $divs = Div::create([]);
    $divs->appendContent(
      Avatar::image('https://media.giphy.com/media/5UMFdWbgwa3rtfYbXK/giphy.gif')->setColour(TextAvatar::COLOUR_INDIGO)
        ->sizeSmall()
    );
    $divs->appendContent(Avatar::i()->setContent(FontIcon::create(FontIcon::USER))->sizeSmall());
    return $divs;
  }
}
