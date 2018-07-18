<?php
namespace Fortifi\Ui\ContentElements\Links;

use Packaged\Helpers\Path;

class IntegrationLink extends PageletLink
{
  protected $_baseUrl = '';

  public static function create($uri = null, $content = null, $baseUrl = null, $selector = '#integrate-section')
  {
    $parent = new static(Path::buildUnix($baseUrl, $uri), $content, $selector);
    $parent->_baseUrl = $baseUrl;
    $parent->setAjaxUri(Path::buildUnix($parent->_baseUrl, 'pagelet', $uri));
    return $parent;
  }
}
