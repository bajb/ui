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
    'click', 'button.qb-delRule', function ()
    {
      $(this).closest('.qb-rules .qb-rule').remove();
    }
  );
  $(document).on(
    'click', 'button.qb-addRule', function ()
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
    this._rules = [];
  }

  QueryBuilder.prototype.init = function ()
  {
    var $ele = $(this._ele);
    if ($ele.attr('data-qb-options'))
    {
      this.options($ele.attr('data-qb-options'));
    }
    if ($ele.attr('data-qb-rules'))
    {
      this.rules($ele.attr('data-qb-rules'));
    }
  };

  QueryBuilder.prototype.options = function (data)
  {
    var self = this;
    if (typeof data === 'undefined')
    {
      return this._options;
    }
    else if (typeof data === 'string')
    {
      $.getJSON(
        data, {}, function (options)
        {
          self._options = options;
          self.redraw();
        }
      );
      return;
    }
    this._options = data;
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
        var rules = [], params = $.parseParams(window.location.search);
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
    $(this._ele).addClass('qb-container')
      .html($('<div class="qb-rules"/>'))
      .append($('<button class="qb-addRule">+</button>'));
    if (self._options && self._rules)
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
      def = ruleKey ? this._options[ruleKey] : null;
    $propertySel.append('<option/>');
    if (!def)
    {
      return;
    }
    $.each(
      this._options, function (optionKey)
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
      $('.qb-rule:eq(' + idx + ')', this._ele).replaceWith($row);
    }
    else
    {
      $row.appendTo($('.qb-rules', this._ele));
    }
  };

  $(document).trigger('qb.ready');
})(jQuery);
