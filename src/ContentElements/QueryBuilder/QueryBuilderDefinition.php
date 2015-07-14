<?php
namespace Fortifi\Ui\ContentElements\QueryBuilder;

class QueryBuilderDefinition
{
  const COMPARATOR_EQUALS = 'eq';
  const COMPARATOR_NOT_EQUALS = 'neq';
  const COMPARATOR_IN = 'in';
  const COMPARATOR_NOT_IN = 'nin';
  const COMPARATOR_GREATER_THAN = 'gt';
  const COMPARATOR_GREATER_OR_EQUAL = 'gte';
  const COMPARATOR_LESS_THAN = 'lt';
  const COMPARATOR_LESS_OR_EQUAL = 'lte';
  const COMPARATOR_BETWEEN = 'bet';
  const COMPARATOR_AGE = 'age';

  protected $_key;
  protected $_display;
  protected $_dataType;
  protected $_comparators;
  protected $_values;
  protected $_ajaxUrl;
  protected $_required = false;

  public function __construct($key, $display, $dataType = null)
  {
    $this->_key = $key;
    $this->_display = $display;
    $this->_dataType = $dataType;
  }

  public function setComparators(array $comparators)
  {
    $this->_comparators = $comparators;
    return $this;
  }

  public function addComparator($comparator)
  {
    $this->_comparators[$comparator] = $comparator;
    return $this;
  }

  public function removeComparator($comparator)
  {
    unset($this->_comparators[$comparator]);
    return $this;
  }

  public function setValues(array $values)
  {
    $this->_values = $values;
    return $this;
  }

  public function setAjaxUrl($url)
  {
    $this->_ajaxUrl = $url;
    return $this;
  }

  public function getKey()
  {
    return $this->_key;
  }

  /**
   * @return mixed
   */
  public function getDisplay()
  {
    return $this->_display;
  }

  public function setRequired($required)
  {
    $this->_required = $required;
    return $this;
  }

  public function toArray()
  {
    return [
      'display'     => $this->_display,
      'comparators' => $this->_comparators,
      'values'      => $this->_values,
      'ajaxUrl'     => $this->_ajaxUrl,
      'dataType'    => $this->_dataType,
      'required'    => $this->_required,
    ];
  }
}
