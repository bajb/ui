<?php
namespace Fortifi\Ui\ProjectSupport;

use Cubex\View\Layout;
use Illuminate\Support\Contracts\RenderableInterface;
use Packaged\Glimpse\Core\ISafeHtmlProducer;

class FortifiUiLayout extends Layout
{
  /**
   * Allow for sections to be rendered by calling them by name
   *
   * e.g. $this->sectionName();
   *
   * @param $method
   * @param $args
   *
   * @return string
   */
  public function __call($method, $args)
  {
    if(isset($this->_sections[$method]))
    {
      if($this->_sections[$method] instanceof RenderableInterface)
      {
        return $this->_sections[$method]->render($args);
      }

      if($this->_sections[$method] instanceof ISafeHtmlProducer)
      {
        return $this->_sections[$method]->produceSafeHTML();
      }
      else
      {
        return $this->_sections[$method];
      }
    }
    return null;
  }

  public function preRender()
  {
    foreach($this->_sections as $name => $data)
    {
      $rawData = $data;
      if($data instanceof RenderableInterface)
      {
        $this->_sections[$name] = $data = $rawData->render();
      }
      if($data instanceof ISafeHtmlProducer)
      {
        $this->_sections[$name] = $data->produceSafeHTML();
      }
      $this->_sections[$name] = (string)$this->_sections[$name];
    }
  }
}
