<?php
namespace Fortifi\Ui\GlobalElements\Cards;

interface ICardActionType
{
  const ACTION_TYPE_CREATE = 'create';
  const ACTION_TYPE_EDIT = 'edit';
  const ACTION_TYPE_REMOVE = 'remove';
  const ACTION_TYPE_DELETE = 'delete';
  const ACTION_TYPE_RESTORE = 'restore';
  const ACTION_TYPE_VIEW = 'view';
  const ACTION_TYPE_DISABLE = 'disable';
  const ACTION_TYPE_ENABLE = 'enable';
  const ACTION_TYPE_APPROVE = 'approve';
  const ACTION_TYPE_VERIFY = 'verify';
  const ACTION_TYPE_DECLINE = 'decline';
  const ACTION_TYPE_LOCK = 'lock';
  const ACTION_TYPE_UNLOCK = 'unlock';
  const ACTION_TYPE_IS_DEFAULT = 'is-default';
  const ACTION_TYPE_MAKE_DEFAULT = 'make-default';
  const ACTION_TYPE_PAUSE = 'pause';
  const ACTION_TYPE_RESUME = 'resume';
}
