/*
 * Query Builder
 */

(function ($)
{
  $.fn.QueryBuilder = function (command)
  {
    var args = Array.prototype.slice.call(arguments);
    if (!command)
    {
      command = 'init';
    }
    else if (typeof command === 'object')
    {
      command = 'init';
      args.unshift('init');
    }
    if (typeof QueryBuilder.prototype[command] !== 'function')
    {
      console.error('QueryBuilder command \'' + command + '\' not found');
      return;
    }
    args.shift();
    var retVal = $(this);
    $(this).each(
      function ()
      {
        var $this = $(this),
          instance = $this.data('QueryBuilder');
        if (!instance)
        {
          $this.data('QueryBuilder', new QueryBuilder(this));
          instance = $this.data('QueryBuilder');
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
      $(this).closest('.qb-container').QueryBuilder(
        'addRule', {key: $(this).val()},
        $(this).closest('.qb-rules .qb-rule').index()
      ).trigger('change.querybuilder');
    }
  );
  $(document).on(
    'change', '.qb-rule .qb-comparator', function ()
    {
      var $rule = $(this).closest('.qb-rules .qb-rule');
      $(this).closest('.qb-container').QueryBuilder(
        'addRule', {
          key:        $('.qb-key', $rule).val(),
          comparator: $(this).val(),
          value:      $('.qb-value', $rule).val()
        },
        $rule.index()
      ).trigger('change.querybuilder');
    }
  );
  $(document).on(
    'change', '.qb-container .qb-value', function ()
    {
      $(this).closest('.qb-container').trigger('change.querybuilder');
    }
  );
  $(document).on(
    'click', 'button.qb-remove-rule', function ()
    {
      $(this).closest('.qb-container').QueryBuilder(
        'removeRule', $(this).closest('.qb-rules .qb-rule').index()
      ).trigger('change.querybuilder');
    }
  );
  $(document).on(
    'click', 'button.qb-add-rule', function ()
    {
      $(this).closest('.qb-container').QueryBuilder('addRule');
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
    if (options && 'definitions' in options)
    {
      this.definitions(options.definitions);
    }
    else if ($ele.data('qb-definitions'))
    {
      this.definitions($ele.data('qb-definitions'));
    }

    if (options && 'rules' in options)
    {
      this.rules(options.rules);
    }
    else if ($ele.data('qb-rules'))
    {
      this.rules($ele.data('qb-rules'));
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

  QueryBuilder.prototype.getQueryString = function ()
  {
    var params = {};
    $.each(
      this.rules(), function ()
      {
        if (params[this.key] || this.comparator == 'in')
        {
          if (!params[this.key])
          {
            params[this.key] = [];
          }
          if (typeof params[this.key] == 'string')
          {
            params[this.key] = [params[this.key]];
          }
          params[this.key].push(this.value);
        }
        else
        {
          params[this.key] = this.value;
        }
      }
    );
    return $.param(params);
  };

  QueryBuilder.prototype.rules = function (data)
  {
    var self = this;
    if (typeof data == 'undefined')
    {
      // no data - return object of all rules
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
                comparator: $(
                  '.qb-comparator', this
                ).val() ? $('.qb-comparator', this).val() : 'eq',
                value:      $('.qb-value', this).val()
              }
            );
          }
        }
      );
      return currentData;
    }
    // if data is object, read it into rules
    else if (typeof data === 'object')
    {
      $.each(
        data, function (key)
        {
          if (typeof this == 'object')
          {
            rules.push(this);
          }
          else
          {
            rules.push({key: key, comparator: 'eq', value: this});
          }
        }
      );
    }
    else if (typeof data === 'string')
    {
      if (data === 'query')
      {
        // string 'query' specified - set data based on query string
        var rules = [], params = $.parseParams(window.location.search);
        /* TODO: iterate definitions and find param, not blindly add all params
         * NOTE: we may not have the definitions yet....
         */
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
    if (self._definitions)
    {
      // add rules
      if (self._rules.length)
      {
        $.each(
          self._rules, function ()
          {
            self.addRule(this);
          }
        );
        $(self._ele).trigger('init.querybuilder');
      }
      // add any required fields which are not already added
      $.each(
        self._definitions, function (defKey)
        {
          if (this.required)
          {
            var found = false;
            $.each(
              self._rules, function ()
              {
                if (this.key == defKey)
                {
                  found = true;
                }
              }
            );
            if (!found)
            {
              self.addRule({key: defKey});
            }
          }
        }
      );

      // if no rules, add an empty one
      if (!$('.qb-rules .qb-rule', this._ele).length)
      {
        self.addRule();
      }

      if (this._definitions.length)
      {
        var count = 0;
        $.each(
          this._definitions, function ()
          {
            if (!this.required)
            {
              count++;
            }
          }
        );
        if (!count)
        {
          $('.qb-add-rule').hide();
        }
      }
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
  var typeNames = {
    'eq':  'Equals',
    'neq': 'Does Not Equal',
    'in':  'In',
    'nin': 'Not In',
    'gt':  'Greater Than',
    'gte': 'Greater Than or Equal to',
    'lt':  'Less Than',
    'lte': 'Less Than or Equal to',
    'bet': 'Between',
    'age': 'was'
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
      $propertySel.append('<option value=""> - SELECT -</option>');
    }
    if (ruleKey && !definition)
    {
      return;
    }
    $.each(
      this._definitions, function (optionKey)
      {
        if (this.required && ruleKey !== optionKey)
        {
          return;
        }
        var selected = (ruleKey == optionKey) ? ' selected="selected"' : '';
        $propertySel.append('<option' + selected + ' value="' + optionKey + '">' + this.display + '</option>');
      }
    );

    if (definition)
    {
      if (definition.required)
      {
        $propertySel.attr('disabled', 'disabled');
      }
      if (!definition.dataType)
      {
        definition.dataType = 'string';
      }
      if (definition['comparators'])
      {
        var $comparatorSel = $('<select class="qb-comparator"/>').appendTo($row);
        $.each(
          definition['comparators'], function ()
          {
            if (!ruleData.comparator)
            {
              ruleData.comparator = this;
            }
            var selected = (ruleData.comparator == this) ? ' selected="selected"' : '';
            $comparatorSel.append('<option' + selected + ' value="' + this + '">' + typeNames[this] + '</option>');
          }
        );
      }
      getInput().appendTo($row);
    }
    if (definition && !definition.required)
    {
      $('<button class="qb-button qb-remove-rule">x</button>').appendTo($row);
    }

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
      if (inputType == 'select' && ruleData.value && (!(ruleData.value in definition.values)))
      {
        inputType = 'text';
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
              var selected = (idx == ruleData.value) ? ' selected="selected"' : '';
              $input.append('<option' + selected + ' value="' + idx + '">' + this + '</option>');
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

  $(document).trigger('ready.querybuilder');
})(jQuery);
