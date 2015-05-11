<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\Text\RelativeDateText;

class TextView extends AbstractUiExampleView
{
  /**
   * @group TextColours
   */
  final public function dateText()
  {
    return new RelativeDateText('yesterday');
  }
}
