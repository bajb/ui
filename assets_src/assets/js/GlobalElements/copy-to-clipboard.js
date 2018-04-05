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

  $(document).on('click', selector, function ()
  {
    copyText($(this).data('copy'));

    $(this).prop('title', 'Copied!');
    $(this).tooltip('show');
  });

  $(document).on('mouseout', selector, function ()
  {
    $(this).tooltip('hide');
    $(this).tooltip('destroy');
  });

})(jQuery, window, document);
