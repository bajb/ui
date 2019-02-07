<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;
use Fortifi\Ui\Ui;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Core\CustomHtmlTag;
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
        CustomHtmlTag::build('pre')->setId('values'),
      ]
    )->addClass(Ui::BG_INFO, Ui::PADDING_LARGE);
    ResourceManager::inline()->requireJs(
      "
        $('.query-builder').QueryBuilder();
        $(document).on('change.querybuilder', function(e, data) {
          $('#values').text(
            JSON.stringify(data, null, 2)
          );
        });
      "
    );
    return $div;
  }
}
