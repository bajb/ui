<?php
namespace Fortifi\UiExample\Views;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Statistics\Statistic;
use Fortifi\Ui\ContentElements\Statistics\StatisticsPanel;
use Fortifi\Ui\Ui;

class StatisticsView extends AbstractUiExampleView
{
  /**
   * @group statistics
   */
  final public function standardPanel()
  {
    $panel = StatisticsPanel::i();
    $panel->addStatistic(
      Statistic::create("Total Sales", '10,297', FaIcon::create(FaIcon::SHOPPING_CART)->addClass(Ui::TEXT_BLUE))
    );
    $panel->addStatistic(
      Statistic::create("Todays Revenue", '$150,297', FaIcon::create(FaIcon::MONEY_BILL)->addClass(Ui::TEXT_GREEN))
    );
    $panel->addStatistic(
      Statistic::create("Total Users", '43,134,838', FaIcon::create(FaIcon::USERS)->addClass(Ui::TEXT_INDIGO))
    );
    $panel->addStatistic(
      Statistic::create("Total Views", '273k', FaIcon::create(FaIcon::EYE)->addClass(Ui::TEXT_RED))
    );
    return $panel;
  }
}
