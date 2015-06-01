<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Panels\Panel;
use Fortifi\Ui\GlobalElements\Panels\PanelContent;
use Fortifi\Ui\GlobalElements\Panels\PanelFooter;
use Fortifi\Ui\GlobalElements\Panels\PanelHeading;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Text\Paragraph;

class PanelsView extends AbstractUiExampleView
{

  /**
   * @group Panels
   */
  final public function PlainPanel()
  {
    $panel = Panel::create(
      Paragraph::create('Panel only, with no panel-body div, thus no padding.')
    );
    $panel->setStyle($panel::STYLE_PLAIN);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function DefaultPanel()
  {
    $panel = Panel::create();
    $content = PanelContent::create(
      [
        Paragraph::create('Default panel with panel-body only.'),
        Paragraph::create('The panel-body adds the padding and BG colour.')
      ]
    );

    $panel->setContent($content);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function DefaultPanelWithHeading()
  {
    $panel = Panel::create();
    $panel->setHeading('Panel Heading');
    $panel->setContent(Paragraph::create('Default panel with heading'));
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function DefaultPanelWithFooter()
  {
    $panel = Panel::create();
    $panel->setContent(Paragraph::create('Default panel with footer'));
    $panel->setFooter('Panel Footer');
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function PanelWithIcon()
  {
    $heading = PanelHeading::create('Panel With Icon');
    $heading->addIcon();

    $panel = Panel::create();
    $panel->setHeading($heading);
    $panel->setContent(Paragraph::create('Default panel with icon'));
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function PanelWithStatus()
  {
    $heading = PanelHeading::create('Panel heading with status');
    $heading->addStatus('status', '#');
    $content = PanelContent::create(
      Paragraph::create('Default panel with status')
    );

    $panel = Panel::create();
    $panel->setHeading($heading);
    $panel->setContent($content);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function PanelWithAction()
  {
    $heading = PanelHeading::create('Panel heading with action');
    $heading->addAction(new Link('#', 'Action 1'));
    $content = PanelContent::create(
      Paragraph::create('Default panel with action')
    );

    $panel = Panel::create();
    $panel->setHeading($heading);
    $panel->setContent($content);
    return $panel;
  }

  /**
   * @group Panels
   */
  final public function PanelWithStyle()
  {
    $heading = PanelHeading::create('Panel With Style');
    $heading->addAction(new Link('#', 'action 1'));

    $panel = Panel::create();
    $panel->setHeading($heading);
    $panel->setContent(Paragraph::create('Success panel'));
    return $panel->setStyle($panel::STYLE_DANGER);
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

    $heading = PanelHeading::create(
      'Panel heading with icon, status and actions'
    );
    $heading->addActions($actions)->addStatus('Status')->addIcon();
    $content = PanelContent::create(
      Paragraph::create('Default panel with full monty')
    );

    $footer = PanelFooter::create('Panel Footer');
    $footer->addAction(new Link('#', 'footer action'));
    $footer->addAction(new Link('#', 'footer action2'));

    $panel = Panel::create();
    $panel->setHeading($heading);
    $panel->setContent($content);
    $panel->setFooter($footer);
    return $panel;
  }
}
