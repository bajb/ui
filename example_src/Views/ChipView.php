<?php
namespace Fortifi\UiExample\Views;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Chips\Chip;
use Fortifi\Ui\ContentElements\Links\PageLink;

class ChipView extends AbstractUiExampleView
{
  /**
   * @group Chips
   */
  final public function standard()
  {
    return [
      Chip::i()->setName('My Chip')->setAction(PageLink::create('', FaIcon::create(FaIcon::TIMES))),
      Chip::i()->setName('Second Chip')->setIcon(FaIcon::create(FaIcon::MAP_MARKER_ALT)),
      Chip::i()->setName('Second Chip')->setColor('#c3dff7'),
      Chip::i()->setName('Version')->setValue('1.2.21')->setColor('#f3c06e'),
    ];
  }
}
