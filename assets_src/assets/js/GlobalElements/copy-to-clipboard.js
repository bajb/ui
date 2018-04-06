/* global jQuery */
(function ($, window, document, undefined)
{
  'use strict';

  var selector = '[data-copy]';

  function copyText(text)
  {
    if(text === undefined)
    {
      throw new Error('No text passed to copyText method in Project: Ui; File: copy-to-clipboard.js;');
    }

    function selectElementText(element)
    {
      if(document.selection)
      {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
      }
      else if(window.getSelection)
      {
        var range = document.createRange();
        range.selectNode(element);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
      }
    }

    var element = document.createElement('DIV');
    element.textContent = text;
    document.body.appendChild(element);
    selectElementText(element);
    document.execCommand('copy');
    element.remove();
  }

  function removeTooltip($tooltip)
  {
    if(($tooltip !== undefined))
    {
      if(($tooltip.attr('data-toggle') !== undefined) && ($tooltip.attr('data-toggle') === 'tooltip'))
      {
        $tooltip.removeAttr('data-toggle');
        $tooltip.tooltip('hide');
        $tooltip.tooltip('destroy');
      }
    }
  }

  $(document).on('click', selector, function ()
  {
    var self = this;

    // copy text to clipboard
    copyText($(this).data('copy'));

    // remove all pre-existing tooltips
    removeTooltip($('[data-toggle="tooltip"]'));

    // create tooltip for this object
    $(this).prop('title', 'Copied!');
    $(this).attr('data-toggle', 'tooltip');
    $(this).attr('data-trigger', 'focus');
    $(this).tooltip('show');

    // automatically remove this tooltip after timeout
    setTimeout(function() {removeTooltip($(self))}, 3000);
  });

})(jQuery, window, document);
