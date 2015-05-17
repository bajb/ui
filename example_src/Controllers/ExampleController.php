<?php
namespace Fortifi\UiExample\Controllers;

use Cubex\Http\Response;
use Cubex\View\LayoutController;
use Cubex\View\Renderable;
use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;
use Fortifi\Ui\ProjectSupport\FortifiUiLayout;
use Fortifi\UiExample\Views\ColoursView;
use Fortifi\UiExample\Views\ObjectListsView;
use Fortifi\UiExample\Views\PageNavigationView;
use Fortifi\UiExample\Views\TextView;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class ExampleController extends LayoutController
{
  protected function _init()
  {
    $this->setLayout(new FortifiUiLayout($this));
  }

  public function defaultAction($page = null)
  {
    switch($page)
    {
      case 'colours':
        return new ColoursView();
      case 'navigation':
        return new PageNavigationView();
      case 'text':
        return new TextView();
      case 'objectlist':
        return new ObjectListsView();
      case 'querybuilder':
        $div = Div::create(
          [
            QueryBuilder::create(
              '/querybuilder/options',
              '/querybuilder/policy'
            ),
            QueryBuilder::create('/querybuilder/options', 'query'),
          ]
        );
        AssetManager::sourceType()->requireInlineJs(
          "$('.query-builder').qb();"
        );
        return new Renderable($div);
      default:
        return 'Coming Soon';
    }
  }

  public function qbOptions()
  {
    $response = [
      'browser'       => [
        'display'     => 'Browser Name',
        'comparators' => ['eq' => 'Equals', 'in' => 'IN'],
        // QueryBuilderComparators.IN],
        'values'      => [
          'chrome'  => 'Chrome',
          'firefox' => 'Firefox',
          'safari'  => 'Safari'
        ],
        'ajaxUrl'     => '',
        'mode'        => 'text'
      ],
      'company'       => [
        'display'     => 'Company',
        'comparators' => ['eq' => 'Equals', 'in' => 'IN'],
      ],
      'affiliateType' => [
        'display'     => 'Affilaite Type',
        'comparators' => ['eq' => 'Equals', 'in' => 'IN'],
      ]
    ];
    return new Response(json_encode($response));
  }

  public function qbPolicyData()
  {
    $policy = [
      ['key' => 'browser', 'comparator' => 'eq', 'value' => 'chrome'],
      ['key' => 'company', 'comparator' => 'in', 'value' => ['x', 'y']],
      ['key' => 'affiliateType', 'comparator' => 'eq', 'value' => 'a'],
    ];
    return new Response(json_encode($policy));
  }

  public function getRoutes()
  {
    return [
      'querybuilder/options' => 'qbOptions',
      'querybuilder/policy'  => 'qbPolicyData',
      ':page'                => 'defaultAction',
    ];
  }
}
