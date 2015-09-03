<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Flipper\Flipper;
use Packaged\Glimpse\Tags\Div;

class FlipperView extends AbstractUiExampleView
{
  /**
   * @group Horizontal
   */
  final public function horizontalFlipper()
  {
    return Flipper::create(
      '100px',
      '100px',
      Div::create('front')->setAttribute(
        'style',
        'width:100%;height:100%;background-color:red'
      ),
      Div::create('back')->setAttribute(
        'style',
        'width:100%;height:100%;background-color:black'
      )
    );
  }
}
