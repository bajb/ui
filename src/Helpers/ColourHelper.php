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

  public static function hexToRgb($hex)
  {
    $hex = ltrim($hex, '#');
    switch(strlen($hex))
    {
      case 6:
        $red = $hex[0] . $hex[1];
        $green = $hex[2] . $hex[3];
        $blue = $hex[4] . $hex[5];
        break;
      case 3:
        $red = $hex[0] . $hex[0];
        $green = $hex[1] . $hex[1];
        $blue = $hex[2] . $hex[2];
        break;
      default:
        return false;
    }

    return [hexdec($red), hexdec($green), hexdec($blue)];
  }

  public static function contrastText($hexColour)
  {
    list($r, $g, $b) = static::hexToRgb($hexColour);
    $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    return ($yiq >= 128) ? 'black' : 'white';
  }
}
