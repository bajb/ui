<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

use Packaged\Helpers\Objects;

class QueryBuilderDefinitions
{
  /**
   * @var QueryBuilderDefinition[]
   */
  protected $_definitions;

  public function addDefinition(QueryBuilderDefinition $definition)
  {
    $this->_definitions[$definition->getKey()] = $definition;
    return $this;
  }

  public function removeDefinition($key)
  {
    unset($this->_definitions[$key]);
    return $this;
  }

  public function getDefinitions()
  {
    return $this->_definitions;
  }

  public function forOutput()
  {
    if(!$this->_definitions)
    {
      return [];
    }

    $this->_definitions = Objects::msort($this->_definitions, 'getDisplay');

    return Objects::mpull($this->_definitions, 'toArray');
  }
}
