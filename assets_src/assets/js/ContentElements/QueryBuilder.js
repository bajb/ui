/*
 * Query Builder
 */

(function ($)
{
  $.fn.qb = function (command, data)
  {
    if (!command)
    {
      command = 'init';
    }
    if (typeof QueryBuilder.prototype[command] !== 'function')
    {
      console.error('QueryBuilder command \'' + command + '\' not found');
      return;
    }
    var args = Array.prototype.slice.call(arguments);
    args.shift();
    var retVal = $(this);
    $(this).each(
      function ()
      {
        var $this = $(this),
          instance = $this.data('qb');
        if (!instance)
        {
          $this.data('qb', new QueryBuilder(this));
          instance = $this.data('qb');
        }
        var result = instance[command].apply(instance, args);
        if (result)
        {
          retVal = result;
        }
      }
    );
    return retVal;
  };

  $(document).on(
    'change', '.qb-rule .qb-key', function ()
    {
      $(this).closest('.qb-container').qb(
        'addRule', {key: $(this).val()},
        $(this).closest('.qb-rules .qb-rule').index()
      );
    }
  );
  $(document).on(
    'click', 'button.qb-remove-rule', function ()
    {
      $(this).closest('.qb-container').qb(
        'removeRule', $(this).closest('.qb-rules .qb-rule').index()
      );
    }
  );
  $(document).on(
    'click', 'button.qb-add-rule', function ()
    {
      $(this).closest('.qb-container').qb('addRule');
    }
  );

  /*
   * Public commands are below here
   */

  function QueryBuilder(ele)
  {
    this._ele = ele;
    this._options = [];
    this._definitions = [];
    this._rules = [];
  }

  QueryBuilder.prototype.init = function (options)
  {
    this.options(options);

    var $ele = $(this._ele);
    if ($ele.attr('data-qb-definitions'))
    {
      this.definitions($ele.attr('data-qb-definitions'));
    }
    if ($ele.attr('data-qb-rules'))
    {
      this.rules($ele.attr('data-qb-rules'));
    }
  };

  QueryBuilder.prototype.options = function (data)
  {
    if (typeof data === 'undefined')
    {
      return this._options;
    }
    this._options = data;
    this.redraw();
  };

  QueryBuilder.prototype.definitions = function (data)
  {
    var self = this;
    if (typeof data === 'undefined')
    {
      return this._definitions;
    }
    else if (typeof data === 'string')
    {
      $.getJSON(
        data, {}, function (defs)
        {
          self._definitions = defs;
          self.redraw();
        }
      );
      return;
    }
    this._definitions = data;
    this.redraw();
  };

  QueryBuilder.prototype.rules = function (data)
  {
    var self = this;
    if (typeof data == 'undefined')
    {
      var currentData = [];
      $('.qb-rules .qb-rule', $(this._ele)).each(
        function ()
        {
          var key = $('.qb-key', this).val();
          if (key)
          {
            currentData.push(
              {
                key:        key,
                comparator: $('.qb-comparator', this).val(),
                value:      $('.qb-value', this).val()
              }
            );
          }
        }
      );
      return currentData;
    }
    else if (typeof data === 'string')
    {
      if (data === 'query')
      {
        var rules = [], params = $.parseParams(window.location.search.substring(1));
        $.each(
          params, function (key, v)
          {
            if (typeof v === 'object')
            {
              rules.push({key: key, comparator: 'in', value: this});
            }
            else
            {
              rules.push({key: key, comparator: 'eq', value: this});
            }
          }
        );
        data = rules;
      }
      else
      {
        $.getJSON(
          data, {}, function (rules)
          {
            self._rules = rules;
            self.redraw();
          }
        );
        return;
      }
    }
    this._rules = data;
    this.redraw();
  };

  QueryBuilder.prototype.redraw = function ()
  {
    var self = this;
    if (!$(this._ele).hasClass('qb-container'))
    {
      $(this._ele).addClass('qb-container')
        .html($('<div class="qb-rules"/>'))
        .append($('<button class="qb-button qb-add-rule">+</button>'));
    }
    else
    {
      $('.qb-rules', this._ele).empty();
    }
    if (self._definitions && self._rules)
    {
      $.each(
        self._rules, function ()
        {
          self.addRule(this);
        }
      );
    }
  };

  var types = {
    'eq':  {string: 'text', number: 'number', date: 'date'},
    'neq': {string: 'text', number: 'number', date: 'date'},
    'in':  {string: 'token', number: 'token'},
    'nin': {string: 'token', number: 'token'},
    'gt':  {number: 'number', date: 'date', decimal: 'decimal'},
    'gte': {number: 'number', date: 'date', decimal: 'decimal'},
    'lt':  {number: 'number', date: 'date', decimal: 'decimal'},
    'lte': {number: 'number', date: 'date', decimal: 'decimal'},
    'bet': {number: 'number', date: 'date', decimal: 'decimal'},
    'age': {date: 'age'}
  };

  QueryBuilder.prototype.removeRule = function (idx)
  {
    $('.qb-rules .qb-rule', this._ele).get(idx).remove();
    if (!$('.qb-rule', this._ele).length)
    {
      this.addRule();
    }
  };

  QueryBuilder.prototype.addRule = function (ruleData, idx)
  {
    var $row = $('<div class="qb-rule"/>'),
      $propertySel = $('<select class="qb-key"/>').appendTo($row),
      ruleKey = ruleData ? ruleData.key : null,
      definition = ruleKey ? this._definitions[ruleKey] : null;
    if (!ruleKey)
    {
      $propertySel.append('<option> - SELECT -</option>');
    }
    if (ruleKey && !definition)
    {
      return;
    }
    $.each(
      this._definitions, function (optionKey)
      {
        var selected = ruleKey == optionKey;
        $propertySel.append('<option value="' + optionKey + '"' + (selected ? ' selected="selected"' : '') + '>' + this.display + '</option>');
      }
    );

    if (definition)
    {
      if (!definition.dataType)
      {
        definition.dataType = 'string';
      }
      if (definition['comparators'])
      {
        var $comparatorSel = $('<select class="qb-comparator"/>').appendTo($row);
        $.each(
          definition['comparators'], function (comparatorKey)
          {
            if (!ruleData.comparator)
            {
              ruleData.comparator = comparatorKey;
            }
            var selected = ruleData.comparator == comparatorKey;
            $comparatorSel.append('<option value="' + comparatorKey + '"' + (selected ? ' selected="selected"' : '') + '>' + this + '</option>');
          }
        );
      }
      getInput().appendTo($row);
    }
    $('<button class="qb-button qb-remove-rule">x</button>').appendTo($row);

    if (typeof idx !== 'undefined')
    {
      $('.qb-rule:eq(' + idx + ')', this._ele).replaceWith($row);
    }
    else
    {
      $row.appendTo($('.qb-rules', this._ele));
    }

    function getInput()
    {
      var $input, inputType;
      if (!ruleData.comparator && definition.dataType == 'bool')
      {
        inputType = 'bool'
      }
      else
      {
        inputType = types[ruleData.comparator][definition.dataType];
      }
      if (inputType == 'text' && definition.values && (!definition.ajaxUrl))
      {
        inputType = 'select';
      }
      if (!inputType)
      {
        console.error('Input type not found for ' + ruleData.comparator + ' ' + definition.dataType);
        return;
      }
      switch (inputType)
      {
        case 'text':
          // if ajaxUrl this should be typeahed
          $input = $('<input type="text" value="' + (ruleData.value ? ruleData.value : '') + '"/>');
          break;
        case 'number':
          $input = $('<input type="number" value="' + (ruleData.value ? ruleData.value : '') + '"/>');
          break;
        case 'bool':
          $input = $('<select><option value="1">True</option><option value="0">False</option></select>');
          break;
        case 'select':
          $input = $('<select/>');
          $.each(
            definition.values, function (idx)
            {
              $input.append('<option value="' + idx + '">' + this + '</option>');
            }
          );
          break;
        case 'token':
          $input = $('<input type="text" value="' + (ruleData.value ? ruleData.value : '') + '"/>');
          break;
        default:
          console.error('Input type not found for ' + inputType);
          return;
      }

      $input.addClass('qb-value');
      return $input;
    }
  };

  $(document).trigger('qb.ready');
})(jQuery);
