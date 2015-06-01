<?php
namespace Fortifi\Ui\GlobalElements\Panels;

use Fortifi\Ui\Ui;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Span;

class PanelFooter extends UiElement
{
  const STYLE_LINK = 'label-link';
  const STYLE_DEFAULT = 'label-default';
  const STYLE_PRIMARY = 'label-primary';
  const STYLE_INFO = 'label-info';
  const STYLE_SUCCESS = 'label-success';
  const STYLE_WARNING = 'label-warning';
  const STYLE_DANGER = 'label-danger';

  protected $_content;
  protected $_actions = [];
  protected $_style;

  public static function create($content)
  {
    $panel = new static;
    $panel->_content = $content;
    return $panel;
  }

  protected function _buildAction($action)
  {
    $this->_actions[] = Span::create($action)->addClass(Ui::MARGIN_MEDIUM_LEFT);
    return $this;
  }

  public function addAction($obj)
  {
    if(is_array($obj))
    {
      foreach($obj as $action)
      {
        $this->_buildAction($action);
      }
    }
    else
    {
      $this->_buildAction($obj);
    }
    return $this;
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    return Div::create(
      [
        $this->_content,
        Div::create($this->_actions)->addClass('footer-action', Ui::FLOAT_RIGHT)
      ]
    )->addClass('panel-footer');
  }
}
