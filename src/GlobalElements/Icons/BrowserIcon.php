<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\SafeHtml;

class BrowserIcon extends UiElement
{
  const BROWSER_360_SECURE = '360-secure';
  const BROWSER_AIRWEB = 'airweb';
  const BROWSER_ANDROID = 'android';
  const BROWSER_WEBVIEW_BETA = 'android-webview-beta';
  const BROWSER_AVANT = 'avant';
  const BROWSER_AVIATOR = 'aviator';
  const BROWSER_BAIDU = 'baidu';
  const BROWSER_BOAT = 'boat';
  const BROWSER_CHROME = 'chrome';
  const BROWSER_CHROME_ANDROID = 'chrome-android';
  const BROWSER_CHROME_BETA_ANDROID = 'chrome-beta-android';
  const BROWSER_CHROME_CANARY = 'chrome-canary';
  const BROWSER_DEV_ANDROID = 'chrome-dev-android';
  const BROWSER_CHROMIUM = 'chromium';
  const BROWSER_CM = 'cm';
  const BROWSER_COAST = 'coast';
  const BROWSER_DIIGO = 'diigo';
  const BROWSER_DOCLER = 'docler';
  const BROWSER_DOLPHIN = 'dolphin';
  const BROWSER_DOLPHIN_ZERO = 'dolphin-zero';
  const BROWSER_DOOBLE = 'dooble';
  const BROWSER_EDGE = 'edge';
  const BROWSER_EPIC = 'epic';
  const BROWSER_FIREFOX = 'firefox';
  const BROWSER_FIREFOX_BETA = 'firefox-beta';
  const BROWSER_FIREFOX_DEVELOPER_EDITION = 'firefox-developer-edition';
  const BROWSER_FIREFOX_NIGHTLY = 'firefox-nightly';
  const BROWSER_ICAB_MOBILE = 'icab-mobile';
  const BROWSER_ICECAT = 'icecat';
  const BROWSER_ICEWEASEL = 'iceweasel';
  const BROWSER_INTERNET_EXPLORER = 'internet-explorer';
  const BROWSER_INTERNET_EXPLORER_DEVELOPER_CHANNEL = 'internet-explorer-developer-channel';
  const BROWSER_INTERNET_EXPLORER_TILE = 'internet-explorer-tile';
  const BROWSER_K_MELEON = 'k-meleon';
  const BROWSER_KONQUEROR = 'konqueror';
  const BROWSER_LIGHTNING = 'lightning';
  const BROWSER_LINK_BUBBLE = 'link-bubble';
  const BROWSER_MAXTHON = 'maxthon';
  const BROWSER_MAXTHON_BETA = 'maxthon-beta';
  const BROWSER_MERCURY = 'mercury';
  const BROWSER_METACERT = 'metacert';
  const BROWSER_MIDORI = 'midori';
  const BROWSER_MIHTOOL = 'mihtool';
  const BROWSER_NETSURF = 'netsurf';
  const BROWSER_NINESKY = 'ninesky';
  const BROWSER_OMEGA = 'omega';
  const BROWSER_OMNIWEB = 'omniweb';
  const BROWSER_OMNIWEB_TEST_BUILD = 'omniweb-test-build';
  const BROWSER_ONION = 'onion';
  const BROWSER_OPERA = 'opera';
  const BROWSER_OPERA_BETA = 'opera-beta';
  const BROWSER_OPERA_MINI_BETA = 'opera-mini-beta';
  const BROWSER_ORBITUM = 'orbitum';
  const BROWSER_PALE_MOON = 'pale-moon';
  const BROWSER_PUFFIN = 'puffin';
  const BROWSER_QQ = 'qq';
  const BROWSER_REKONQ = 'rekonq';
  const BROWSER_SAFARI = 'safari';
  const BROWSER_SAFARI_IOS = 'safari-ios';
  const BROWSER_SEAMONKEY = 'seamonkey';
  const BROWSER_SILK = 'silk';
  const BROWSER_SLEIPNIR_MAC = 'sleipnir-mac';
  const BROWSER_SLEIPNIR_MOBILE = 'sleipnir-mobile';
  const BROWSER_SLEIPNIR_WINDOWS = 'sleipnir-windows';
  const BROWSER_SLIMBOAT = 'slimboat';
  const BROWSER_SOGOU_MOBILE = 'sogou-mobile';
  const BROWSER_TOR = 'tor';
  const BROWSER_TORCH = 'torch';
  const BROWSER_UC = 'uc';
  const BROWSER_VIVALDI = 'vivaldi';
  const BROWSER_WATERFOX = 'waterfox';
  const BROWSER_WEB = 'web';
  const BROWSER_WEBKIT = 'webkit';
  const BROWSER_YANDEX_ALPHA = 'yandex-alpha';
  const BROWSER_YANDEX = 'yandex';

  protected $_icon;
  protected $_size = 16;
  protected $_classes = [];

  public static function create($icon)
  {
    $icn = new static;
    $icn->_icon = $icon;
    return $icn;
  }

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/GlobalElements');
    }
    else
    {
      $assetManager->requireCss(
        'assets/css/GlobalElements/Browsers/browsers-16'
      );
      $assetManager->requireCss(
        'assets/css/GlobalElements/Browsers/browsers-32'
      );
      $assetManager->requireCss(
        'assets/css/GlobalElements/Browsers/browsers-64'
      );
      $assetManager->requireCss(
        'assets/css/GlobalElements/Browsers/browsers-128'
      );
    }
  }

  public function addClass($class)
  {
    $this->_classes[] = $class;
    return $this;
  }

  public function setSize($size)
  {
    $this->_size = $size;
    return $this;
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    $icon = HtmlTag::createTag('i');
    $icon->addClass($this->_icon);

    foreach($this->_classes as $class)
    {
      $icon->addClass('f-browser-' . $this->_size . '-' . $class);
      $icon->setAttribute('title', $class);
    }

    return $icon;
  }
}
