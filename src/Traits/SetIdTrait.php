<?php
namespace Fortifi\Ui\Traits;

use Packaged\Glimpse\Core\HtmlTag;

trait SetIdTrait
{
  private $_idAttribute;

  /**
   * @return mixed
   */
  protected function _getId()
  {
    return $this->_idAttribute;
  }

  /**
   * @param $idAttribute
   *
   * @return $this
   */
  public function setId($idAttribute)
  {
    $this->_idAttribute = $idAttribute;
    return $this;
  }

  protected function _hasId()
  {
    return $this->_idAttribute !== null;
  }

  protected function _applyId(HtmlTag $tag)
  {
    if($this->_hasId())
    {
      $tag->setId($this->_getId());
    }
    return $tag;
  }
}
