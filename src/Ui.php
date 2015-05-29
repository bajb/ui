<?php
namespace Fortifi\Ui;

use Packaged\Dispatch\AssetManager;

final class Ui
{
  /**
   * @var AssetManager
   */
  private static $assetManager;

  /**
   * Floating Alignment
   */
  const CENTER_BLOCK = 'center-block';
  const FLOAT_LEFT = 'pull-left';
  const FLOAT_RIGHT = 'pull-right';
  const CLEARFIX = 'clearfix';

  const CLEAR_FLOAT_BOTH = 'f-clr-both';
  const CLEAR_FLOAT_LEFT = 'f-clr-left';
  const CLEAR_FLOAT_RIGHT = 'f-clr-right';
  const CLEAR_FLOAT_NONE = 'f-clr-none';

  /**
   * Text Alignment
   */
  const TEXT_ALIGN_CENTER = 'f-align-center';
  const TEXT_ALIGN_LEFT = 'f-align-left';
  const TEXT_ALIGN_RIGHT = 'f-align-right';
  const TEXT_ALIGN_TOP = 'f-align-top';
  const TEXT_ALIGN_BOTTOM = 'f-align-bottom';
  const TEXT_ALIGN_MIDDLE = 'f-align-middle';

  /**
   * Visibility
   */
  const INVISIBLE = 'invisible';
  const HIDE = 'hidden';
  const HIDE_TEXT = 'text-hide';
  const SHOW = 'show';

  /**
   * Display Options
   */

  const DISPLAY_INLINE = 'f-di';
  const DISPLAY_INLINE_BLOCK = 'f-dib';
  const DISPLAY_BLOCK = 'f-db';
  const DISPLAY_NONE = 'f-dn';
  const DISPLAY_TABLE = 'f-dt';
  const DISPLAY_TABLE_ROW = 'f-dtr';
  const DISPLAY_TABLE_CELL = 'f-dtc';

  /**
   * Margins
   */

  const MARGIN_SMALL = 'f-ms';
  const MARGIN_MEDIUM = 'f-mm';
  const MARGIN_LARGE = 'f-ml';
  const MARGIN_NONE = 'f-mn';
  const MARGIN_SMALL_LEFT = 'f-msl';
  const MARGIN_MEDIUM_LEFT = 'f-mml';
  const MARGIN_LARGE_LEFT = 'f-mll';
  const MARGIN_NONE_LEFT = 'f-mnl';
  const MARGIN_SMALL_RIGHT = 'f-msr';
  const MARGIN_MEDIUM_RIGHT = 'f-mmr';
  const MARGIN_LARGE_RIGHT = 'f-mlr';
  const MARGIN_NONE_RIGHT = 'f-mnr';
  const MARGIN_SMALL_BOTTOM = 'f-msb';
  const MARGIN_MEDIUM_BOTTOM = 'f-mmb';
  const MARGIN_LARGE_BOTTOM = 'f-mlb';
  const MARGIN_NONE_BOTTOM = 'f-mnb';
  const MARGIN_SMALL_TOP = 'f-mst';
  const MARGIN_MEDIUM_TOP = 'f-mmt';
  const MARGIN_LARGE_TOP = 'f-mlt';
  const MARGIN_NONE_TOP = 'f-mnt';

  /**
   * Border None
   */

  const BORDER_NONE = 'f-bn';
  const BORDER_TOP_NONE = 'f-bn-t';
  const BORDER_RIGHT_NONE = 'f-bn-r';
  const BORDER_BOTTOM_NONE = 'f-bn-b';
  const BORDER_LEFT_NONE = 'f-bn-l';

  /**
   * Border Radius
   */

  const BORDER_RADIUS_SMALL = 'f-brs';
  const BORDER_RADIUS_MEDIUM = 'f-brm';
  const BORDER_RADIUS_LARGE = 'f-brl';
  const BORDER_RADIUS_NONE = 'f-brn';

  const BORDER_RADIUS_TOP_SMALL = 'f-brs-t';
  const BORDER_RADIUS_TOP_MEDIUM = 'f-brm-t';
  const BORDER_RADIUS_TOP_LARGE = 'f-brl-t';
  const BORDER_RADIUS_TOP_NONE = 'f-brn-t';

