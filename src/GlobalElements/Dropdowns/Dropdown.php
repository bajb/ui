<?php
namespace Fortifi\Ui\GlobalElements\Dropdowns;

use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class Dropdown extends UiElement
{
  protected $_action;
  protected $_url;
  protected $_content;
  protected $_arrow;
  protected $_position;
  protected $_classes = [];

  /**
   * Require Assets
   *
   * @param AssetManager $assetManager
   * @param bool         $vendor
   */
  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireJs('assets/js/GlobalElements');
      $assetManager->requireCss('assets/css/GlobalElements');
    }
    else
    {
      $assetManager->requireJs('assets/js/GlobalElements/Dropdown/Dropdown');
      $assetManager->requireCss('assets/css/GlobalElements/Dropdown/Dropdown');
    }
  }

  public function setAction($action)
  {
    $this->_action = $action;
    return $this;
  }

  public function getAction()
  {
    return $this->_action;
  }

  public function setPosition($position)
  {
    $this->_position = $position;
    return $this;
  }

  public function getPosition()
  {
    return $this->_position;
  }

  public function setArrow($bool = true)
  {
    $this->_arrow = $bool;
    return $this;
  }

  public function getArrow()
  {
    return $this->_arrow;
  }

  public function addClass(...$class)
  {
    $this->_classes = array_unique(array_merge($this->_classes, $class));
    return $this;
  }

  public function removeClass(...$class)
  {
    $this->_classes = array_diff($this->_classes, $class);
    return $this;
  }

  /**
   * @return string
   */
  public function getUrl()
  {
    return $this->_url;
  }

  /**
   * @param string $url
   *
   * @return Dropdown
   */
  public function setUrl($url)
  {
    $this->_url = $url;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @param mixed $content
   *
   * @return Dropdown
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  /**
   * @return mixed
   */
  protected function _produceHtml()
  {
    $action = $this->getAction();
    $actionContainer = Div::create($action)->addClass('dropdown-action');
    if($this->getArrow() === true || ($this->getArrow() === null && is_string($action)))
    {
      $actionContainer->addClass('dropdown-arrow');
    }

    foreach($this->_classes as $class)
    {
      $actionContainer->addClass($class);
    }

    if($pos = $this->getPosition())
    {
      $actionContainer->setAttribute('data-position', $pos);
    }
    if($url = $this->getUrl())
    {
      $actionContainer->setAttribute('data-content-url', $url);
    }

    $output = [$actionContainer];
    if($content = $this->getContent())
    {
      $output[] = Div::create($content)->addClass('dropdown-content');
    }
    return $output;
  }
}
