var QueryBuilder = {
  options:       [],
  data:          [],
  configuration: {}
};

var QueryBuilderComparators = {
  BETWEEN:           'between',
  IN:                'in',
  IN_CASE_SENSITIVE: 'in_sensitive',
  EQUAL:             'equal',
  EXACT:             'exact',
  LIKE:              'like',
  STARTS:            'starts',
  ENDS:              'ends',
  IPRANGE:           'iprange',
  RANGE:             'range',
  GREATER:           'greater',
  LESS:              'less'
};

var QueryBuilderValueMode = {
  TEXT:   'text',
  SELECT: 'select',
  TOKEN:  'token',
  SELEXT: 'selext'
};

+function ($)
{
  var QueryBuilderOption = {
    'key':         '',
    'display':     '',
    'comparators': [QueryBuilderComparators.EQUAL],// QueryBuilderComparators.IN],
    'values':      ['UK', 'US', 'AU'],
    'ajaxUrl':     '',
    'mode':        QueryBuilderValueMode.TEXT
  };

  QueryBuilder.addOption = function (option)
  {
    this.data.push(option);
  };

  QueryBuilder.init = function ()
  {
    console.log("Starting Query Builder");
    QueryBuilder.configuration = {};
    QueryBuilder.options = QueryBuilder.data = [];
    QueryBuilder.addOption(QueryBuilderOption);
    console.log(QueryBuilder);
    console.log("Completed Query Builder Init");
  };

  $.fn.qb = function (command, data)
  {
    var $this = $(this);
    $this.addClass('qb-container');

    var options = $this.data('qb.options'),
      rules = $this.data('qb.rules');

    switch (command)
    {
      case 'init':
        $this.each(
          function ()
          {
            var $qb = $(this),
              opUrl = $qb.attr('data-qb-options'),
              ruUrl = $qb.attr('data-qb-rules');
            if (opUrl)
            {
              $.getJSON(
                opUrl, {}, function (op)
                {
                  $qb.qb('options', op);
                }
              );
            }
            if (ruUrl)
            {
              $.getJSON(
                ruUrl, {}, function (rules)
                {
                  $qb.qb('rules', rules);
                }
              );
            }
          }
        );
        return;
      case 'options':
        options = data;
        $this.data('qb.options', options);
        break;
      case 'rules':
        rules = data;
        $this.data('qb.rules', rules);
        break;
      case 'addRule':
        var args = Array.prototype.slice.call(arguments);
        args.shift();
        addRule.apply(this, args);
        return;
      case 'getRules':
        var currentData = [];
        $('.qb-rules .qb-rule', $this).each(
          function ()
          {
            currentData.push(
              {
                key:        $('.qb-key', this).val(),
                comparator: $('.qb-comparator', this).val(),
                value:      $('.qb-value', this).val()
              }
            );
          }
        );
        return currentData;
        break;
      default:
        return;
    }

    if (options && rules)
    {
      $('<div class="qb-rules"/>').appendTo($this);
      $.each(
        rules, function ()
        {
          addRule(this);
        }
      );
      $('<button class="qb-addRule">+</button>').appendTo($this);
    }

    function addRule(ruleData, idx)
    {
      var $row = $('<div class="qb-rule"/>'),
        $propertySel = $('<select class="qb-key"/>').appendTo($row),
        ruleKey = ruleData ? ruleData.key : null,
        def = ruleKey ? options[ruleKey] : null;
      $propertySel.append('<option/>');

      $.each(
        options, function (optionKey)
        {
          var selected = ruleKey == optionKey;
          $propertySel.append('<option value="' + optionKey + '"' + (selected ? ' selected="selected"' : '') + '>' + this.display + '</option>');
        }
      );

      if (def)
      {
        var $comparatorSel = $('<select class="qb-comparator"/>').appendTo($row);
        $.each(
          def['comparators'], function (comparatorKey)
          {
            var selected = ruleData.comparator == comparatorKey;
            $comparatorSel.append('<option value="' + comparatorKey + '"' + (selected ? ' selected="selected"' : '') + '>' + this + '</option>');
          }
        );

        $('<input class="qb-value" type="text" value="' + (ruleData.value ? ruleData.value : '') + '"/>').appendTo($row);
      }
      $('<button class="qb-delRule"><i class="fa fa-trash"></i></button>').appendTo($row);

      if (typeof idx !== 'undefined')
      {
        $('.qb-rule:eq(' + idx + ')', $this).replaceWith($row);
      }
      else
      {
        $row.appendTo($('.qb-rules', $this));
      }
    }
  };

  $(document).on(
    'change', '.qb-rule .qb-key', function ()
    {
      $(this).closest('.qb-container').qb(
        'addRule', {key: $(this).val()}, $(this).parent().index()
      );
    }
  );
  $(document).on(
    'click', 'button.qb-delRule', function ()
    {
      $(this).closest('.qb-rules.qb-rule').remove();
    }
  );
  $(document).on(
    'click', 'button.qb-addRule', function ()
    {
      $(this).closest('.qb-container').qb('addRule');
    }
  );
}(jQuery);

function initExample()
{
  $('.query-builder').qb('init');
  $('.getData').on(
    'click', function ()
    {
      console.table($(this).prev('.qb-container').qb('getRules'));
    }
  );
}
$(initExample); //Document Load
