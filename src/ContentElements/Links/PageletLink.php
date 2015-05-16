<?php
namespace Fortifi\Ui\ContentElements\Links;

use Packaged\Glimpse\Tags\Link;

class PageletLink extends Link
{
  public function setAjaxUri($url)
  {
    $this->setAttribute('data-uri', $url);
    $this->setAttribute('data-progress', 'true');
    return $this;
  }

  public function __construct($uri, $content = null, $selector = 'pagelet-data')
  {
    $this->_tag = 'a';
    $this->setAttribute('href', $uri);
    $this->setAttribute('data-uri', $uri);
    $this->setAttribute('data-target', $selector);
    $this->setContent($content);
  }
}
