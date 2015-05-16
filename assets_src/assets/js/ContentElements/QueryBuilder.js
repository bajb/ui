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
    console.log(QueryBuilder)
    ;
    console.log("Completed Query Builder Init");
  };

  $.fn.qb = function (command, data)
  {
    var $this = $(this);
    switch(command){
      case 'options':
        $this.data('qb.options', data);
        break;
      case 'rules':
        $this.data('qb.rules', data);
        break;
      case 'getData':
        $('div',$this).each(function(){

        });
        break;
    }

    var options = $this.data('qb.options'),
      rules = $this.data('qb.rules');

    if (options && rules)
    {
//      addRule('', this);
      $.each(
        rules, function (idx)
        {
          addRule(idx, this);
        }
      );
    }

    function addRule(key, ruleData)
    {
      console.log(ruleData);
      var $row = $('<div/>').appendTo($this),
        $propertySel = $('<select/>').appendTo($row),
        $comparatorSel = $('<select/>').appendTo($row),
        def = options[key];

      $propertySel.append('<option/>');
      $.each(
        options, function (optionKey)
        {
          var selected = key == optionKey;
          $propertySel.append('<option value="' + optionKey + '"' + (selected ? ' selected="selected"' : '') + '>' + this.display + '</option>');
        }
      );

      console.log(options[key]);
      $comparatorSel.append('<option/>');
      $.each(
        options[key]['comparators'], function (comparatorKey)
        {
          var selected = ruleData.comparator == comparatorKey;
          $comparatorSel.append('<option value="' + comparatorKey + '"' + (selected ? ' selected="selected"' : '') + '>' + this + '</option>');
        }
      );

      $('<input type="text" value="'+ruleData.value+'"/>').appendTo($row);
    }
  };

  //$(QueryBuilder.init); //Document Load
  //$(document).on('pagelet.load', QueryBuilder.init); //Pagelet Load

}(jQuery);

$.getJSON(
  '/querybuilder/policy', {}, function (data)
  {
    $('#policyQuery').qb('rules', data);
  }
);

$.getJSON(
  '/querybuilder/options', {}, function (options)
  {
    $('#policyQuery').qb('options', options);
  }
);
