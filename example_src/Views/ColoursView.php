<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\Helpers\ColourHelper;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Text\BoldText;
use Packaged\Glimpse\Tags\Text\Paragraph;

class ColoursView extends AbstractUiExampleView
{
  /**
   * @group TextColours
   */
  final public function YellowText()
  {
    return (new Paragraph('yellow Text'))->addClass(Ui::TEXT_YELLOW);
  }

  /**
   * @group TextColours
   */
  final public function lightYellowText()
  {
    return (new Paragraph('Light yellow Text'))->addClass(
      Ui::TEXT_LIGHT_YELLOW
    );
  }

  /**
   * @group TextColours
   */
  final public function RedText()
  {
    return (new Paragraph('red Text'))->addClass(Ui::TEXT_RED);
  }

  /**
   * @group TextColours
   */
  final public function lightRedText()
  {
    return (new Paragraph('Light red Text'))->addClass(Ui::TEXT_LIGHT_RED);
  }

  /**
   * @group TextColours
   */
  final public function OrangeText()
  {
    return (new Paragraph('orange Text'))->addClass(Ui::TEXT_ORANGE);
  }

  /**
   * @group TextColours
   */
  final public function lightOrangeText()
  {
    return (new Paragraph('Light orange Text'))->addClass(
      Ui::TEXT_LIGHT_ORANGE
    );
  }

  /**
   * @group TextColours
   */
  final public function GreenText()
  {
    return (new Paragraph('green Text'))->addClass(Ui::TEXT_GREEN);
  }

  /**
   * @group TextColours
   */
  final public function lightGreenText()
  {
    return (new Paragraph('Light green Text'))->addClass(Ui::TEXT_LIGHT_GREEN);
  }

  /**
   * @group TextColours
   */
  final public function BlueText()
  {
    return (new Paragraph('blue Text'))->addClass(Ui::TEXT_BLUE);
  }

  /**
   * @group TextColours
   */
  final public function lightBlueText()
  {
    return (new Paragraph('Light blue Text'))->addClass(Ui::TEXT_LIGHT_BLUE);
  }

  /**
   * @group TextColours
   */
  final public function SkyText()
  {
    return (new Paragraph('sky Text'))->addClass(Ui::TEXT_SKY);
  }

  /**
   * @group TextColours
   */
  final public function lightSkyText()
  {
    return (new Paragraph('Light sky Text'))->addClass(Ui::TEXT_LIGHT_SKY);
  }

  /**
   * @group TextColours
   */
  final public function IndigoText()
  {
    return (new Paragraph('indigo Text'))->addClass(Ui::TEXT_INDIGO);
  }

  /**
   * @group TextColours
   */
  final public function lightIndigoText()
  {
    return (new Paragraph('Light indigo Text'))->addClass(
      Ui::TEXT_LIGHT_INDIGO
    );
  }

  /**
   * @group TextColours
   */
  final public function PinkText()
  {
    return (new Paragraph('pink Text'))->addClass(Ui::TEXT_PINK);
  }

  /**
   * @group TextColours
   */
  final public function lightPinkText()
  {
    return (new Paragraph('Light pink Text'))->addClass(Ui::TEXT_LIGHT_PINK);
  }

  /**
   * @group BackgroundColours
   */
  final public function YellowBackground()
  {
    return (new Paragraph('yellow Background'))->addClass(Ui::BG_YELLOW);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightYellowBackground()
  {
    return (new Paragraph('Light yellow Background'))->addClass(
      Ui::BG_LIGHT_YELLOW
    );
  }

  /**
   * @group BackgroundColours
   */
  final public function RedBackground()
  {
    return (new Paragraph('red Background'))->addClass(Ui::BG_RED);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightRedBackground()
  {
    return (new Paragraph('Light red Background'))->addClass(Ui::BG_LIGHT_RED);
  }

  /**
   * @group BackgroundColours
   */
  final public function OrangeBackground()
  {
    return (new Paragraph('orange Background'))->addClass(Ui::BG_ORANGE);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightOrangeBackground()
  {
    return (new Paragraph('Light orange Background'))->addClass(
      Ui::BG_LIGHT_ORANGE
    );
  }

  /**
   * @group BackgroundColours
   */
  final public function GreenBackground()
  {
    return (new Paragraph('green Background'))->addClass(Ui::BG_GREEN);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightGreenBackground()
  {
    return (new Paragraph('Light green Background'))->addClass(
      Ui::BG_LIGHT_GREEN
    );
  }

  /**
   * @group BackgroundColours
   */
  final public function BlueBackground()
  {
    return (new Paragraph('blue Background'))->addClass(Ui::BG_BLUE);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightBlueBackground()
  {
    return (new Paragraph('Light blue Background'))->addClass(
      Ui::BG_LIGHT_BLUE
    );
  }

  /**
   * @group BackgroundColours
   */
  final public function SkyBackground()
  {
    return (new Paragraph('sky Background'))->addClass(Ui::BG_SKY);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightSkyBackground()
  {
    return (new Paragraph('Light sky Background'))->addClass(Ui::BG_LIGHT_SKY);
  }

  /**
   * @group BackgroundColours
   */
  final public function IndigoBackground()
  {
    return (new Paragraph('indigo Background'))->addClass(Ui::BG_INDIGO);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightIndigoBackground()
  {
    return (new Paragraph('Light indigo Background'))->addClass(
      Ui::BG_LIGHT_INDIGO
    );
  }

  /**
   * @group BackgroundColours
   */
  final public function PinkBackground()
  {
    return (new Paragraph('pink Background'))->addClass(Ui::BG_PINK);
  }

  /**
   * @group BackgroundColours
   */
  final public function lightPinkBackground()
  {
    return (new Paragraph('Light pink Background'))->addClass(
      Ui::BG_LIGHT_PINK
    );
  }

  /**
   * @group GradientColours
   */
  final public function gradientBackground()
  {
    $out1 = Div::create()->setAttribute(
      'style',
      'width:100%;height:17px;display:table;table-layout:fixed'
    );
    for($i = 0; $i <= 100; $i++)
    {
      $div = (new Div())->setAttribute(
        'style',
        'display:table-cell;background:'
        . ColourHelper::rgbGradient($i, 100)
      );
      $out1->appendContent($div);
    }
    $out2 = Div::create()->setAttribute(
      'style',
      'width:100%;height:17px;display:table;table-layout:fixed'
    );
    for($i = 0; $i <= 100; $i++)
    {
      $div = (new Div())->setAttribute(
        'style',
        'display:table-cell;background:'
        . ColourHelper::rgbGradient($i, 100, true)
      );
      $out2->appendContent($div);
    }
    return ['Regular', $out1, 'Inverted', $out2];
  }

  /**
   * @group GradientColours
   */
  final public function gradientText()
  {
    $output = [];
    for($i = 0; $i <= 100; $i++)
    {
      $output[] = (
      new BoldText(
        str_pad($i, 3, '0', STR_PAD_LEFT)
      )
      )->setAttribute(
          'style',
          'color:' . ColourHelper::rgbGradient($i, 100)
        );
    }
    return $output;
  }
}
