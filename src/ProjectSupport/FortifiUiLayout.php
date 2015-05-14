<?php
namespace Fortifi\Ui\ProjectSupport;

use Cubex\View\Layout;
use Illuminate\Support\Contracts\RenderableInterface;

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
      if($data instanceof RenderableInterface)
      {
        $this->_sections[$name] = $data->render();
      }

      $this->_sections[$name] = (string)$this->_sections[$name];
    }
  }
}
