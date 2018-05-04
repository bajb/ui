(function ($, window, document)
{
  'use strict';

  window.QueryBuilderConstants = window.QueryBuilderConstants || {};

  // add tokenizer input
  var INPUT_TOKEN = 'token';

  const MULTI_INPUT_COMPARATORS = [
    QueryBuilderConstants.COMPARATOR_LIKE,
    QueryBuilderConstants.COMPARATOR_NOT_LIKE,
    QueryBuilderConstants.COMPARATOR_LIKE_IN,
    QueryBuilderConstants.COMPARATOR_NOT_LIKE_IN
  ];

  var QueryBuilderTokenInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      this._selectBox = null;
      //this._rule._value = this.sanitize(this._rule._value);
    }

    Constructor.prototype.sanitize = function (value)
    {
      if(MULTI_INPUT_COMPARATORS.indexOf(this._rule.getComparator()) === -1)
      {
        if(typeof(value) === 'object')
        {
          value = value && value[0] ? value[0] : '';
        }
        value = value || '';
      }
      else
      {
        if(typeof(value) === 'string')
        {
          value = value ? [value] : null;
        }
        if(value && value.length === 0)
        {
          value = null;
        }
      }
      return value;
    };

    Constructor.prototype.tokenChanged = function (value, text, e)
    {
      var $tok = this._selectBox.tokenize2(),
        val = $tok.toArray();

      if($tok.options.tokensMaxItems === 1 && val.length === 1)
      {
        val = val[0];
      }
      var comparator = this._rule.getComparator();
      if(comparator === QueryBuilderConstants.COMPARATOR_IN
        || comparator === QueryBuilderConstants.COMPARATOR_NOT_IN
        || comparator === QueryBuilderConstants.COMPARATOR_LIKE_IN
        || comparator === QueryBuilderConstants.COMPARATOR_NOT_LIKE_IN)
      {
        this._rule._setValue(val.length ? val : undefined);
      }
      else
      {
        this._rule._setValue(val.length ? val : '');
      }
    };

    Constructor.prototype.render = function ()
    {
      return this._selectBox = $(
        '<select class="qb-tokenizer qb-input" multiple/>'
      );
    };

    Constructor.prototype.postRender = function ()
    {
      var self = this, def = this._rule.getDefinition();

      /* VALUES */
      var vals = this._rule._value;
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
            if(Object.keys(defVals).indexOf(val) === -1)
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
                $option.prop('selected', true);
              }
              self._selectBox.append($option);
            }
          }
        );
      }

      /* OPTIONS */
      var options = {debounce: 250};
      options.tokensAllowCustom = !def.isStrict();
      if(def.hasAjaxValues())
      {
        options.dataSource = def.valuesUrl;
      }
      // in = multiple values
      // eq = single value
      if(MULTI_INPUT_COMPARATORS.indexOf(this._rule.getComparator()) === -1)
      {
        options.tokensMaxItems = 1;
      }

      /* TOKENIZE */
      this._selectBox.tokenize2(options);

      /* ADD VALUES */
      $.each(
        vals, function (idx, val)
        {
          if(val !== null)
          {
            self._selectBox.trigger(
              'tokenize:dropdown:itemAdd',
              {value: val, text: val}
            );
            self._selectBox.trigger(
              'tokenize:tokens:add',
              [val, val, true]
            );
          }
        }
      );

      /* EVENTS */
      $(this._selectBox).on(
        'tokenize:tokens:add tokenize:tokens:remove tokenize:clear',
        function (e, value, text)
        {
          self.tokenChanged(value, text, e);
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
        || (MULTI_INPUT_COMPARATORS.indexOf(comparator) > -1)
      )
      {
        return INPUT_TOKEN;
      }
    }
  }
}(jQuery, window, document));
