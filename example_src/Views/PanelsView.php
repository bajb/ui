<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Panels\Panel;
use Fortifi\Ui\GlobalElements\Panels\PanelBody;
use Fortifi\Ui\GlobalElements\Panels\PanelHeading;
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
    return Panel::create(
      Paragraph::create('Panel only, with no panel-body div, thus no padding.'),
      null, false
    )->addFooter('Footer')->setStyle(Panel::STYLE_PLAIN);
  }

  /**
   * @group Panels
   */
  final public function DefaultPanel()
  {
    $content[] = Paragraph::create('Default panel with panel-body only.');
    $content[] = Paragraph::create('The panel-body adds the padding and BG colour.');
    return Panel::create($content);
  }

  /**
   * @group Panels
   */
  final public function DefaultPanelWithFooter()
  {
    return Panel::create('Default panel with footer.')->addFooter('panel footer');
  }

  /**
   * @group Panels
   */
  final public function DefaultPanelWithHeading()
  {
    $content = Paragraph::create('Default panel with heading');
    return Panel::create($content, 'Panel Heading');
  }

  /**
   * @group Panels
   */
  final public function PanelWithIcon()
  {
    $content = Paragraph::create('Default panel with icon');
    return Panel::create($content, 'Panel heading with icon')->addIcon();
  }

  /**
   * @group Panels
   */
  final public function PanelWithStatus()
  {
    $content = Paragraph::create('Default panel with status');
    return Panel::create($content, 'Panel heading with status')
      ->addStatus('Status', '#');
  }

  /**
   * @group Panels
   */
  final public function PanelWithAction()
  {
    $content = Paragraph::create('Default panel with action');
    return Panel::create($content, 'Panel heading with action(s)')
      ->addAction(new Link('#', 'action 1'));
  }

  /**
   * @group Panels
   */
  final public function PanelFullMonty()
  {
    $actions = [
      new Link('#', 'action 1'),
      new Link('#', 'action 2'),
      new Link('#', 'action 3'),
    ];

    $content = Paragraph::create('Default panel with full monty');

    return Panel::create($content, 'Panel heading with icon, status and actions')
      ->addAction($actions)->addStatus('Status')->addFooter('Panel Footer')->addIcon();
  }
}
