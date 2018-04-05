<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\Enums\Colour;
use Fortifi\Ui\Enums\UiIcon;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Interfaces\IColours;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Lists\ListItem;
use Packaged\Glimpse\Tags\Text\Paragraph;

class Card extends UiElement implements IColours
{
  /** @var  mixed */
  protected $_title;
  /** @var  array */
  protected $_actions = [];
  /** @var  array */
  protected $_icons = [];
  /** @var  string */
  protected $_colour = Colour::COLOUR_DEFAULT;
  /** @var  null|string */
  protected $_label = null;
  /** @var  null|mixed */
  protected $_description = null;
  /** @var  null|mixed */
  protected $_avatar = null;

  /**
   * @param $content
   *
   * @return $this
   */
  public function setTitle($content)
  {
    $this->_title = $content;
    return $this;
  }

  /**
   * @param string $text
   *
   * @return $this
   */
  public function setLabel($text)
  {
    $this->_label = $text;
    return $this;
  }

  /**
   * @param $content
   *
   * @return $this
   */
  public function setDescription($content)
  {
    $this->_description = $content;
    return $this;
  }

  /**
   * @param $content
   *
   * @return $this
   */
  public function setAvatar($content)
  {
    throw new \Exception('Need to create something for this');
    $this->_avatar = $content;
    return $this;
  }

  /**
   * @param string      $type
   * @param string|null $url
   * @param string|null $ajaxUrl
   *
   * @return $this
   */
  public function addAction($type = CardActionType::ACTION_TYPE_VIEW, $url = null, $ajaxUrl = null)
  {
    if(CardActionType::isValid($type))
    {
      $this->_actions[] = CardAction::create($type, $url, $ajaxUrl);
    }
    return $this;
  }

  /**
   * @param $icon
   *
   * @return $this
   */
  public function addIcon($icon)
  {
    $this->_icons[] = $icon;
    return $this;
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
   * @return ListItem
   */
  protected function _produceHtml()
  {
    $content = Div::create()->addClass('content');
    if($this->_label)
    {
      $label = Paragraph::create($this->_label)->addClass('label');
      $content->appendContent($label);
    }

    if($this->_title)
    {
      $title = Div::create($this->_title)->addClass('title');
      $content->appendContent($title);
    }

    if($this->_description)
    {
      $description = Div::create($this->_description)->addClass('description');
      $content->appendContent($description);
    }

    if($this->_icons)
    {
      $icons = Div::create($this->_description)->addClass('icons');
      foreach($this->_icons as $icon)
      {
        if($icon instanceof FontIcon)
        {
          $icons->appendContent($icon);
        }
        else if(is_string($icon) && UiIcon::isValid($icon))
        {
          $icons->appendContent(
            FontIcon::create($icon)
          );
        }
      }
      $content->appendContent($icons);
    }

    // create Card. Add Label, Title, Description and Icons.
    $card = ListItem::create($content)->addClass('card');

    // add border colour class
    if(Colour::isValid($this->_colour))
    {
      $card->addClass($this->_colour);
    }

    // append actions
    if($this->_actions)
    {
      $actions = Div::create()->addClass('actions');
      foreach($this->_actions as $action)
      {
        if($action instanceof CardAction)
        {
          $actions->appendContent($action);
        }
      }
      $card->appendContent($actions);
    }

    return $card;
  }

}
