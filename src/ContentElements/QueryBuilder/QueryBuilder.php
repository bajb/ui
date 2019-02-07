<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Div;
use Packaged\SafeHtml\SafeHtml;

class QueryBuilder extends UiElement
{
  protected $_definitionsUrl;
  protected $_rulesUrl;
  protected $_classes = ['query-builder'];

  public static function create($definitionsUrl = null, $rulesUrl = null)
  {
    $qb = new static();
    $qb->_definitionsUrl = $definitionsUrl;
    $qb->_rulesUrl = $rulesUrl;
    return $qb;
  }

  public function addClass(...$class)
  {
    $this->_classes = array_unique(array_merge($this->_classes, $class));
    return $this;
  }

  public function removeClass(...$class)
  {
    $this->_classes = array_diff($this->_classes, $class);
    return $this;
  }

  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    $resourceManager->requireJs('assets/vendor/params/params.js');
    $resourceManager->requireJs('assets/vendor/tokenize2/tokenize2.js');
    $resourceManager->requireCss('assets/vendor/tokenize2/tokenize2.css');
    if($vendor)
    {
      $resourceManager->requireJs('assets/js/ContentElements.min.js');
      $resourceManager->requireCss('assets/css/ContentElements.min.css');
    }
    else
    {
      $resourceManager->requireJs('assets/js/ContentElements/QueryBuilder.js');
      $resourceManager->requireCss('assets/css/ContentElements/QueryBuilder.css');
      $resourceManager->requireJs('assets/js/ContentElements/QueryBuilderTokenizer.js');
      $resourceManager->requireCss('assets/css/ContentElements/QueryBuilderTokenizer.css');
      $resourceManager->requireJs('assets/js/ContentElements/QueryBuilderElastic.js');
    }
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    $div = Div::create('Query Builder Placeholder');
    if($this->_classes)
    {
      $div->addClass(...$this->_classes);
    }
    if($this->_definitionsUrl)
    {
      $div->setAttribute('data-definitions', $this->_definitionsUrl);
    }
    if($this->_rulesUrl)
    {
      $div->setAttribute('data-rules', $this->_rulesUrl);
    }
    return $div;
  }
}
