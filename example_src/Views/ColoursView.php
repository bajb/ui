<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Text\Paragraph;

class ColoursView extends AbstractUiExampleView
{
  /**
   * @group TextColours
   */
  final public function yellowText()
  {
    return (new Paragraph('Yellow Text'))->addClass(Ui::TEXT_YELLOW);
  }

  /**
   * @group TextColours
   */
  final public function redText()
  {
    return (new Paragraph('Red Text'))->addClass(Ui::TEXT_RED);
  }

  /**
   * @group BackgroundColours
   */
  final public function yellowBackground()
  {
    return (new Paragraph('Yellow Background'))->addClass(Ui::BG_YELLOW);
  }

  /**
   * @group BackgroundColours
   */
  final public function redBackground()
  {
    return (new Paragraph('Red Background'))->addClass(Ui::BG_RED);
  }
}
