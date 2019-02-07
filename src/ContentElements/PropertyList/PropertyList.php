<?php
namespace Fortifi\Ui\ContentElements\PropertyList;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Lists\UnorderedList;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\StrongText;

class PropertyList extends UiElement
{
  protected $_properties = [];
  protected $_inline = false;

  /**
   * @return mixed
   */
  public function isInline()
  {
    return (bool)$this->_inline;
  }

  /**
   * @param mixed $inline
   *
   * @return PropertyList
   */
  public function setInline($inline = true)
  {
    $this->_inline = !!$inline;
    return $this;
  }

  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/ContentElements.min.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/ContentElements/PropertyList.css');
    }
  }

  public function add($label, $value)
  {
    $this->_properties[$label] = $value;
    return $this;
  }

  protected function _produceHtml()
  {
    $list = UnorderedList::create();
    $list->addClass('f-prop-list');
    if($this->isInline())
    {
      $list->addClass('f-prop-list-inline');
    }
    foreach($this->_properties as $label => $value)
    {
      $list->addItem([StrongText::create($label), Span::create($value)]);
    }
    return $list;
  }
}
