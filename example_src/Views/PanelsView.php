<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Panels\ContentPanel;
use Fortifi\Ui\GlobalElements\Panels\Panel;
use Fortifi\Ui\GlobalElements\Panels\PanelHeader;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Text\Paragraph;

class PanelsView extends AbstractUiExampleView
{

  /**
   * @group Panels
   */
  final public function PlainPanel()
  {
    return Panel::create('Panel only, with no panel-body div, thus no padding or BG colour.');
  }

  /**
   * @group Panels
   */
  final public function ContentPanel()
  {
    return ContentPanel::create('Content panel. Has BG, border and border-radius.');
  }

  /**
   * @group Panels
   */
  final public function ContentPanelWithHeader()
  {
    $panel = ContentPanel::create(Paragraph::create('Panel with setHeader and setContent'));
    $panel->setHeader('Content Panel With Header');
    $panel->prependContent(Paragraph::create('Prepend content'));
    $panel->appendContent(Paragraph::create('Appended content'));
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function ContentPanelWithHeaderIcon()
  {
    $panel = ContentPanel::create('Panel with header and icon');

    $header = PanelHeader::create('Panel Header with Icon');
    $header->addIcon();
    $panel->setHeader($header);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function ContentPanelWithHeaderAction()
  {
    $panel = ContentPanel::create('Content Panel with header');
    $header = PanelHeader::create('Content Panel With Header Action');
    $header->addAction(new Link('#', 'Action 1'));
    $panel->setHeader($header);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function ContentPanelWithHeaderStatus()
  {
    $panel = ContentPanel::create('Panel with header and status');
    $header = PanelHeader::create('Panel Header with Status');
    $header->addStatus('Status');
    $panel->setHeader($header);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function ContentPanelFullMonty()
  {
    $panel = ContentPanel::create(Paragraph::create('Content panel and header with everything'));
    $panel->appendContent(Paragraph::create('appended content'));
    $panel->prependContent(Paragraph::create('prepended content'));

    $header = PanelHeader::create('Panel Header with everything');
    $header->addStatus('Status', null, Ui::LABEL_DANGER);
    $header->addIcon();
    $header->setBgColour($header::BG_SUCCESS);
    $header->setActions(
      [
        new Link('#', 'Action 1'),
        new Link('#', 'Action 2'),
        new Link('#', 'Action 3'),
        new Link('#', 'Action 4'),
        new Link('#', 'Action 5'),
      ]
    );

    return $panel->setHeader($header);
  }
}
