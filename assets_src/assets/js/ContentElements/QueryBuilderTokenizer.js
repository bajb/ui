(function ($, window, document)
{
  'use strict';

  window.QueryBuilderConstants = window.QueryBuilderConstants || {};

  // add tokenizer input
  const INPUT_TOKEN = 'token';

  var QueryBuilderTokenInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      this._token = null;
      if(this._rule._value === null)
      {
        this._rule._value = '';
      }
    }

    Constructor.prototype.tokenChanged = function (value, text, e)
    {
      var val = this._token.tokenize().toArray();
      this._rule._setValue(val.length ? val : '');
    };

    Constructor.prototype.render = function ()
    {
      var $token = $('<select class="qb-tokenizer qb-input"/>');
      this._token = $token;
      return $token;
    };

    Constructor.prototype.postRender = function ()
    {
      var self = this,
        def = this._rule.getDefinition(),
        vals = this._rule._value,
        options = {
          debounce:      250,
          autosize:      true,
          onAddToken:    function (value, text, e)
                         {
                           self.tokenChanged(
                             value, text, e
                           )
                         },
          onRemoveToken: function (value, text, e)
                         {
                           self.tokenChanged(
                             value, text, e
                           )
                         }
        };

      if(!(vals instanceof Object))
      {
        vals = [vals];
      }

      if(def.hasValues())
      {
        var defVals = $.extend({}, def.values);
        $.each(
          vals, function (idx, val)
          {
            if(Object.keys(defVals).indexOf(val) == -1)
            {
              defVals[val] = val;
            }
          }
        );
        $.each(
          defVals, function (idx)
          {
            if(idx)
            {
              var $option = $('<option/>').val(encodeURIComponent(idx));
              if(vals.indexOf(idx) > -1)
              {
                $option.attr('selected', 'selected');
              }
              self._token.append($option);
            }
          }
        );
      }

      if(def.isStrict())
      {
        options.newElements = false;
      }
      if(def.hasAjaxValues())
      {
        options.datas = def.valuesUrl;
      }
      // in = multiple values
      // eq = single value
      if([
          QueryBuilderConstants.COMPARATOR_IN,
          QueryBuilderConstants.COMPARATOR_NOT_IN
        ].indexOf(this._rule.getComparator()) < 0)
      {
        options.maxElements = 1;
      }
      this._token.tokenize(options);
      $.each(
        vals, function (idx, val)
        {
          self._token.tokenize().dropdownAddItem(val, val).tokenAdd(val, val);
        }
      );
    };

    return Constructor;
  })();

  // add jquery method for attaching tokenizer to
  $(document).on(
    'init.querybuilder', function (e, qb)
    {
      qb.setInputMethod(INPUT_TOKEN, QueryBuilderTokenInput);
      qb.addInputTypeProcessor(tokenIfAjax);
    }
  );

  function tokenIfAjax(comparator, dataType, rule)
  {
    var definition = rule.getDefinition();
    if(definition && definition.hasAjaxValues())
    {
      return INPUT_TOKEN;
    }
  }
}(jQuery, window, document));
