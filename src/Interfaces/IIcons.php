<?php
namespace Fortifi\Ui\Interfaces;

interface IIcons
{
  const CREATE = 'fa-plus';
  const EDIT = 'fa-pencil';
  const DELETE = 'fa-times';
  const LOCK = 'fa-lock';
  const UNLOCK = 'fa-unlock';
  const MAKE_DEFAULT = 'fa-star-o';
  const CURRENT_DEFAULT = 'fa-star';
  const TICK = 'fa-check';
  const CROSS = 'fa-times';
  const BAN = 'fa-ban';
  const VIEW = 'fa-eye';
  const TOGGLE_ON = 'fa-toggle-on';
  const TOGGLE_OFF = 'fa-toggle-off';

  const USER = 'fa-user';
  const EMAIL = 'fa-at';
  const PORTAL = 'fa-globe';
  const WORKFLOW = 'fa-random';
  const SECURITY = 'fa-lock';
  const BILLING = 'fa-money';

  const QUESTION = 'fa-question';
  const INCIDENT = 'fa-flash';
  const PROBLEM = 'fa-exclamation';
  const SUPPORT = 'fa-life-ring';

  const URGENCY = 'fa-heartbeat';
  const IMPACT = 'fa-arrow-up';

  const ATTACHMENT = 'fa-paperclip';

  /**
   * Policies
   */
  const COMMISSION = 'fa-money';
  const TRAFFIC_BLOCKS = 'fa-shield';
  const ACTION_VISIBILITY = 'fa-child';
  const REVERSALS = 'fa-undo';
  const TQP = 'fa-random';
  const AUTO_TQP = 'fa-line-chart';
}
