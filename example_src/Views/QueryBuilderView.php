<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;
use Fortifi\Ui\Ui;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class QueryBuilderView extends AbstractUiExampleView
{
  /**
   * @group Basic Query Builder
   */
  final public function queryBuilder()
  {
    $div = Div::create(
      [
        QueryBuilder::create(
          '/querybuilder/definition',
          '/querybuilder/policy'
        )
      ]
    )->addClass(Ui::BG_INFO, Ui::PADDING_LARGE);
    AssetManager::sourceType()->requireInlineJs(
      "$('.query-builder').qb();"
    );
    return $div;
  }
}
