<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;

class QueryBuilderView extends AbstractUiExampleView
{
  /**
   * @group MenuItem
   */
  final public function standardMenu()
  {
    $qb = new QueryBuilder();
    return $qb;
  }
}
