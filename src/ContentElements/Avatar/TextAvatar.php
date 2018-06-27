<?php
namespace Fortifi\Ui\ContentElements\Avatar;

use Packaged\Helpers\Strings;

class TextAvatar extends Avatar
{
  protected $_text;

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
    $initials = preg_replace('/[^A-Z]/', '', Strings::stringToPascalCase($this->_text));
    $this->_content = substr($initials, 0, 1);
    if(strlen($initials) > 1)
    {
      $this->_content .= substr($initials, -1);
    }
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
    return $avatar;
  }

}
