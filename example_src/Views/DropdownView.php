<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;
use Fortifi\Ui\GlobalElements\Dropdowns\Dropdown;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;

class DropdownView extends AbstractUiExampleView
{
  /**
   * @group Dropdowns
   */
  final public function urlDropdown()
  {
    $d = Dropdown::i();
    $d->setAction(FontIcon::create(FontIcon::SETTINGS));
    //$d->setAction('test');
    $d->setUrl('/dropdowns/content');
    return $d;
  }

  /**
   * @group Dropdowns
   */
  final public function contentDropdown()
  {
    $div = Div::create(
      [
        QueryBuilder::create(
          '/querybuilder/definition',
          '/querybuilder/policy'
        ),
        HtmlTag::create()->setTag('pre')->setId('values'),
      ]
    );
    AssetManager::sourceType()->requireInlineJs(
      "
        $(document).on('update-dropdown', function() {
          $('.query-builder').QueryBuilder();
        });
        $(document).on('change.querybuilder', function(e, data) {
          $('#values').text(
            JSON.stringify(data, null, 2)
          );
        });
      "
    );

    $d = Dropdown::i();
    $d->addClass('btn', 'btn-success');
    $d->setAction('Open QueryBuilder');
    $d->setContent($div);
    return $d;
  }

  /**
   * @group Dropdowns
   */
  final public function textDropdown()
  {
    $div = Div::create('here is some content');

    $d = Dropdown::i();
    $d->setAction('Simple text dropdown');
    $d->setContent($div);
    return $d;
  }

  /**
   * @group Dropdowns
   */
  final public function textDropup()
  {
    $div = Div::create('here is some content');

    $d = Dropdown::i();
    $d->setPosition('top');
    $d->setAction('Simple text dropup');
    $d->setContent($div);
    return $d;
  }

  /**
   * @group Dropdowns
   */
  final public function textRight()
  {
    $d = Dropdown::i();
    $d->addClass('dd-right');
    $d->setAction('Simple text dropup');
    $d->setContent(Div::create('here is some content'));
    return Div::create($d)->setAttribute('style', 'position:absolute;right:0;height:5000px');
  }

  public function render()
  {
    AssetManager::sourceType()->requireInlineJs(
      '
      $(function(){$(".dd-right").Dropdown({attachTo:"body"});});
      $(function(){$(".dropdown-action").Dropdown();});
      '
    );
    return parent::render();
  }
}
