<?php
namespace Fortifi\Ui\ContentElements\Progress;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class CircleProgress extends UiElement
{
  protected $_percent = 0;
  protected $_content;

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/CircleProgress');
    }
  }

  protected function _produceHtml()
  {
    $content = Div::create(
      [
        Div::create()->addClass('l')->setAttribute('style', $this->getLeftRotation()),
        Div::create()->addClass('r')->setAttribute('style', $this->getRightRotation()),
      ]
    )->addClass('clip', $this->_percent >= 50 ? 'hit50' : '');
    return Div::create([$content, Div::create($this->_content)->addClass('c')])->addClass('f-cprogress');
  }

  protected function getRightRotation()
  {
    $amount = 3.6 * min(50, $this->_percent);
    return 'transform: rotate(' . floor($amount) . 'deg);';
  }

  protected function getLeftRotation()
  {
    $amount = (3.6 * $this->_percent) - 360;
    return 'transform: rotate(' . floor($amount) . 'deg);';
  }

  /**
   * @return int
   */
  public function getPercent()
  {
    return $this->_percent;
  }

  /**
   * @param int $percent
   *
   * @return CircleProgress
   */
  public function setPercent($percent)
  {
    $this->_percent = max(0, min(100, $percent));
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @param mixed $content
   *
   * @return CircleProgress
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

}
