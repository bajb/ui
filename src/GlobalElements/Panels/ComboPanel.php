<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;

class ComboPanel extends UiElement
{
  protected $_content;
  protected $_title;
  protected $_columnCount;
  protected $_columns;

  public static function create()
  {
    $panel = new static;
    return $panel;
  }

  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

  /**
   * @param $obj
   *
   * @return $this
   * @throws \Exception
   */
  public function addColumn($obj)
  {
    $obj = Div::create($obj)->addClass(Ui::DISPLAY_TABLE_CELL);
    if(count($this->_content) > 0)
    {
      $obj->addClass(Ui::PADDING_LARGE_LEFT);
    }
    $this->_content[] = $obj;
    return $this;
  }

  protected function _buildContent()
  {
    return Div::create($this->_content)->addClass(
      Ui::DISPLAY_TABLE,
      Ui::TEXT_ALIGN_CENTER
    );
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    return Panel::create(
      $this->_buildContent(),
      $this->_title
    );
  }
}
