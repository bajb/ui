<?php
namespace Fortifi\Ui;

use Packaged\Dispatch\AssetManager;

final class UI
{
  const CENTER_BLOCK = 'center-block';
  const FLOAT_LEFT = 'pull-left';
  const FLOAT_RIGHT = 'pull-right';
  const CLEARFIX = 'clearfix';

  const HIDE = 'hidden';
  const HIDE_TEXT = 'text-hide';
  const SHOW = 'show';

  const MARGIN_SMALL = 'ms';
  const MARGIN_MEDIUM = 'mm';
  const MARGIN_LARGE = 'ml';

  const MARGIN_SMALL_LEFT = 'msl';
  const MARGIN_MEDIUM_LEFT = 'mml';
  const MARGIN_LARGE_LEFT = 'mll';

  const MARGIN_SMALL_RIGHT = 'msr';
  const MARGIN_MEDIUM_RIGHT = 'mmr';
  const MARGIN_LARGE_RIGHT = 'mlr';

  const MARGIN_SMALL_BOTTOM = 'msb';
  const MARGIN_MEDIUM_BOTTOM = 'mmb';
  const MARGIN_LARGE_BOTTOM = 'mlb';

  const MARGIN_SMALL_TOP = 'mst';
  const MARGIN_MEDIUM_TOP = 'mmt';
  const MARGIN_LARGE_TOP = 'mlt';

  const PADDING_SMALL = 'ps';
  const PADDING_MEDIUM = 'pm';
  const PADDING_LARGE = 'pl';

  const PADDING_SMALL_LEFT = 'psl';
  const PADDING_MEDIUM_LEFT = 'pml';
  const PADDING_LARGE_LEFT = 'pll';

  const PADDING_SMALL_RIGHT = 'psr';
  const PADDING_MEDIUM_RIGHT = 'pmr';
  const PADDING_LARGE_RIGHT = 'plr';

  const PADDING_SMALL_BOTTOM = 'psb';
  const PADDING_MEDIUM_BOTTOM = 'pmb';
  const PADDING_LARGE_BOTTOM = 'plb';

  const PADDING_SMALL_TOP = 'pst';
  const PADDING_MEDIUM_TOP = 'pmt';
  const PADDING_LARGE_TOP = 'plt';

  const TEXT_UPPERCASE = 'text-uppercase';
  const TEXT_STRIKE = 'text-strike';

  const TEXT_CENTER = 'text-center';
  const TEXT_RIGHT = 'text-right';
  const TEXT_LEFT = 'text-left';

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

  const TABLE_FIXED_LEFT = 'first';
  const TABLE_FIXED_RIGHT = 'last';

  const CLEAR_FLOAT_BOTH = 'clear-both';
  const CLEAR_FLOAT_LEFT = 'clear-left';
  const CLEAR_FLOAT_RIGHT = 'clear-right';
  const CLEAR_FLOAT_NONE = 'clear-none';

  public static function boot()
  {
    $am = AssetManager::vendorType('fortifi', 'ui');
    $am->requireCss('assets/css/ui-base');
  }
}
