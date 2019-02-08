<?php
namespace Fortifi\Ui\ContentElements\Text;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\ResourceManager;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Span;
use Packaged\Helpers\Strings;

class AutoCompleteText extends UiElement
{
  protected $_current;
  protected $_complete;
  protected $_remaining;

  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
    if($vendor)
    {
      $resourceManager->requireCss('assets/css/ContentElements.min.css');
    }
    else
    {
      $resourceManager->requireCss('assets/css/ContentElements/AutoCompleteText.css');
    }
  }

  public static function create($currentText, $completeText)
  {
    $el = new static();
    $el->_current = $currentText;
    $el->_complete = $completeText;
    $prefix = Strings::commonPrefix($currentText, $completeText, false);
    if($prefix == $currentText)
    {
      $el->_remaining = substr($completeText, strlen($prefix));
    }
    return $el;
  }

  public function hasCompletion()
  {
    return !empty($this->_remaining);
  }

  protected function _produceHtml()
  {
    return Div::create(
      [
        Span::create($this->_current)->addClass('current-text'),
        Span::create($this->_remaining)->addClass('remaining-text'),
      ]
    )->addClass(Ui::DISPLAY_INLINE_BLOCK)->addClass('auto-complete-text');
  }

}
