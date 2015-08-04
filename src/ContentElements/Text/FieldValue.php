<?php
namespace Fortifi\Ui\ContentElements\Text;

use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\BoldText;

class FieldValue extends Span
{
  public function __construct($field, $value, $force = false)
  {
    if($force || $value)
    {
      parent::__construct(
        [
          BoldText::create($field . ': '),
          $value,
        ]
      );
    }
  }

  public static function make($field, $value, $force = false)
  {
    return new static($field, $value, $force);
  }
}
