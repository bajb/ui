<?php
namespace Fortifi\Ui;

use Illuminate\Support\Contracts\RenderableInterface;
use Packaged\Dispatch\AssetManager;
use Packaged\Dispatch\DirectoryMapper;
use Packaged\Glimpse\Core\ISafeHtmlProducer;
use Packaged\Glimpse\Core\SafeHtml;

abstract class UiElement implements ISafeHtmlProducer, RenderableInterface
{
  protected $_processedIncludes = false;

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

