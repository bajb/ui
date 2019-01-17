<?php
namespace Fortifi\Ui;

use Illuminate\Contracts\Support\Renderable;
use Packaged\Dispatch\AssetManager;
use Packaged\Dispatch\DirectoryMapper;
use Packaged\SafeHtml\ISafeHtmlProducer;
use Packaged\SafeHtml\SafeHtml;

abstract class UiElement implements ISafeHtmlProducer, Renderable
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
      $am = Ui::getAssetManager();
      $this->processIncludes(
        $am,
        $am->getMapType() == DirectoryMapper::MAP_VENDOR
      );
    }
    $this->_processedIncludes = true;
  }

  /**
   * Require Assets
   *
   * @param AssetManager $assetManager
   * @param bool         $vendor
   */
  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  final public function produceSafeHTML()
  {
    $this->_processIncludes();
    return $this->_produceHtml();
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  abstract protected function _produceHtml();

  /**
   * Get the evaluated contents of the object.
   *
   * @return string
   */
  final public function render()
  {
    return (string)$this->produceSafeHTML();
  }

  public function __toString()
  {
    return $this->render();
  }
}

