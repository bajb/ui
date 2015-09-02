<?php
namespace Fortifi\Ui\Helpers;

class ColourHelper
{
  public static function rgbGradient($value, $target, $invert = false)
  {
    $percent = 0;
    if($target > 0)
    {
      $percent = ceil(($value / $target) * 100);
    }

    if($percent > 100)
    {
      $percent = 100;
    }

    if($invert)
    {
      $percent = 100 - $percent;
    }

    $maxGreen = 165;
    $maxRed = 220;

    $red = $percent < 50 ? $maxRed : floor(
      $maxRed - ($percent * 2 - 100) * $maxRed / 100
    );
    $green = $percent > 50 ? $maxGreen : floor(
      ($percent * 2) * $maxGreen / 100
    );

    return 'rgb(' . $red . ',' . $green . ',0)';
  }
}
