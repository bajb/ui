<?php
namespace Fortifi\Ui\ContentElements\Links;

use Packaged\Glimpse\Tags\Link;
use Packaged\Helpers\Strings;

class PageletLink extends Link
{
  public function setAjaxUri($url)
  {
    $this->setAttribute('data-uri', $url);
    $this->setAttribute('data-progress', 'true');
    return $this;
  }

  public function __construct($uri, $content = null, $selector = '#pagelet-data')
  {
    parent::__construct($uri, $content);
    $this->_tag = 'a';
    $this->setAttribute('data-uri', $uri);
    if(!Strings::containsAny($selector, ['#', '.', ' ']))
    {
      $selector = '#' . $selector;
    }
    $this->setAttribute('data-target', $selector);
  }
}
