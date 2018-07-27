<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\PageElements\HeroItemBar\HeroItemBar;
use Fortifi\Ui\PageElements\HeroSticker\HeroSticker;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\HeadingOne;

class PageElementsView extends AbstractUiExampleView
{

  /**
   * @group Hero
   */
  final public function heroNavBar()
  {
    $hero = HeroItemBar::i();
    for($i = 0; $i < 10; $i++)
    {
      $hero->add(base_convert(rand(1, 1000000000000), 10, 36), 'Val' . rand(1, 100));
    }
    return $hero;
  }

  /**
   * @group Hero
   */
  final public function heroSticker()
  {
    return HeroSticker::i()->setContent([HeadingOne::create("10/10"), Span::create("Fraud Score")]);
  }

  /**
   * @group Hero
   */
  final public function heroStickerBorderless()
  {
    return HeroSticker::i()->disableBorder();
  }

  /**
   * @group Hero
   */
  final public function heroStickerFlat()
  {
    return HeroSticker::i()->setFlat(true);
  }

  /**
   * @group Hero
   */
  final public function heroStickerBackground()
  {
    return HeroSticker::i()->setBackgroundImage(
      'http://www.clickatlife.gr/fu/t/13934/600/600/0x00000000004c6038/2/to-sikouel-abatar-pulon.jpg'
    );
  }
}
