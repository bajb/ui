<?php
namespace Fortifi\UiExample\Views;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Chips\Chip;
use Fortifi\Ui\ContentElements\Chips\Chips;
use Fortifi\Ui\ContentElements\Links\PageLink;
use Packaged\Glimpse\Tags\Div;

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
      Chip::i()->setName('Version')->setValue('1.2.21')->setBorderColor('#f3c06e'),
    ];
  }

  /**
   * @group Chips
   */
  final public function chips()
  {
    return Div::create(
      Chips::i()->setChips(
        [
          Chip::i()->setName('My Chip')->setAction(PageLink::create('', FaIcon::create(FaIcon::TIMES))),
          Chip::i()->setName('Second Chip')->setIcon(FaIcon::create(FaIcon::MAP_MARKER_ALT)),
          Chip::i()->setName('Second Chip')->setColor('#c3dff7'),
          Chip::i()->setName('Version')->setValue('1.2.21')->setColor('#f3c06e'),
          Chip::i()->setName('Version')->setValue('1.2.21')->setBorderColor('#f3c06e'),
          Chip::i()->setName('My Chip')->setAction(PageLink::create('', FaIcon::create(FaIcon::TIMES))),
          Chip::i()->setName('Second Chip')->setIcon(FaIcon::create(FaIcon::MAP_MARKER_ALT)),
          Chip::i()->setName('Second Chip')->setColor('#c3dff7'),
          Chip::i()->setName('Version')->setValue('1.2.21')->setColor('#f3c06e'),
          Chip::i()->setName('Version')->setValue('1.2.21')->setBorderColor('#f3c06e'),
        ]
      )
    )->setAttribute('style', 'width:360px; border:1px solid #CCC;');
  }
}
