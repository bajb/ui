<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;

class QueryBuilder extends UiElement
{
  protected $_optionsUrl;
  protected $_rulesUrl;

  function __construct($optionsUrl = null, $rulesUrl = null)
  {
    $this->_optionsUrl = $optionsUrl;
    $this->_rulesUrl = $rulesUrl;
  }

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
    $div = Div::create('Query Builder Placeholder')->addClass('query-builder');
    if($this->_optionsUrl)
    {
      $div->setAttribute('data-qb-options', $this->_optionsUrl);
    }
    if($this->_rulesUrl)
    {
      $div->setAttribute('data-qb-rules', $this->_rulesUrl);
    }
    return $div;
  }
}
