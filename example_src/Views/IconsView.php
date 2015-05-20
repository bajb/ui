<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\GlobalElements\Icons\BrowserIcon;
use Fortifi\Ui\GlobalElements\Icons\CountryFlags;

class IconsView extends AbstractUiExampleView
{

  /**
   * @group icons
   */
  final public function CommonBrowserIcons()
  {
    $browsers = [
      BrowserIcon::BROWSER_CHROME,
      BrowserIcon::BROWSER_FIREFOX,
      BrowserIcon::BROWSER_SAFARI,
      BrowserIcon::BROWSER_OPERA,
      BrowserIcon::BROWSER_INTERNET_EXPLORER,
    ];

    $result = [];
    foreach($browsers as $client)
    {
      $icon = BrowserIcon::i();
      $icon->addClass($client);

      $result[] = $icon;
    }

    return $result;
  }

  /**
   * @group icons
   */
  final public function AllBrowserIcons()
  {
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $browsers = $reflection->getConstants();

    $result = [];
    foreach($browsers as $client)
    {
      $icon = BrowserIcon::i();
      $icon->addClass($client);

      $result[] = $icon;
    }

    return $result;
  }

  /**
   * @group icons
   */
  final public function BrowserIcons32()
  {
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $browsers = $reflection->getConstants();

    $result = [];
    foreach($browsers as $client)
    {
      $icon = BrowserIcon::i();
      $icon->addClass($client);
      $icon->setSize(32);

      $result[] = $icon;
    }

    return $result;
  }

  /**
   * @group icons
   */
  final public function BrowserIcons64()
  {
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $browsers = $reflection->getConstants();

    $result = [];
    foreach($browsers as $client)
    {
      $icon = BrowserIcon::i();
      $icon->addClass($client);
      $icon->setSize(64);

      $result[] = $icon;
    }

    return $result;
  }

  /**
   * @group icons
   */
  final public function BrowserIcons128()
  {
    $reflection = new \ReflectionClass(BrowserIcon::class);
    $browsers = $reflection->getConstants();

    $result = [];
    foreach($browsers as $client)
    {
      $icon = BrowserIcon::i();
      $icon->addClass($client);
      $icon->setSize(128);

      $result[] = $icon;
    }

    return $result;
  }
}
