<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Panels\Panel;
use Fortifi\Ui\GlobalElements\Panels\PanelBody;
use Fortifi\Ui\GlobalElements\Panels\PanelHeading;
use Packaged\Glimpse\Tags\Link;

class PanelsView extends AbstractUiExampleView
{

  /**
   * @group Panels
   */
  final public function PanelBodyOnly()
  {
    $content = PanelBody::create('panel content')->setBorderRadius();
    return Panel::create($content);
  }

  /**
   * @group Panels
   */
  final public function PanelWithHeading()
  {
    $heading = PanelHeading::create('Panel Heading');
    $content = PanelBody::create('panel content - Background colour removed');
    $content->removeBgColour();
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelWithIcon()
  {
    $heading = PanelHeading::create('Panel Heading')->addIcon();
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelWithStatus()
  {
    $heading = PanelHeading::create('Panel Heading')->setStatus('status tag');
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelWithAction()
  {
    $heading = PanelHeading::create('Panel Heading')
      ->addAction(new Link('#', 'Action 1'));
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelFullMonty()
  {
    $heading = PanelHeading::create('Panel Heading')
      ->addAction(new Link('#', 'Action 1'))
      ->setStatus('status tag')
      ->addIcon();
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }
}
