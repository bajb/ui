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
    $action = Div::create($this->getAction())->addClass('dropdown-action');
    if($this->getUrl())
    {
      $action->setAttribute('data-content-url', $this->getUrl());
    }
    else
    {
      $action->appendContent(
        Div::create($this->getContent())->addClass('dropdown-content')
      );
    }
    return $action;
  }
}
