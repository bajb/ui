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
    $d->setContent('placeholder');
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
  final public function nested()
  {
    $d = Dropdown::i();
    $d->setAction('Dropdown')->setPosition('top left');
    $d->setContent(Dropdown::i()->addClass('dd-body')->setAction('nested action')->setContent('nested content'));
    $largeContainer = Div::create($d)->setAttribute('style', 'height:5000px;margin-top:50px;position:relative');
    return Div::create($largeContainer)->setAttribute('style', 'height:200px;overflow:auto');
  }

  /**
   * @group Dropdowns
   */
  final public function multiple()
  {
    $d1 = Dropdown::i();
    $d1->setAction('Dropdown 1');
    $d1->setContent('content 1');
    $d2 = Dropdown::i();
    $d2->setAction('Dropdown 2');
    $d2->setContent('content 2');
    $d3 = Dropdown::i();
    $d3->setAction('Dropdown 3');
    $d3->setContent('content 3');
    return [$d1, $d2, $d3];
  }

  public function render()
  {
    AssetManager::sourceType()->requireInlineJs(
      '
      $(function(){$(".dd-body").Dropdown({attachToBody:true});});
      $(function(){$(".dropdown-action").Dropdown();});
      '
    );
    return parent::render();
  }
}
