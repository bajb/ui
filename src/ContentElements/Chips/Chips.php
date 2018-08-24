<?php
namespace Fortifi\Ui\ContentElements\Chips;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class Chips extends UiElement
{
  protected $_chips;

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/Chip');
    }
  }

  /**
   * @return Chip[]
   */
  public function getChips()
  {
    return $this->_chips;
  }

  /**
   * @param Chip[] $chips
   *
   * @return Chips
   */
  public function setChips(array $chips)
  {
    foreach($chips as $chip)
    {
      $this->addChip($chip);
    }
    return $this;
  }

  /**
   * @param Chip $chip
   *
   * @return $this
   */
  public function addChip(Chip $chip)
  {
    $this->_chips[] = $chip;
    return $this;
  }

  protected function _produceHtml()
  {
    return Div::create($this->_chips)->addClass('f-chips');
  }

}
