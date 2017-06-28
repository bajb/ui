(function ($, window, document)
{
  'use strict';

  window.QueryBuilderConstants = window.QueryBuilderConstants || {};

  // add tokenizer input
  var INPUT_TOKEN = 'token';

  var QueryBuilderTokenInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      this._selectBox = null;
      if(this._rule._value === null)
      {
        this._rule._value = '';
      }
    }

    Constructor.prototype.tokenChanged = function (value, text, e)
    {
      var $tok = this._selectBox.tokenize(),
        val = $tok.toArray();

      if($tok.options.maxElements === 1 && val.length === 1)
      {
        val = val[0];
      }
      this._rule._setValue(val.length ? val : '');
    };

    Constructor.prototype.render = function ()
    {
      return this._selectBox = $(
        '<select class="qb-tokenizer qb-input" multiple="multiple"/>'
      );
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
                           self.tokenChanged(value, text, e);
                         },
          onRemoveToken: function (value, text, e)
                         {
                           self.tokenChanged(value, text, e);
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
              var $option = $('<option/>')
                .text(defVals[idx])
                .val(encodeURIComponent(idx));
              if(vals.indexOf(idx) > -1)
              {
                $option.attr('selected', 'selected');
              }
              self._selectBox.append($option);
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
          QueryBuilderConstants.COMPARATOR_NOT_IN,
          QueryBuilderConstants.COMPARATOR_LIKE_IN
        ].indexOf(this._rule.getComparator()) == -1)
      {
        options.maxElements = 1;
      }
      this._selectBox.tokenize(options);
      $.each(
        vals, function (idx, val)
        {
          self._selectBox.tokenize()
              .dropdownAddItem(val, val)
              .tokenAdd(val, val);
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
    if(definition)
    {
      if(definition.hasAjaxValues()
        || (definition.hasValues() && !definition.isStrict())
        || comparator == QueryBuilderConstants.COMPARATOR_IN
        || comparator == QueryBuilderConstants.COMPARATOR_NOT_IN
        || comparator == QueryBuilderConstants.COMPARATOR_LIKE_IN
      )
      {
        return INPUT_TOKEN;
      }
    }
  }
}(jQuery, window, document));
