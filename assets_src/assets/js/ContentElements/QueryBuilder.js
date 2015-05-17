/*
 * Query Builder
 */

(function ($)
{
  $.fn.qb = function (command, data)
  {
    if (typeof QueryBuilder.prototype[command] !== 'function')
    {
      console.error('QueryBuilder command \'' + command + '\' not found');
      return;
    }
    var args = Array.prototype.slice.call(arguments);
    args.shift();
    var retVal = null;
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
        retVal = instance[command].apply(instance, args);
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
    var self = this,
      opUrl = $(this._ele).attr('data-qb-options'),
      ruUrl = $(this._ele).attr('data-qb-rules');
    if (opUrl)
    {
      $.getJSON(
        opUrl, {}, function (data)
        {
          self.options(data);
        }
      );
    }
    if (ruUrl)
    {
      $.getJSON(
        ruUrl, {}, function (data)
        {
          self.rules(data);
        }
      );
    }
  };

  QueryBuilder.prototype.options = function (data)
  {
    this._options = data;
    this.redraw();
  };

  QueryBuilder.prototype.rules = function (data)
  {
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
})(jQuery);
