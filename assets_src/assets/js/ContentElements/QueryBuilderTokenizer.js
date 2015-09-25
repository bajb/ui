var QueryBuilderConstants = QueryBuilderConstants || {};

(function ()
{
  // add tokenizer input
  QueryBuilderConstants.INPUT_TOKEN = 'token';

  /**
   * @returns {jQuery}
   */
  function tokenInput()
  {
    var def = this.getDefinition(),
      $token = $('<select class="qb-input qb-tokenizer"/>');

    if (def.hasValues())
    {
      var defVals = $.extend({}, def.values),
        vals = this._value;
      if (!(vals instanceof Object))
      {
        vals = [vals];
      }
      $.each(
        vals, function (idx, val)
        {
          if (Object.keys(defVals).indexOf(val) == -1)
          {
            defVals[val] = val;
          }
        }
      );
      $.each(
        defVals, function (idx)
        {
          var $option = $('<option/>').text(this).attr('value', idx);
          if (vals.indexOf(idx) > -1)
          {
            $option.attr('selected', 'selected');
          }
          $token.append($option);
        }
      );
    }
    return $token;
  }

  $(document).on(
    'render.querybuilder', function (e, rule)
    {
      var $ele = $('.qb-tokenizer', rule.getElement());
      if ($ele.length)
      {
        function setVal(value, text, e)
        {
          var val = $ele.tokenize().toArray();
          rule.setValue(val.length ? val : '');
        }

        var def = rule.getDefinition(),
          options = {
            autosize:      true,
            onAddToken:    setVal,
            onRemoveToken: setVal
          };
        if (def.isStrict())
        {
          options.newElements = false;
        }
        if (def.hasAjaxValues())
        {
          options.datas = def.valuesUrl;
        }
        // in = multiple values
        // eq = single value
        if ([QueryBuilderConstants.COMPARATOR_IN, QueryBuilderConstants.COMPARATOR_NOT_IN]
            .indexOf(rule.getComparator()) < 0)
        {
          options.maxElements = 1;
        }
        $ele.tokenize(options);

        var vals = rule.getValue();
        if (!(vals instanceof Object))
        {
          vals = [vals];
        }
        $.each(
          vals, function (idx, val)
          {
            $ele.tokenize().tokenAdd(val, val);
          }
        );
      }
    }
  );

  // add jquery method for attaching tokenizer to
  $(document).on(
    'init.querybuilder', function (e, qb)
    {
      qb.setInputMethod(QueryBuilderConstants.INPUT_TOKEN, tokenInput);
      qb.setInputType(
        QueryBuilderConstants.COMPARATOR_IN,
        QueryBuilderConstants.DATATYPE_STRING,
        QueryBuilderConstants.INPUT_TOKEN
      );
      qb.setInputType(
        QueryBuilderConstants.COMPARATOR_IN,
        QueryBuilderConstants.DATATYPE_NUMBER,
        QueryBuilderConstants.INPUT_TOKEN
      );
      qb.setInputType(
        QueryBuilderConstants.COMPARATOR_NOT_IN,
        QueryBuilderConstants.DATATYPE_STRING,
        QueryBuilderConstants.INPUT_TOKEN
      );
      qb.setInputType(
        QueryBuilderConstants.COMPARATOR_NOT_IN,
        QueryBuilderConstants.DATATYPE_NUMBER,
        QueryBuilderConstants.INPUT_TOKEN
      );
      qb.addInputTypeProcessor(tokenIfAjax);
    }
  );

  function tokenIfAjax(rule)
  {
    var definition = rule.getDefinition();
    if (definition && definition.hasAjaxValues())
    {
      return QueryBuilderConstants.INPUT_TOKEN;
    }
  }
})();
