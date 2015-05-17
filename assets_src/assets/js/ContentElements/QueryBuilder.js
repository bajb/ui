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
        'addRule', {key: $(this).val()}, $(this).parent().index()
      );
    }
  );
  $(document).on(
    'click', 'button.qb-del-rule', function ()
    {
      $(this).closest('.qb-rules .qb-rule').remove();
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
        .append($('<button class="qb-add-rule">+</button>'));
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

  QueryBuilder.prototype.addRule = function (ruleData, idx)
  {
    var $row = $('<div class="qb-rule"/>'),
      $propertySel = $('<select class="qb-key"/>').appendTo($row),
      ruleKey = ruleData ? ruleData.key : null,
      def = ruleKey ? this._definitions[ruleKey] : null;
    $propertySel.append('<option/>');
    if (ruleKey && !def)
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
    $('<button class="qb-del-rule"><i class="fa fa-trash"></i></button>').appendTo($row);

    if (typeof idx !== 'undefined')
    {
      $('.qb-rule:eq(' + idx + ')', this._ele).replaceWith($row);
    }
    else
    {
      $row.appendTo($('.qb-rules', this._ele));
    }
  };

  $(document).trigger('qb.ready');
})(jQuery);
