<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Icons\BrowserIcon;
use Fortifi\Ui\GlobalElements\Icons\CountryIcon;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;

class IconsView extends AbstractUiExampleView
{

  /**
   * @group Font Icons
   */
  final public function AllFontIcons()
  {
    $icons = (new \ReflectionClass(FontIcon::class))->getConstants();

    $fontIcons = [];
    foreach($icons as $icon)
    {
      $fontIcons[] = FontIcon::create($icon);
    }

    return $fontIcons;
  }

  /**
   * @group country flags
   */
  final public function AllCountryFlags()
  {
    $flags = [];
    foreach(CountryIcon::$countries as $countryCode => $country)
    {
      $flags[] = CountryIcon::create($countryCode);
    }

    return $flags;
  }

  /**
   * @group country flags
   */
  final public function EnglishSpeakingFlags()
  {
    $countries = [
      'gb', 'ie', 'us', 'au'
    ];

    $flags = [];
    foreach($countries as $countryCode)
    {
      $flags[] = CountryIcon::create($countryCode);
    }

    return $flags;
  }

  /**
   * @group Browser Icons
   */
  final public function CommonBrowserIcons()
  {
    $clients = [
      BrowserIcon::CHROME,
      BrowserIcon::FIREFOX,
      BrowserIcon::SAFARI,
      BrowserIcon::OPERA,
      BrowserIcon::INTERNET_EXPLORER,
    ];

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client);
    }

    return $browsers;
  }

  /**
   * @group Browser Icons
   */
  final public function AllBrowserIcons()
  {
    $clients = (new \ReflectionClass(BrowserIcon::class))->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client);
    }

    return $browsers;
  }

  /**
   * @group Browser Icons
   */
  final public function BrowserIcons32()
  {
    $clients = (new \ReflectionClass(BrowserIcon::class))->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client)->setSize(32);
    }

    return $browsers;
  }

  /**
   * @group Browser Icons
   */
  final public function BrowserIcons64()
  {
    $clients = (new \ReflectionClass(BrowserIcon::class))->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client)->setSize(64);
    }

    return $browsers;
  }

  /**
   * @group Browser Icons
   */
  final public function BrowserIcons128()
  {
    $clients = (new \ReflectionClass(BrowserIcon::class))->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client)->setSize(128);
    }

    return $browsers;
  }
}
