<?php
namespace Fortifi\Ui\ContentElements\Avatar;

use Fortifi\Ui\Interfaces\IColours;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Tags\Div;

class Avatar extends UiElement implements IColours
{
  protected $_colour = self::COLOUR_DEFAULT;
  protected $_content;
  protected $_style = [];
  protected $_size = "x1";

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/Avatar');
    }
  }

  /**
   * @return \Packaged\Glimpse\Core\SafeHtml|\Packaged\Glimpse\Core\SafeHtml[]|Div
   */
  protected function _produceHtml()
  {
    $div = Div::create($this->_content)->addClass('favatar', $this->_colour, $this->_size);
    if(!empty($this->_style))
    {
      $div->setAttribute('style', implode(',', $this->_style));
    }
    return $div;
  }

  public static function content($content)
  {
    $av = new static();
    $av->setContent($content);
    return $av;
  }

  public static function image($imgUrl)
  {
    $av = new static();
    $av->_style['background'] = 'background-image: url(\'' . $imgUrl . '\');';
    return $av;
  }

  /**
   * @param string $colour
   *
   * @return $this
   */
  public function setColour($colour = self::COLOUR_DEFAULT)
  {
    $this->_colour = $colour;
    return $this;
  }

  /**
   * @return string
   */
  public function getColour()
  {
    return $this->_colour;
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
   * @return Avatar
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  public function sizeDefault()
  {
    $this->_size = 'x1';
    return $this;
  }

  public function sizeX2()
  {
    $this->_size = 'x2';
    return $this;
  }
}
