<?php
namespace Fortifi\Ui\ContentElements\Text;

use Carbon\Carbon;
use Packaged\Glimpse\Tags\Span;

class RelativeDateText extends Span
{
  protected $_timestamp;

  public function __construct($date = null)
  {
    if(is_int($date))
    {
      $this->_timestamp = $date;
    }
    else
    {
      $this->_timestamp = strtotime($date);
    }

    $carbon = Carbon::createFromTimestamp($this->_timestamp);
    $this->setContent($carbon->diffForHumans());
    $this->setAttribute('title', gmdate("Y-m-d H:i:s", $this->_timestamp));
    $this->addClass('f-txt-rel-date');
  }

  public function getTimestamp()
  {
    return $this->_timestamp;
  }
}
