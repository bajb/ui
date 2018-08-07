<?php
namespace Fortifi\Ui\ContentElements\Statistics;

use Fortifi\Ui\GlobalElements\Panels\ContentPanel;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;

class StatisticsPanel extends UiElement
{
  protected $_statistics = [];
  protected $_background;

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/Statistics');
    }
  }

  public static function single(Statistic $statistic)
  {
    $stat = static::i();
    $stat->addStatistic($statistic);
    return $stat;
  }

  public function addStatistic(Statistic $statistic)
  {
    $this->_statistics[] = $statistic;
    return $this;
  }

  public function setBackground($bgClass)
  {
    $this->_background = $bgClass;
    return $this;
  }

  protected function _produceHtml()
  {
    return ContentPanel::create($this->_statistics)
      ->addClass('f-statistics-panel')
      ->addClass($this->_background)->addClass($this->_background ? 'with-bg' : '');
  }

}
