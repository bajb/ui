<?php
namespace Fortifi\Ui\Enums;

use Fortifi\Ui\Interfaces\IUiEnum;
use Packaged\Helpers\Strings;

abstract class AbstractUiEnum implements IUiEnum
{
  /**
   * @return array
   */
  static public function getConstants()
  {
    $oClass = new \ReflectionClass(get_called_class());
    return $oClass->getConstants();
  }

  /**
   * @return array
   */
  public static function getValues()
  {
    return array_values(self::getConstants());
  }

  /**
   * @return array
   */
  public static function getKeyedValues()
  {
    $return = [];
    foreach(static::getValues() as $value)
    {
      $return[$value] = static::getDisplayValue($value);
    }
    return $return;
  }

  /**
   * @param $value
   *
   * @return bool
   */
  public static function isValid($value)
  {
    return in_array($value, static::getValues(), false);
  }

  /**
   * @param $value
   *
   * @return bool
   */
  public static function isValidStrict($value)
  {
    return in_array($value, static::getValues(), true);
  }

  /**
   * @param $value
   *
   * @return string
   */
  public static function getDisplayValue($value)
  {
    return Strings::titleize($value);
  }
}