  const BORDER_RADIUS_TOP_LEFT_SMALL = 'f-brs-tl';
  const BORDER_RADIUS_TOP_LEFT_MEDIUM = 'f-brm-tl';
  const BORDER_RADIUS_TOP_LEFT_LARGE = 'f-brl-tl';
  const BORDER_RADIUS_TOP_LEFT_NONE = 'f-brn-tl';

  const BORDER_RADIUS_TOP_RIGHT_SMALL = 'f-brs-tr';
  const BORDER_RADIUS_TOP_RIGHT_MEDIUM = 'f-brm-tr';
  const BORDER_RADIUS_TOP_RIGHT_LARGE = 'f-brl-tr';
  const BORDER_RADIUS_TOP_RIGHT_NONE = 'f-brn-tr';

  const BORDER_RADIUS_BOTTOM_SMALL = 'f-brs-b';
  const BORDER_RADIUS_BOTTOM_MEDIUM = 'f-brm-b';
  const BORDER_RADIUS_BOTTOM_LARGE = 'f-brl-b';
  const BORDER_RADIUS_BOTTOM_NONE = 'f-brn-b';

  const BORDER_RADIUS_BOTTOM_RIGHT_SMALL = 'f-brs-br';
  const BORDER_RADIUS_BOTTOM_RIGHT_MEDIUM = 'f-brm-br';
  const BORDER_RADIUS_BOTTOM_RIGHT_LARGE = 'f-brl-br';
  const BORDER_RADIUS_BOTTOM_RIGHT_NONE = 'f-brn-br';

  const BORDER_RADIUS_BOTTOM_LEFT_SMALL = 'f-brs-bl';
  const BORDER_RADIUS_BOTTOM_LEFT_MEDIUM = 'f-brm-bl';
  const BORDER_RADIUS_BOTTOM_LEFT_LARGE = 'f-brl-bl';
  const BORDER_RADIUS_BOTTOM_LEFT_NONE = 'f-brn-bl';

  const BORDER_RADIUS_LEFT_NONE = 'f-brn-l';
  const BORDER_RADIUS_RIGHT_NONE = 'f-brn-r';

  /**
   * Padding
   */

  const PADDING_SMALL = 'f-ps';
  const PADDING_MEDIUM = 'f-pm';
  const PADDING_LARGE = 'f-pl';
  const PADDING_NONE = 'f-pn';
  const PADDING_SMALL_LEFT = 'f-psl';
  const PADDING_MEDIUM_LEFT = 'f-pml';
  const PADDING_LARGE_LEFT = 'f-pll';
  const PADDING_NONE_LEFT = 'f-pnl';
  const PADDING_SMALL_RIGHT = 'f-psr';
  const PADDING_MEDIUM_RIGHT = 'f-pmr';
  const PADDING_LARGE_RIGHT = 'f-plr';
  const PADDING_NONE_RIGHT = 'f-pnr';
  const PADDING_SMALL_BOTTOM = 'f-psb';
  const PADDING_MEDIUM_BOTTOM = 'f-pmb';
  const PADDING_LARGE_BOTTOM = 'f-plb';
  const PADDING_NONE_BOTTOM = 'f-pnb';
  const PADDING_SMALL_TOP = 'f-pst';
  const PADDING_MEDIUM_TOP = 'f-pmt';
  const PADDING_LARGE_TOP = 'f-plt';
  const PADDING_NONE_TOP = 'f-pnt';

  /**
   * Text Styles
   */

  const TEXT_UPPERCASE = 'f-txt-uppercase';
  const TEXT_STRIKE = 'f-txt-strike';

  const TEXT_CENTER = 'text-center';
  const TEXT_RIGHT = 'text-right';
  const TEXT_LEFT = 'text-left';

  /**
   * State Based Colours
   */

  const TEXT_DEFAULT = 'text-default';
  const TEXT_SUCCESS = 'text-success';
  const TEXT_INFO = 'text-info';
  const TEXT_WARNING = 'text-warning';
  const TEXT_DANGER = 'text-danger';
  const TEXT_PRIMARY = 'text-primary';
  const TEXT_MUTED = 'text-muted';

