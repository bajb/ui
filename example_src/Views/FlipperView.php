<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Flipper\Flipper;
use Packaged\Glimpse\Tags\Div;

class FlipperView extends AbstractUiExampleView
{
  /**
   * @group Flipper
   */
  final public function horizontalFlipper()
  {
    return Flipper::create(
      Div::create('front')->setAttribute(
        'style',
        'width:100%;height:100%;background-color:red'
      ),
      Div::create('back')->setAttribute(
        'style',
        'width:100%;height:100%;background-color:black'
      ),
      100,
      100
    );
  }

  /**
   * @group Flipper
   */
  final public function verticalFlipper()
  {
    return Flipper::create(
      Div::create('front')->setAttribute(
        'style',
        'width:100%;height:100%;background-color:red'
      ),
      Div::create('back')->setAttribute(
        'style',
        'width:100%;height:100%;background-color:black'
      ),
      100,
      100
    )->setVertical();
  }
}
