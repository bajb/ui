<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\PropertyList\PropertyList;
use Fortifi\Ui\ContentElements\Text\RelativeDateText;

class TextView extends AbstractUiExampleView
{
  /**
   * @group DateTime
   */
  final public function dateText()
  {
    return new RelativeDateText('yesterday');
  }

  /**
   * @group PropertyLists
   */
  final public function standardList()
  {
    return PropertyList::i()->add("One", "Aaa")->add("Two", "bbb");
  }

  /**
   * @group PropertyLists
   */
  final public function inlineList()
  {
    return PropertyList::i()->setInline()->add("One", "Aaa")->add("Two", "bbb");
  }

  /**
   * @group PropertyLists
   */
  final public function longList()
  {
    $list = PropertyList::i()->setInline();
    for($i = 0; $i < 100; $i++)
    {
      $list->add(base_convert(rand(1, 1000000000000), 10, 36), 'Val' . rand(1, 100));
    }
    return $list;
  }
}
