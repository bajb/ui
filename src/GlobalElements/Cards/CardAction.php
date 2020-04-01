<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\FontAwesome\FaIcon;
use Fortifi\Ui\Enums\Cards\CardActionTooltip;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Span;

class CardAction extends UiElement implements ICardActionType
{
  /** @var Link|Span */
  protected $_link;
  /** @var string */
  protected $_type;
  /** @var FaIcon */
  protected $_icon;
  /** @var string|null */
  protected $_tooltip = null;
  protected $_isDisabled = false;

  /**
   * @param string    $type
   * @param Link|null $link
   *
   * @return static
   */
  public static function create($type = self::ACTION_TYPE_VIEW, Link $link = null)
  {
    $self = new static();
    $self->setType($type);
    $self->setLink($link);
    return $self;
  }

  /**
   * Define Icon and Tooltip content
   */
  protected function _prepareFromType()
  {
    switch($this->_type)
    {
      case self::ACTION_TYPE_IS_DEFAULT:
        $this->_icon = FaIcon::create(FaIcon::STAR);
        $this->_tooltip = CardActionTooltip::IS_DEFAULT;
        break;
      case self::ACTION_TYPE_MAKE_DEFAULT:
        $this->_icon = FaIcon::create(FaIcon::STAR);
        $this->_icon->setColour('#bbb');
        $this->_tooltip = CardActionTooltip::SET_DEFAULT;
        break;
      case self::ACTION_TYPE_UNLOCK:
        $this->_icon = FaIcon::create(FaIcon::UNLOCK);
        $this->_tooltip = CardActionTooltip::UNLOCK;
        break;
      case self::ACTION_TYPE_LOCK:
        $this->_icon = FaIcon::create(FaIcon::LOCK);
        $this->_tooltip = CardActionTooltip::LOCK;
        break;
      case self::ACTION_TYPE_DECLINE:
        $this->_icon = FaIcon::create(FaIcon::TIMES);
        $this->_tooltip = CardActionTooltip::DECLINE;
        break;
      case self::ACTION_TYPE_REMOVE:
        $this->_icon = FaIcon::create(FaIcon::TIMES);
        $this->_tooltip = CardActionTooltip::REMOVE;
        break;
      case self::ACTION_TYPE_ADD:
        $this->_icon = FaIcon::create(FaIcon::PLUS);
        $this->_tooltip = CardActionTooltip::ADD;
        break;
      case self::ACTION_TYPE_APPROVE:
        $this->_icon = FaIcon::create(FaIcon::CHECK);
        $this->_tooltip = CardActionTooltip::APPROVE;
        break;
      case self::ACTION_TYPE_VERIFY:
        $this->_icon = FaIcon::create(FaIcon::CHECK);
        $this->_tooltip = CardActionTooltip::VERIFY;
        break;
      case self::ACTION_TYPE_CREATE:
        $this->_icon = FaIcon::create(FaIcon::PLUS);
        $this->_tooltip = CardActionTooltip::CREATE;
        break;
      case self::ACTION_TYPE_EDIT:
        $this->_icon = FaIcon::create(FaIcon::PENCIL_ALT);
        $this->_tooltip = CardActionTooltip::EDIT;
        break;
      case self::ACTION_TYPE_VIEW:
        $this->_icon = FaIcon::create(FaIcon::EYE);
        $this->_tooltip = CardActionTooltip::VIEW;
        break;
      case self::ACTION_TYPE_DOWNLOAD:
        $this->_icon = FaIcon::create(FaIcon::DOWNLOAD);
        $this->_tooltip = CardActionTooltip::DOWNLOAD;
        break;
      case self::ACTION_TYPE_DELETE:
        $this->_icon = FaIcon::create(FaIcon::TRASH);
        $this->_tooltip = CardActionTooltip::DELETE;
        break;
      case self::ACTION_TYPE_RESTORE:
        $this->_icon = FaIcon::create(FaIcon::TRASH_RESTORE);
        $this->_tooltip = CardActionTooltip::RESTORE;
        break;
      case self::ACTION_TYPE_DISABLE:
        $this->_icon = FaIcon::create(FaIcon::TOGGLE_ON);
        $this->_tooltip = CardActionTooltip::DISABLE;
        break;
      case self::ACTION_TYPE_ENABLE:
        $this->_icon = FaIcon::create(FaIcon::TOGGLE_OFF);
        $this->_tooltip = CardActionTooltip::ENABLE;
        break;
      case self::ACTION_TYPE_RESUME:
        $this->_icon = FaIcon::create(FaIcon::PLAY);
        $this->_tooltip = CardActionTooltip::RESUME;
        break;
      case self::ACTION_TYPE_PAUSE:
        $this->_icon = FaIcon::create(FaIcon::PAUSE);
        $this->_tooltip = CardActionTooltip::PAUSE;
        break;
    }
  }

  /**
   * @return Link|Span
   */
  protected function _produceHtml()
  {
    if($this->_isDisabled || (!($this->_link instanceof Link)))
    {
      $this->_link = Span::create();
    }

    if($this->_tooltip !== null)
    {
      $this->_link->setAttribute('data-toggle', 'tooltip');
      $this->_link->setAttribute('title', $this->_tooltip);
    }

    if($this->_icon !== null)
    {
      $this->_link->setContent($this->_icon);
      if($this->_isDisabled)
      {
        $this->_icon->setColour('#ccc');
      }
    }

    $this->_link->setAttribute('data-type', $this->_type);
    $this->_link->addClass('action');

    return $this->_link;
  }

  /**
   * @param string $type
   *
   * @return $this
   */
  public function setType($type)
  {
    if(CardActionType::isValid($type))
    {
      $this->_type = $type;
      $this->_prepareFromType();
    }
    return $this;
  }

  /**
   * @return string
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * @return Link|Span
   */
  public function getLink()
  {
    return $this->_link;
  }

  /**
   * @param Link|Span $link
   *
   * @return CardAction
   */
  public function setLink(Link $link = null)
  {
    $this->_link = $link;
    return $this;
  }

  /**
   * @return FaIcon
   */
  public function getIcon()
  {
    return $this->_icon;
  }

  /**
   * @param FaIcon $icon
   *
   * @return CardAction
   */
  public function setIcon($icon)
  {
    $this->_icon = $icon;
    return $this;
  }

  /**
   * You should never really need to do this. But just in case...
   *
   * @param string $text
   *
   * @return $this
   */
  public function setTooltip($text)
  {
    $this->_tooltip = $text;
    return $this;
  }

  /**
   * @return null|string
   */
  public function getTooltip()
  {
    return $this->_tooltip;
  }

  public function setDisabled($disabled)
  {
    $this->_isDisabled = $disabled;
    return $this;
  }

  public function isDisabled()
  {
    return $this->_isDisabled;
  }
}
