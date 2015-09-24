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
    var $token = $(
      '<select multiple="multiple" class="qb-input qb-tokenizer"/>'
    );
    if (this.getDefinition().values)
    {
      var defVals = $.extend({}, this.getDefinition().values),
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
    'render.querybuilder', function (e, r)
    {
      var $ele = $('.qb-tokenizer', r.getElement());
      if ($ele.length)
      {
        function setVal(value, text, e)
        {
          var val = $ele.tokenize().toArray();
          r.setValue(val.length ? val : '');
        }

        $ele.tokenize(
          {
            autosize:      true,
            onAddToken:    setVal,
            onRemoveToken: setVal
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
    }
  );
})();
