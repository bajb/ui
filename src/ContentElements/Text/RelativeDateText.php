<?php
namespace Fortifi\Ui\ContentElements\Text;

use Carbon\Carbon;
use Packaged\Glimpse\Tags\Span;

class RelativeDateText extends Span
{
  public function __construct($date = null)
  {
    if(is_int($date))
    {
      $timestamp = $date;
    }
    else
    {
      $timestamp = strtotime($date);
    }

    $carbon = Carbon::createFromTimestamp($timestamp);
    $this->setContent($carbon->diffForHumans());
    $this->setAttribute('title', gmdate("Y-m-d H:i:s", $timestamp));
    $this->addClass('f-txt-rel-date');
  }
}
