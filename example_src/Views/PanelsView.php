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
    $content = PanelBody::create('panel content');
    return Panel::create($content);
  }

  /**
   * @group Panels
   */
  final public function PanelWithHeading()
  {
    $heading = PanelHeading::create('Panel Heading');
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelWithIcon()
  {
    $heading = PanelHeading::create('Panel Heading');
    $heading->addIcon();
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelWithStatus()
  {
    $heading = PanelHeading::create('Panel Heading');
    $heading->setStatus('status tag');
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelWithAction()
  {
    $action = new Link('#', 'Action 1');
    $heading = PanelHeading::create('Panel Heading');
    $heading->addAction($action);
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }

  /**
   * @group Panels
   */
  final public function PanelFullMonty()
  {
    $action = new Link('#', 'Action 1');
    $heading = PanelHeading::create('Panel Heading');
    $heading->addAction($action);
    $heading->setStatus('status tag');
    $heading->addIcon();
    $content = PanelBody::create('panel content');
    return Panel::create([$heading, $content]);
  }
}
