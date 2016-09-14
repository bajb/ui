<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

use Packaged\Helpers\Objects;

class QueryBuilderDefinitions
{
  /**
   * @var QueryBuilderDefinition[]
   */
  protected $_definitions = [];

  public function addDefinition(QueryBuilderDefinition $definition)
  {
    if(array_search($definition, $this->_definitions) === false)
    {
      $this->_definitions[] = $definition;
    }
    return $this;
  }

  public function removeDefinition(QueryBuilderDefinition $definition)
  {
    $idx = array_search($definition, $this->_definitions);
    if($idx !== false)
    {
      unset($this->_definitions[$idx]);
    }
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

    return array_values(Objects::mpull($this->_definitions, 'toArray'));
  }
}
