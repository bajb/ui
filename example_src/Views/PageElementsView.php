<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\PageElements\Hero\Hero;
use Fortifi\Ui\PageElements\HeroItemBar\HeroItemBar;
use Fortifi\Ui\PageElements\HeroSticker\HeroSticker;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\HeadingOne;
use Packaged\Glimpse\Tags\Text\Paragraph;

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

  /**
   * @group Hero
   */
  final public function hero()
  {
    return Hero::i();
  }

  /**
   * @group Hero
   */
  final public function fullHero()
  {
    $content = Div::create(
      [
        Paragraph::create(
          "Donec rhoncus vehicula rhoncus. Integer sed risus eleifend, varius nunc ac, finibus orci. In mattis magna et iaculis volutpat. In convallis mi sit amet nulla commodo ornare. Morbi et magna et nulla gravida auctor non vitae lectus. Suspendisse rhoncus, felis vitae sollicitudin consectetur, erat eros luctus justo, vel fringilla enim neque at diam. Proin egestas justo sed quam vestibulum, at pellentesque nisl tincidunt. Sed ut ex tellus. Aliquam in dui tempus, porta ligula at, mattis urna. Quisque auctor arcu eu odio consectetur vehicula. Pellentesque pulvinar justo nisi, ac efficitur nisi hendrerit fermentum. Aenean vel facilisis orci. Cras semper vulputate eros vel egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas."
        ),
        Paragraph::create(
          'Donec pharetra eleifend mattis. Maecenas magna quam, pulvinar nec lorem sit amet, laoreet condimentum diam. Curabitur cursus euismod ipsum ac blandit. Vivamus eget tempor eros. Nam ut urna in magna maximus porta non nec lacus. Nullam condimentum rhoncus quam, a vulputate nibh facilisis in. In vel odio justo. Praesent lobortis suscipit enim a dignissim. Donec tincidunt porta augue ac maximus. Curabitur quis semper libero, sed suscipit felis. Aenean efficitur metus tortor, et commodo augue finibus semper.'
        ),
      ]
    )
      ->addClass(Ui::TEXT_WHITE);
    return Hero::i()
      ->setSticker(HeroSticker::i()->setContent([HeadingOne::create("10/10"), Span::create("Fraud Score")]))
      ->setItemBar(HeroItemBar::i()->add("Total Paid", "$29.43"))
      ->setContent($content);
  }
}
