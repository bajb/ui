<?php
namespace Fortifi\UiExample\Views;

use Fortifi\Ui\ContentElements\QueryBuilder\QueryBuilder;
use Fortifi\Ui\GlobalElements\Lightbox\Lightbox;
use Fortifi\Ui\GlobalElements\Icons\FontIcon;
use Packaged\Dispatch\AssetManager;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Div;

class LightboxView extends AbstractUiExampleView
{
  /**
   * @group lightboxes
   */
  final public function urlLightbox()
  {
    $d = Lightbox::i();
    $d->setAction(FontIcon::create(FontIcon::SETTINGS));
    $d->setContent('placeholder');
    $d->setUrl('/lightboxes/content');
    return $d;
  }

  /**
   * @group lightboxes
   */
  final public function contentLightbox()
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
        $(document).on('update-lightbox', function() {
          $('.query-builder').QueryBuilder();
        });
        $(document).on('change.querybuilder', function(e, data) {
          $('#values').text(
            JSON.stringify(data, null, 2)
          );
        });
      "
    );

    $d = Lightbox::i();
    $d->addClass('btn', 'btn-success');
    $d->setAction('Open QueryBuilder');
    $d->setContent($div);
    return $d;
  }

  public function render()
  {
    AssetManager::sourceType()->requireInlineJs(
      '
      $(function(){$(".lightbox-action").Lightbox();});
      '
    );
    return parent::render();
  }
}
