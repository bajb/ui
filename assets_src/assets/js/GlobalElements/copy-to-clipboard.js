/* global jQuery */
(function ($, window, document, undefined)
{
  'use strict';

  var selector = '[data-copy]';

  function copyText(text)
  {
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

  function isBase64Encoded(content)
  {
    if(content !== undefined)
    {
      try
      {
        return btoa(atob(content)) === content;
      }
      catch(err)
      {
      }
    }

    return false;
  }

  $(document).on('click', selector, function ()
  {
    var selector = $(this).data('copy');

    if(selector !== undefined)
    {
      if(!isBase64Encoded(selector))
      {
        selector = btoa(selector);
      }

      var target = atob(selector);

      copyText($(target).text());

      $(this).prop('title', 'Copied!');
      $(this).tooltip('show');
    }
  });

  $(document).on('mouseout', selector, function ()
  {
    $(this).tooltip('hide');
    $(this).tooltip('destroy');
  });

})(jQuery, window, document);
