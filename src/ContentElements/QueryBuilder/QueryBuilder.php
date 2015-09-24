<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;

class QueryBuilder extends UiElement
{
  protected $_definitionsUrl;
  protected $_rulesUrl;
  protected $_classes = ['query-builder'];

  public static function create($definitionsUrl = null, $rulesUrl = null)
  {
    $qb = new static;
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

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    $assetManager->requireJs('assets/vendor/params/params');
    if($vendor)
    {
      $assetManager->requireJs('assets/js/ContentElements');
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireJs('assets/js/ContentElements/QueryBuilder');
      $assetManager->requireCss('assets/css/ContentElements/QueryBuilder');
      $assetManager->requireJs(
        'assets/vendor/jquery.tokenize/jquery.tokenize'
      );
      $assetManager->requireCss(
        'assets/vendor/jquery.tokenize/jquery.tokenize'
      );
      $assetManager->requireJs(
        'assets/js/ContentElements/QueryBuilderTokenizer'
      );
      $assetManager->requireCss(
        'assets/css/ContentElements/QueryBuilderTokenizer'
      );
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
