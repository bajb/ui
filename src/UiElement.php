<?php
namespace Fortifi\Ui;

use Illuminate\Support\Contracts\RenderableInterface;
use Packaged\Dispatch\AssetManager;
use Packaged\Dispatch\DirectoryMapper;
use Packaged\Glimpse\Core\ISafeHtmlProducer;

abstract class UiElement implements ISafeHtmlProducer, RenderableInterface
{
  protected $_processedIncludes = false;

  /**
   * @param bool $force Force process includes to be re-processed
   */
  protected function _processIncludes($force = false)
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
   * Get the evaluated contents of the object.
   *
   * @return string
   */
  public function render()
  {
    $this->_processIncludes();
    return (string)$this->produceSafeHTML();
  }

  public function __toString()
  {
    return $this->render();
  }
}

