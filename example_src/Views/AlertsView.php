<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Alerts\AlertBox;
use Packaged\Glimpse\Tags\Text\BoldText;

class AlertsView extends AbstractUiExampleView
{
  /**
   * @group StatusPanel
   */
  final public function AlertWithDanger()
  {
    $panel = AlertBox::create(
      [new BoldText('Danger Mouse'), ' Some more content']
    );
    $panel->setStyle($panel::STYLE_DANGER);
    return $panel;
  }

  /**
   * @group StatusPanel
   */
  final public function AlertWithWarning()
  {
    $panel = AlertBox::create([new BoldText('Warning'), ' Some more content']);
    $panel->setStyle($panel::STYLE_WARNING);
    return $panel;
  }

  /**
   * @group StatusPanel
   */
  final public function AlertWithInfo()
  {
    $panel = AlertBox::create([new BoldText('Info'), ' Some more content']);
    $panel->setStyle($panel::STYLE_INFO);
    return $panel;
  }

  /**
   * @group StatusPanel
   */
  final public function AlertWithSuccess()
  {
    $panel = AlertBox::create([new BoldText('Success'), ' Some more content']);
    $panel->setStyle($panel::STYLE_SUCCESS);
    return $panel;
  }
}
