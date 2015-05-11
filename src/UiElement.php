<?php
namespace Fortifi\Ui;

use Illuminate\Support\Contracts\RenderableInterface;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\ISafeHtmlProducer;

abstract class UiElement implements ISafeHtmlProducer, RenderableInterface
{
  public function __construct()
  {
    $this->processIncludes(Ui::getAssetManager());
  }
  /**
   * Require Assets
   *
   * @param AssetManager $assetManager
   */
  public function processIncludes(AssetManager $assetManager)
  {
  }

  /**
   * Get the evaluated contents of the object.
   *
   * @return string
   */
  public function render()
  {
    $this->processIncludes(Ui::getAssetManager());
    return (string)$this->produceSafeHTML();
  }

  public function __toString()
  {
    return $this->render();
  }
}

