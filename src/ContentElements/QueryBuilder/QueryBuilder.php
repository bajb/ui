<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;

class QueryBuilder extends UiElement
{
  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireJs('assets/js/ContentElements');
    }
    else
    {
      $assetManager->requireJs('assets/js/ContentElements/QueryBuilder');
    }
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    return Div::create('Query Builder Placeholder')
      ->setId('policyQuery')
      ->addClass('f-query-builder')
      ->setAttribute('data-qb-init','/policies/options');
  }
}
