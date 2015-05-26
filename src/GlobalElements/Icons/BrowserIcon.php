<?php
namespace Fortifi\Ui\GlobalElements\Icons;

use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;

class BrowserIcon extends Icon
{
  const SECURE_360 = 'secure-360';
  const AIRWEB = 'airweb';
  const ANDROID = 'android';
  const ANDROID_WEBVIEW_BETA = 'android-webview-beta';
  const AVANT = 'avant';
  const AVIATOR = 'aviator';
  const BAIDU = 'baidu';
  const BOAT = 'boat';
  const CHROME = 'chrome';
  const CHROME_ANDROID = 'chrome-android';
  const CHROME_BETA_ANDROID = 'chrome-beta-android';
  const CHROME_CANARY = 'chrome-canary';
  const CHROME_DEV_ANDROID = 'chrome-dev-android';
  const CHROMIUM = 'chromium';
  const CM = 'cm';
  const COAST = 'coast';
  const DIIGO = 'diigo';
  const DOCLER = 'docler';
  const DOLPHIN = 'dolphin';
  const DOLPHIN_ZERO = 'dolphin-zero';
  const DOOBLE = 'dooble';
  const EDGE = 'edge';
  const EPIC = 'epic';
  const FIREFOX = 'firefox';
  const FIREFOX_BETA = 'firefox-beta';
  const FIREFOX_DEVELOPER_EDITION = 'firefox-developer-edition';
  const FIREFOX_NIGHTLY = 'firefox-nightly';
  const ICAB_MOBILE = 'icab-mobile';
  const ICECAT = 'icecat';
  const ICEWEASEL = 'iceweasel';
  const INTERNET_EXPLORER = 'internet-explorer';
  const INTERNET_EXPLORER_DEVELOPER_CHANNEL = 'internet-explorer-developer-channel';
  const INTERNET_EXPLORER_TILE = 'internet-explorer-tile';
  const K_MELEON = 'k-meleon';
  const KONQUEROR = 'konqueror';
  const LIGHTNING = 'lightning';
  const LINK_BUBBLE = 'link-bubble';
  const MAXTHON = 'maxthon';
  const MAXTHON_BETA = 'maxthon-beta';
  const MERCURY = 'mercury';
  const METACERT = 'metacert';
  const MIDORI = 'midori';
  const MIHTOOL = 'mihtool';
  const NETSURF = 'netsurf';
  const NINESKY = 'ninesky';
  const OMEGA = 'omega';
  const OMNIWEB = 'omniweb';
  const OMNIWEB_TEST_BUILD = 'omniweb-test-build';
  const ONION = 'onion';
  const OPERA = 'opera';
  const OPERA_BETA = 'opera-beta';
  const OPERA_MINI_BETA = 'opera-mini-beta';
  const ORBITUM = 'orbitum';
  const PALE_MOON = 'pale-moon';
  const PUFFIN = 'puffin';
  const QQ = 'qq';
  const REKONQ = 'rekonq';
  const SAFARI = 'safari';
  const SAFARI_IOS = 'safari-ios';
  const SEAMONKEY = 'seamonkey';
  const SILK = 'silk';
  const SLEIPNIR_MAC = 'sleipnir-mac';
  const SLEIPNIR_MOBILE = 'sleipnir-mobile';
  const SLEIPNIR_WINDOWS = 'sleipnir-windows';
  const SLIMBOAT = 'slimboat';
  const SOGOU_MOBILE = 'sogou-mobile';
  const TOR = 'tor';
  const TORCH = 'torch';
  const UC = 'uc';
  const VIVALDI = 'vivaldi';
  const WATERFOX = 'waterfox';
  const WEB = 'web';
  const WEBKIT = 'webkit';
  const YANDEX_ALPHA = 'yandex-alpha';
  const YANDEX = 'yandex';

  protected $_browser;
  protected $_assetManager;
  protected $_size = 16;

  public static function create($browser)
  {
    if(!defined('self::' . str_replace('-', '_', strtoupper($browser))))
    {
      throw new \Exception(
        'The browser "'. $browser .'" is not supported by BrowserIcon'
      );
    }

    $icn = new static;
    $icn->_browser = $browser;

    return $icn;
  }

  protected function _processIconIncludes(AssetManager $assetManager)
  {
    $assetManager->requireCss(
      [
        'assets/css/GlobalElements/Browsers/browsers16',
        'assets/css/GlobalElements/Browsers/browsers32',
        'assets/css/GlobalElements/Browsers/browsers64',
        'assets/css/GlobalElements/Browsers/browsers128',
      ]
    );
  }

  /**
   * Define size of BrowserIcon
   *
   * @param $size
   *
   * @return $this
   */
  public function setSize($size)
  {
    $this->_size = $size;
    return $this;
  }

  /**
   * @return HtmlTag
   */
  protected function _produceHtml()
  {
    $icon = parent::_produceHtml();
    $icon->addClass('f-browser-' . $this->_size . '-' . $this->_browser);
    return $icon;
  }
}
