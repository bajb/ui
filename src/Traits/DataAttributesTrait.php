<?php
namespace Fortifi\Ui\Traits;

use Packaged\Glimpse\Core\HtmlTag;

trait DataAttributesTrait
{
  private $_dataAttributes = [];

  public function addDataAttribute($key, $value)
  {
    $this->_dataAttributes[$key] = $value;
    return $this;
  }

  public function setDataAttributes(array $values)
  {
    $this->_dataAttributes = $values;
    return $this;
  }

  public function clearDataAttributes()
  {
    $this->_dataAttributes = [];
    return $this;
  }

  public function removeDataAttribute($key)
  {
    unset($this->_dataAttributes[$key]);
    return $this;
  }

  public function hasDataAttribute($key)
  {
    return isset($this->_dataAttributes[$key]);
  }

  protected function _applyDataAttributes(HtmlTag $tag)
  {
    if($this->_dataAttributes)
    {
      foreach($this->_dataAttributes as $k => $v)
      {
        $tag->setAttribute('data-' . $k, $v);
      }
    }
    return $tag;
  }
}
