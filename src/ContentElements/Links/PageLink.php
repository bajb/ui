<?php
namespace Fortifi\Ui\ContentElements\Links;

class PageLink extends PageletLink
{
  public function __construct($uri, $content = null, $selector = '#main-content')
  {
    parent::__construct($uri, $content, $selector);
  }
}
