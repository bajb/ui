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
    $this->_definitions[] = $definition;
    return $this;
  }

  public function removeDefinition(QueryBuilderDefinition $definition)
  {
    unset($this->_definitions[array_search($definition, $this->_definitions)]);
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

    $this->_definitions = Objects::msort($this->_definitions, 'getDisplayName');

    return Objects::mpull($this->_definitions, 'toArray');
  }
}
