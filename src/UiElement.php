<?php
namespace Fortifi\Ui;

use Packaged\Dispatch\ResourceManager;
use Packaged\SafeHtml\SafeHtml;
use Packaged\Ui\Element;

/**
 * Extension of cubex UiElement with Dispatch helpers and includes
 */
abstract class UiElement extends Element
{
  protected $_processedIncludes = false;

  final protected function __construct()
  {
    $this->_construct();
    $this->_processIncludes();
  }

  protected function _construct()
  {
  }

  /**
   * Create a new instance of this UI Element
   *
   * @return static
   */
  public static function i()
  {
    $i = new static();
    return $i;
  }

  /**
   * @param bool $force Force process includes to be re-processed
   */
  final protected function _processIncludes($force = false)
  {
    if(!$this->_processedIncludes || $force)
    {
      $am = Ui::getResourceManager();
      $this->processIncludes($am, $am->getMapType() == ResourceManager::MAP_VENDOR);
    }
    $this->_processedIncludes = true;
  }

  /**
   * Require Assets
   *
   * @param ResourceManager $resourceManager
   * @param bool            $vendor
   */
  public function processIncludes(ResourceManager $resourceManager, $vendor = false)
  {
  }

  /**
   * @return SafeHtml
   */
  public function render(): string
  {
    $this->_processIncludes();
    return SafeHtml::escape($this->_produceHtml());
  }

  /**
   * @return mixed
   */
  abstract protected function _produceHtml();

  public function __toString()
  {
    return $this->render();
  }
}

