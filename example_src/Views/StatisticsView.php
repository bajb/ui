<?php
namespace Fortifi\UiExample\Views;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\ContentElements\Links\PageletLink;
use Fortifi\Ui\ContentElements\Statistics\Statistic;
use Fortifi\Ui\ContentElements\Statistics\StatisticsPanel;
use Fortifi\Ui\Ui;
use Packaged\Glimpse\Tags\Div;

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
        ->setLink(new PageletLink('/alerts'))
    );
    return $panel;
  }

  /**
   * @group statistics
   */
  final public function singlePanel()
  {
    $sPanel = StatisticsPanel::single(
      Statistic::create("Total Sales", '10,297', FaIcon::create(FaIcon::SHOPPING_CART)->addClass(Ui::TEXT_BLUE))
    );
    return Div::create(
      [
        Div::create($sPanel)->addClass('col-md-3'),
        Div::create($sPanel)->addClass('col-md-3'),
        Div::create($sPanel)->addClass('col-md-3'),
        Div::create($sPanel)->addClass('col-md-3'),
      ]
    )->addClass('row');
  }

  /**
   * @group statistics
   */
  final public function backgroundPanel()
  {
    $iPanel = StatisticsPanel::single(
      Statistic::create("Total Sales", '10,297', FaIcon::create(FaIcon::SHOPPING_CART)->addClass(Ui::TEXT_INDIGO))
        ->setLink(new PageletLink('/alerts'))
    )->setBackground(Ui::BG_INDIGO);
    $rPanel = StatisticsPanel::single(
      Statistic::create("Total Sales", '10,297', FaIcon::create(FaIcon::SHOPPING_CART)->addClass(Ui::TEXT_RED))
        ->setLink(new PageletLink('/alerts'))
    )->setBackground(Ui::BG_RED);
    return Div::create(
      [
        Div::create($rPanel)->addClass('col-md-3'),
        Div::create($iPanel)->addClass('col-md-3'),
      ]
    )->addClass('row');
  }

  /**
   * @group statistics
   */
  final public function appendedContentPanel()
  {
    $sPanel = StatisticsPanel::single(
      Statistic::create("Total Sales", '10,297', FaIcon::create(FaIcon::SHOPPING_CART)->addClass(Ui::TEXT_INDIGO))
        ->setLink(new PageletLink('/alerts'))
        ->appendContent(
          Div::create([FaIcon::create(FaIcon::ARROW_UP), ' 12%'])->addClass(Ui::TEXT_GREEN, Ui::TEXT_RIGHT)
        )
    );
    return Div::create([Div::create($sPanel)->addClass('col-md-3'),])->addClass('row');
  }
}
