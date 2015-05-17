<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

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
    return mpull($this->_definitions, 'toArray');
  }
}
