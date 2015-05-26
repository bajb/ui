<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;
use Fortifi\Ui\Ui;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
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
        ),
        HtmlTag::create()->setTag('pre')->setId('values'),
      ]
    )->addClass(Ui::BG_INFO, Ui::PADDING_LARGE);
    AssetManager::sourceType()->requireInlineJs(
      "
        $('.query-builder').QueryBuilder();
        $(document, 'querybuilder').on('change init', function(e) {
          $('#values').text(
            JSON.stringify($(this).QueryBuilder('rules'), null, 2)
          );
        });
      "
    );
    return $div;
  }
}
