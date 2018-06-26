<?php
namespace Fortifi\Ui\ContentElements\Avatar;

use Packaged\Helpers\Strings;

class TextAvatar extends Avatar
{
  protected $_text;
  protected $_initials;
  protected $_initialCount = 2;

  /**
   * @return mixed
   */
  public function getText()
  {
    return $this->_text;
  }

  /**
   * @param mixed $text
   *
   * @return TextAvatar
   */
  public function setText($text)
  {
    $this->_text = $text;
    $this->_initials = substr(
      preg_replace('/[^A-Z]/', '', Strings::stringToPascalCase($this->_text)),
      0,
      $this->_initialCount
    );
    return $this;
  }

  public static function create($text)
  {
    $av = new static();
    $av->setText($text);
    return $av;
  }

  protected function _produceHtml()
  {
    $avatar = parent::_produceHtml();
    $avatar->addClass('text-avatar');

    $avatar->setContent($this->_initials);
    return $avatar;
  }

}
