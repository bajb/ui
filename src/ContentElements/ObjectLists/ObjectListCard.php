<?php
namespace Fortifi\Ui\ContentElements\ObjectLists;

use Fortifi\Ui\GlobalElements\Icons\Icon;
use Fortifi\Ui\Traits\DataAttributesTrait;
use Fortifi\Ui\Traits\SetIdTrait;
use Fortifi\Ui\UiElement;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Div;
use Packaged\Glimpse\Tags\Link;
use Packaged\Glimpse\Tags\Lists\ListItem;
use Packaged\Glimpse\Tags\Lists\UnorderedList;
use Packaged\Glimpse\Tags\Span;

class ObjectListCard extends UiElement
{
  use SetIdTrait;
  use DataAttributesTrait;

  const STATE_NORMAL = 0;
  const STATE_HIGHLIGHTED = 1;
  const STATE_SELECTED = 2;
  const STATE_DISABLED = 3;

  const COLOUR_RED = 'red';
  const COLOUR_ORANGE = 'orange';
  const COLOUR_YELLOW = 'yellow';
  const COLOUR_GREEN = 'green';
  const COLOUR_SKY = 'sky';
  const COLOUR_BLUE = 'blue';
  const COLOUR_INDIGO = 'indigo';
  const COLOUR_PINK = 'pink';
  const COLOUR_GREY = 'grey';
  const COLOUR_BLACK = 'black';
  const COLOUR_DEFAULT = 'default';

  protected $_actions; //Limit 3
  protected $_colour = self::COLOUR_DEFAULT;
  protected $_title;
  protected $_image;
  protected $_state;
  protected $_subTitle;
  protected $_rightContent;
  protected $_actionCount = 0;
  protected $_midColumns = [];

  public function processIncludes(AssetManager $assetManager, $vendor = false)
  {
    if($vendor)
    {
      $assetManager->requireCss('assets/css/ContentElements');
    }
    else
    {
      $assetManager->requireCss('assets/css/ContentElements/ObjectLists');
    }
  }

  /**
   * Set the colour of the card (Left Bar)
   *
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
   * Set the card title
   *
   * @param $title
   *
   * @return $this
   */
  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

  /**
   * Set the card sub title
   *
   * @param $subTitle
   *
   * @return $this
   */
  public function setSubTitle($subTitle)
  {
    $this->_subTitle = $subTitle;
    return $this;
  }

  public function addAction(
    $link = null, Icon $icon, $highlight = false, $tooltip = ''
  )
  {
    if(count($this->_actions) > 2)
    {
      throw new \RuntimeException(
        "Only 3 actions can be added to object list cards"
      );
    }

    if(!$link instanceof Link)
    {
      $link = Span::create();
    }

    if(!empty($tooltip))
    {
      $link->setAttribute('data-toggle', 'tooltip');
      $link->setAttribute('title', $tooltip);
    }

    $this->_actions[] = [$link->setContent($icon), $highlight];
    $this->_actionCount = count($this->_actions);

    return $this;
  }

  /**
   * Force the action count to a specific number for styling
   *
   * @param int $count (null for calculate)
   *
   * @return $this
   */
  public function setActionCount($count = null)
  {
    $this->_actionCount = $count > 0 ? (int)$count : count($this->_actions);
    return $this;
  }

  public function getActionCount()
  {
    return $this->_actionCount;
  }

  public function setRightContent($content)
  {
    $this->_rightContent = $content;
    return $this;
  }

  public function appendColumn($content)
  {
    $this->_midColumns[] = $content;
    return $this;
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  protected function _produceHtml()
  {
    $card = ListItem::create('');
    $card->addClass('f-obj-lst-itm');
    $card->addClass('f-obj-lst-itm-' . $this->_colour);

    $frame = Div::create('')->addClass('f-obj-lst-itm-frm');
    $card->appendContent($frame);

    $actionCount = $this->_actionCount;
    if($actionCount > 0)
    {
      $actions = UnorderedList::create();
      $actions->addClass('f-obj-lst-itm-act');
      $frame->appendContent($actions);
      $card->addClass('f-obj-lst-itm-w-act-' . $actionCount);

      foreach($this->_actions as $action)
      {
        $li = ListItem::create($action[0]);
        if($action[1])
        {
          $li->addClass('highlight');
        }
        $actions->addItem($li);
      }
    }

    $content = Div::create('');
    $content->addClass('f-obj-lst-itm-cntr');
    $frame->appendContent($content);

    $table = Div::create('');
    $table->addClass('f-obj-lst-itm-tbl');
    $content->appendContent($table);

    $row = Div::create('');
    $row->addClass('f-obj-lst-itm-cntr-row');
    $table->appendContent($row);

    $col1 = Div::create('');
    $col1->addClass('f-obj-lst-itm-cntr-col');
    $row->appendContent($col1);

    foreach($this->_midColumns as $column)
    {
      $midCol = Div::create($column);
      $midCol->addClass('f-obj-lst-itm-cntr-col');
      $row->appendContent($midCol);
    }

    if(!empty($this->_rightContent))
    {
      $col2 = Div::create($this->_rightContent);
      $col2->addClass('f-obj-lst-itm-cntr-col');
      $col2->addClass('f-obj-lst-itm-cntr-right');
      $row->appendContent($col2);
    }

    $title = Div::create($this->_title);
    $title->addClass('f-obj-lst-itm-title');
    $col1->appendContent($title);

    if(!empty($this->_subTitle))
    {
      $subTitle = Div::create($this->_subTitle);
      $subTitle->addClass('f-obj-lst-itm-sub-title');
      $col1->appendContent($subTitle);
    }

    $this->_applyDataAttributes($card);
    $this->_applyId($card);

    return $card;
  }

}
