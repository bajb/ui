<?php
namespace Fortifi\Ui\GlobalElements\Cards;

use Fortifi\Ui\Enums\Cards\CardActionTooltip;
use Fortifi\Ui\Enums\Cards\CardActionType;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Fortifi\Ui\UiElement;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Span;

class CardAction extends UiElement implements ICardActionType
{
  /** @var Link|Span */
  protected $_link;
  /** @var string */
  protected $_type;
  /** @var FontIcon */
  protected $_icon;
  /** @var string|null */
  protected $_tooltip = null;

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
    }
    return $this;
  }

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
    $self->_link = $link;
    $self->_prepare();
    return $self;
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
   * Define Icon and Tooltip content
   */
  protected function _prepare()
  {
    switch($this->_type)
    {
      case self::ACTION_TYPE_IS_DEFAULT:
        $this->_icon = FontIcon::create(FontIcon::CURRENT_DEFAULT);
        $this->_tooltip = CardActionTooltip::IS_DEFAULT;
        break;
      case self::ACTION_TYPE_MAKE_DEFAULT:
        $this->_icon = FontIcon::create(FontIcon::MAKE_DEFAULT);
        $this->_tooltip = CardActionTooltip::SET_DEFAULT;
        break;
      case self::ACTION_TYPE_UNLOCK:
        $this->_icon = FontIcon::create(FontIcon::UNLOCK);
        $this->_tooltip = CardActionTooltip::UNLOCK;
        break;
      case self::ACTION_TYPE_LOCK:
        $this->_icon = FontIcon::create(FontIcon::LOCK);
        $this->_tooltip = CardActionTooltip::LOCK;
        break;
      case self::ACTION_TYPE_DECLINE:
        $this->_icon = FontIcon::create(FontIcon::DELETE);
        $this->_tooltip = CardActionTooltip::DECLINE;
        break;
      case self::ACTION_TYPE_APPROVE:
        $this->_icon = FontIcon::create(FontIcon::TICK);
        $this->_tooltip = CardActionTooltip::APPROVE;
        break;
      case self::ACTION_TYPE_VERIFY:
        $this->_icon = FontIcon::create(FontIcon::TICK);
        $this->_tooltip = CardActionTooltip::VERIFY;
        break;
      case self::ACTION_TYPE_CREATE:
        $this->_icon = FontIcon::create(FontIcon::CREATE);
        $this->_tooltip = CardActionTooltip::ADD;
        break;
      case self::ACTION_TYPE_EDIT:
        $this->_icon = FontIcon::create(FontIcon::EDIT);
        $this->_tooltip = CardActionTooltip::EDIT;
        break;
      case self::ACTION_TYPE_VIEW:
        $this->_icon = FontIcon::create(FontIcon::VIEW);
        $this->_tooltip = CardActionTooltip::VIEW;
        break;
      case self::ACTION_TYPE_DELETE:
        $this->_icon = FontIcon::create(FontIcon::DELETE);
        $this->_tooltip = CardActionTooltip::DELETE;
        break;
      case self::ACTION_TYPE_RESTORE:
        $this->_icon = FontIcon::create(FontIcon::TICK);
        $this->_tooltip = CardActionTooltip::RESTORE;
        break;
      case self::ACTION_TYPE_DISABLE:
        $this->_icon = FontIcon::create(FontIcon::TOGGLE_ON);
        $this->_tooltip = CardActionTooltip::DISABLE;
        break;
      case self::ACTION_TYPE_ENABLE:
        $this->_icon = FontIcon::create(FontIcon::TOGGLE_OFF);
        $this->_tooltip = CardActionTooltip::ENABLE;
        break;
      case self::ACTION_TYPE_RESUME:
        $this->_icon = FontIcon::create(FontIcon::PLAY);
        $this->_tooltip = CardActionTooltip::RESUME;
        break;
      case self::ACTION_TYPE_PAUSE:
        $this->_icon = FontIcon::create(FontIcon::PAUSE);
        $this->_tooltip = CardActionTooltip::PAUSE;
        break;
    }
  }

  /**
   * @return Link|Span
   */
  protected function _produceHtml()
  {
    if(!($this->_link instanceof Link))
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
    }

    $this->_link->setAttribute('data-type', $this->_type);

    return $this->_link;
  }

}
