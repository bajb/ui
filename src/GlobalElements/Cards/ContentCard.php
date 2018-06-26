<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Packaged\Glimpse\Elements\LineBreak;

class ContentCard extends Card
{
  protected $_maxDescription = 1024000;

  protected function _produceDescription()
  {
    $return = [];
    $desc = $this->getDescription();
    $lines = explode("\n", $desc);
    foreach($lines as $line)
    {
      $return[] = $line;
      $return[] = new LineBreak();
    }
    return $return;
  }

  protected function _produceHtml()
  {
    $card = parent::_produceHtml();
    $card->addClass("content-card");
    return $card;
  }

}
