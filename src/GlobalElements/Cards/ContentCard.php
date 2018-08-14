<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Elements\LineBreak;

class ContentCard extends Card
{
  protected function _produceDescription()
  {
    if(is_string($this->getDescription()))
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
    return $this->getDescription();
  }

  protected function _setDescription(HtmlTag $description, HtmlTag $primary, HtmlTag $heading, HtmlTag $text)
  {
    $primary->appendContent($description);
    return $this;
  }

  protected function _produceHtml()
  {
    $card = parent::_produceHtml();
    $card->addClass("content-card");
    return $card;
  }

}
