<?php
namespace Fortifi\UiExample\Views;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\FontAwesome\Interfaces\Icons\FaIcons;
use Packaged\Helpers\Arrays;

class FontAwesomeView extends AbstractUiExampleView
{

  /**
   * @group Font Awesome Icons
   */
  final public function AllIcons()
  {
    $icons = [];
    foreach(Arrays::random(FaIcon::getValues(), 20) as $icon)
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
    foreach(Arrays::random(FaIcon::getValues(), 20) as $icon)
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
    foreach(Arrays::random(FaIcon::getValues(), 20) as $icon)
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
    foreach(Arrays::random(FaIcons::__BRAND_ICONS, 20) as $icon)
    {
      $icons[] = FaIcon::create($icon)->styleLight()->sizeX2();
    }
    return $icons;
  }

  /**
   * @group Effects
   */
  final public function StackedIcon()
  {
    $icons = [];
    $icons[] = FaIcon::stack(
      FaIcon::create(FaIcon::CIRCLE)->styleRegular(),
      FaIcon::create(FaIcon::USER)
    );
    return $icons;
  }
}
