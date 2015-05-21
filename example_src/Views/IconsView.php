<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Icons\BrowserIcon;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;

class IconsView extends AbstractUiExampleView
{

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
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $clients = $reflection->getConstants();

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
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $clients = $reflection->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browser = BrowserIcon::create($client);
      $browser->setSize(32);
      $browsers[] = $browser;
    }

    return $browsers;
  }

  /**
   * @group icons
   */
  final public function BrowserIcons64()
  {
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $clients = $reflection->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browser = BrowserIcon::create($client);
      $browser->setSize(64);
      $browsers[] = $browser;
    }

    return $browsers;
  }

  /**
   * @group icons
   */
  final public function BrowserIcons128()
  {
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $clients = $reflection->getConstants();

    $browsers = [];
    foreach($clients as $client)
    {
      $browser = BrowserIcon::create($client);
      $browser->setSize(128);
      $browsers[] = $browser;
    }

    return $browsers;
  }
}
