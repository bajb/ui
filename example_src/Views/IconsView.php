<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Icons\BrowserIcon;
use Fortifi\Ui\GlobalElements\Icons\CountryIcon;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;

class IconsView extends AbstractUiExampleView
{

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
   * @group icons
   */
  final public function AllFontIcons()
  {
    $reflection = new \ReflectionClass(FontIcon::class);
    $icons = $reflection->getConstants();

    $fontIcons = [];
    foreach($icons as $icon)
    {
      $fontIcons[] = FontIcon::create($icon);
    }

    return $fontIcons;
  }

  /**
   * @group icons
   */
  final public function CommonBrowserIcons()
  {
    $clients = [
      BrowserIcon::BROWSER_CHROME,
      BrowserIcon::BROWSER_FIREFOX,
      BrowserIcon::BROWSER_SAFARI,
      BrowserIcon::BROWSER_OPERA,
      BrowserIcon::BROWSER_INTERNET_EXPLORER,
    ];

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client);
    }

    return $browsers;
  }

  /**
   * @group icons
   */
  final public function AllBrowserIcons()
  {
    $clients = (new \ReflectionClass(BrowserIcon::class))
      ->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browsers[] = BrowserIcon::create($client);
    }

    return $browsers;
  }

  /**
   * @group icons
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
   * @group icons
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
   * @group icons
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