  const BG_SUCCESS = 'bg-success';
  const BG_INFO = 'bg-info';
  const BG_WARNING = 'bg-warning';
  const BG_DANGER = 'bg-danger';
  const BG_PRIMARY = 'bg-primary';
  const BG_MUTED = 'bg-muted';

  const LABEL_DEFAULT = 'label-default';
  const LABEL_SUCCESS = 'label-success';
  const LABEL_INFO = 'label-info';
  const LABEL_WARNING = 'label-warning';
  const LABEL_DANGER = 'label-danger';
  const LABEL_PRIMARY = 'label-primary';

  const LABEL_AS_BADGE = 'label-as-badge';

  /**
   * Box Shadow
   */

  const BOX_SHADOW_NONE = 'box-shadow-none';

  /**
   * Specific Colours
   */

  const TEXT_RED = 'f-red';
  const BG_RED = 'f-bg-red';
  const TEXT_LIGHT_RED = 'f-l-red';
  const BG_LIGHT_RED = 'f-bg-l-red';
  const TEXT_ORANGE = 'f-orange';
  const BG_ORANGE = 'f-bg-orange';
  const TEXT_LIGHT_ORANGE = 'f-l-orange';
  const BG_LIGHT_ORANGE = 'f-bg-l-orange';
  const TEXT_YELLOW = 'f-yellow';
  const BG_YELLOW = 'f-bg-yellow';
  const TEXT_LIGHT_YELLOW = 'f-l-yellow';
  const BG_LIGHT_YELLOW = 'f-bg-l-yellow';
  const TEXT_GREEN = 'f-green';
  const BG_GREEN = 'f-bg-green';
  const TEXT_LIGHT_GREEN = 'f-l-green';
  const BG_LIGHT_GREEN = 'f-bg-l-green';
  const TEXT_BLUE = 'f-blue';
  const BG_BLUE = 'f-bg-blue';
  const TEXT_LIGHT_BLUE = 'f-l-blue';
  const BG_LIGHT_BLUE = 'f-bg-l-blue';
  const TEXT_SKY = 'f-sky';
  const BG_SKY = 'f-bg-sky';
  const TEXT_LIGHT_SKY = 'f-l-sky';
  const BG_LIGHT_SKY = 'f-bg-l-sky';
  const TEXT_INDIGO = 'f-indigo';
  const BG_INDIGO = 'f-bg-indigo';
  const TEXT_LIGHT_INDIGO = 'f-l-indigo';
  const BG_LIGHT_INDIGO = 'f-bg-l-indigo';
  const TEXT_PINK = 'f-pink';
  const BG_PINK = 'f-bg-pink';
  const TEXT_LIGHT_PINK = 'f-l-pink';
  const BG_LIGHT_PINK = 'f-bg-l-pink';
  const TEXT_GREY = 'f-grey';
  const BG_GREY = 'f-bg-grey';
  const TEXT_BLACK = 'f-black';
  const BG_BLACK = 'f-bg-black';
  const TEXT_WHITE = 'f-white';
  const BG_WHITE = 'f-bg-white';
  const BG_NONE = 'f-bg-none';

  public static function boot(
    AssetManager $am = null, $bootstrap = true, $jquery = true,
    $fontAwesome = true
  )
  {
    if($am === null)
    {
      $am = AssetManager::vendorType('fortifi', 'ui');
    }

    static::$assetManager = $am;

    //Require Base UI
    $am->requireCss('assets/css/ui-base');
    $am->requireJs('assets/js/ui-base');

    if($jquery)
    {    //Require JQuery
      $am->requireJs('assets/vendor/jquery/2.1.4.min');
    }

    if($bootstrap)
    {   //Require Bootstrap
      $am->requireCss('assets/vendor/bootstrap/3.3.4.min');
      $am->requireJs('assets/vendor/bootstrap/3.3.4.min');
    }

    if($fontAwesome)
    {
      $am->requireCss(
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'
      );
    }
  }

  /**
   * Obtain the asset manager for the fortifi Ui
   *
   * @return AssetManager
   */
  public static function getAssetManager()
  {
    return static::$assetManager;
  }
}
