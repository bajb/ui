<?php
namespace Fortifi\UiExample\Views;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\FontAwesome\Interfaces\Icons\FaIcons;

class FontAwesomeView extends AbstractUiExampleView
{

  /**
   * @group Font Awesome Icons
   */
  final public function AllIcons()
  {
    $icons = [];
    foreach(FaIcon::getValues() as $icon)
    {
      $icons[] = FaIcon::create($icon)->sizeX2();
    }
    return $icons;
  }

  /**
   * @group Font Awesome Icons
   */
  final public function RegularIcons()
  {
    $icons = [];
    foreach(FaIcon::getValues() as $icon)
    {
      $icons[] = FaIcon::create($icon)->styleRegular()->sizeX2();
    }
    return $icons;
  }

  /**
   * @group Font Awesome Icons
   */
  final public function LightIcons()
  {
    $icons = [];
    foreach(FaIcon::getValues() as $icon)
    {
      $icons[] = FaIcon::create($icon)->styleLight()->sizeX2();
    }
    return $icons;
  }

  /**
   * @group Font Awesome Icons
   */
  final public function BrandIcons()
  {
    $icons = [];
    foreach(FaIcons::__BRAND_ICONS as $icon)
    {
      $icons[] = FaIcon::create($icon)->styleLight()->sizeX2();
    }
    return $icons;
  }
}
