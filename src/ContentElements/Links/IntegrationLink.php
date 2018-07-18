<?php
namespace Fortifi\Ui\ContentElements\Links;

use Packaged\Helpers\Path;

class IntegrationLink extends PageletLink
{
  protected $_baseUrl = '';

  public function __construct($uri, $content = null, $selector = '#integrate-section', $baseUrl = null)
  {
    $this->setBaseUrl($baseUrl);
    parent::__construct(Path::buildUnix($baseUrl, $uri), $content, $selector);
  }

  /**
   * @param string $baseUrl
   */
  public function setBaseUrl($baseUrl)
  {
    $this->_baseUrl = $baseUrl;
  }

  public static function create($uri = null, $content = null, $baseUrl = null, $selector = '#integrate-section')
  {
    $parent = new static(Path::buildUnix($baseUrl, $uri), $content, $selector);
    $parent->_baseUrl = $baseUrl;
    $parent->setAjaxUri($uri);
    return $parent;
  }

  public function setAjaxUri($uri)
  {
    $url = Path::buildUnix($this->_baseUrl, 'pagelet', $uri);
    return parent::setAjaxUri($url);
  }
}
