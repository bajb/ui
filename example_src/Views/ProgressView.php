<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Progress\CircleProgress;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;
use Packaged\Helpers\Strings;

class ProgressView extends AbstractUiExampleView
{
  /**
   * @group CircleProgress
   */
  final public function basicDisplay()
  {
    $return = [];
    $percents = Strings::stringToRange('1-100');
    foreach($percents as $percent)
    {
      $return[] = Div::create(CircleProgress::i()->setPercent($percent)->setContent($percent . '%'))
        ->addClass(Ui::MARGIN_MEDIUM, Ui::FLOAT_LEFT);
    }
    return $return;
  }
}
