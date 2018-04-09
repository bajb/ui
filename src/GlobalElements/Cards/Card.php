<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\Enums\Colour;
use Fortifi\Ui\Enums\UiIcon;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\Interfaces\IColours;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Lists\ListItem;
use Packaged\Glimpse\Tags\Text\Paragraph;

class Card extends UiElement implements IColours, ICardActionType
{
  /** @var  mixed */
  protected $_title;
  /** @var  array */
  protected $_actions = [];
  /** @var  array */
  protected $_properties = [];
  /** @var  array */
  protected $_icons = [];
  /** @var  string */
  protected $_colour = self::COLOUR_DEFAULT;
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
    $this->_avatar = $content;
    return $this;
  }

  /**
   * $copyValue is functionality to copy string to clipboard on click of property object.
   * If $copyValue is_string, $copyValue content will be stored in clipboard on click.
   * If $copyValue is false OR options exist, click/copy functionality is disabled.
   * $copyValue is false (off) by default.
   *
   * @param             $label
   * @param             $value
   * @param bool|string $copyValue
   * @param array       $options
   *
   * @return $this
   */
  public function addProperty($label, $value, $copyValue = false, array $options = [])
  {
    if(is_string($label) && $value)
    {
      $property = Div::create()->addClass('property');

      // stuff for copy-to-clipboard
      if(($copyValue !== false) && ($copyValue !== null) && !$options)
      {
        if($copyValue === true)
        {
          $copyValue = $value;
        }

        if(is_string($copyValue))
        {
          $property->setAttribute('data-copy', $copyValue);
          $property->appendContent(
            FontIcon::create('fa-files-o')->addClass('copy')
          );
        }
      }

      if(is_string($value))
      {
        $value = Paragraph::create($value)->addClass('value');
      }
      else
      {
        $value = Div::create($value)->addClass('value');
      }

      if(is_string($label))
      {
        $label = Paragraph::create($label)->addClass('label');
      }

      $property->prependContent([$value, $label]);

      $this->_properties[] = $property;
    }
    return $this;
  }

  /**
   * @param string    $type
   * @param Link|null $link
   *
   * @return $this
   */
  public function addAction($type = self::ACTION_TYPE_VIEW, Link $link = null)
  {
    if(CardActionType::isValid($type))
    {
      $this->_actions[] = CardAction::create($type, $link);
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
   * @return CardAction[]
   */
  protected function _sortActionsOrder()
  {
    $sorted = [];
    $sortOrder = [
      self::ACTION_TYPE_VIEW => 1,
      self::ACTION_TYPE_EDIT => 2,
      self::ACTION_TYPE_RESTORE => 1,
      self::ACTION_TYPE_IS_DEFAULT   => 10,
      self::ACTION_TYPE_MAKE_DEFAULT => 11,
      self::ACTION_TYPE_LOCK => 20,
      self::ACTION_TYPE_UNLOCK => 21,
      self::ACTION_TYPE_PAUSE  => 30,
      self::ACTION_TYPE_RESUME => 31,
      self::ACTION_TYPE_APPROVE => 70,
      self::ACTION_TYPE_VERIFY  => 70,
      self::ACTION_TYPE_DECLINE => 71,
      self::ACTION_TYPE_DISABLE => 80,
      self::ACTION_TYPE_ENABLE  => 81,
      self::ACTION_TYPE_CREATE => 98,
      self::ACTION_TYPE_DELETE => 99,
    ];

    /** @var CardAction $action */
    foreach($this->_actions as $action)
    {
      $sorted[$sortOrder[$action->getType()]] = $action;
    }
    ksort($sorted);

    return $this->_actions = $sorted;
  }

  /**
   * @return ListItem
   */
  protected function _produceHtml()
  {
    // create Card
    $card = ListItem::create()->addClass('card');

    // create Title, Label, Description content
    $content = Div::create()->addClass('content');
    $intro = Div::create()->addClass('intro');

    if($this->_avatar)
    {
      $avatar = Div::create($this->_avatar)->addClass('avatar');
      $intro->appendContent($avatar);
    }

    if($this->_label)
    {
      $label = Paragraph::create($this->_label)->addClass('label');
      $intro->appendContent($label);
    }

    if($this->_title)
    {
      $title = Div::create($this->_title)->addClass('title');
      $intro->appendContent($title);
    }

    if($this->_description)
    {
      $description = Div::create($this->_description)->addClass('description');
      $content->appendContent($description);
    }

    // Add Label, Title, Description and Icons.
    $content->prependContent($intro);
    $card->appendContent($content);

    // add icons to Card
    if($this->_icons)
    {
      $icons = Div::create()->addClass('icons');
      foreach($this->_icons as $icon)
      {
        // if is HtmlTag object and $tag is 'i', we can assume that this should be considered an icon
        if(($icon instanceof FontIcon) || (($icon instanceof HtmlTag) && $icon->getTag() === 'i'))
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

    // add border colour class
    if(Colour::isValid($this->_colour))
    {
      $card->addClass($this->_colour);
    }

    // append properties
    if($this->_properties)
    {
      $card->appendContent(
        Div::create($this->_properties)->addClass('properties')
      );
    }

    // append actions
    if($this->_actions)
    {
      $this->_sortActionsOrder();

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
