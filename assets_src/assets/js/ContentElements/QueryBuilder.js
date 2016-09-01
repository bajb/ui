/*
 * Query Builder
 */

(function ($, window, document, undefined)
{
  'use strict';

  window.QueryBuilderConstants = window.QueryBuilderConstants || {};

  var QB_DATA_NS = 'querybuilder';
  var QB_DATA_NS_RULE = QB_DATA_NS + '.rule';

  QueryBuilderConstants.INPUT_TEXT = 'text';
  QueryBuilderConstants.INPUT_NUMBER = 'number';
  QueryBuilderConstants.INPUT_DECIMAL = 'decimal';
  QueryBuilderConstants.INPUT_SELECT = 'select';
  QueryBuilderConstants.INPUT_DATE = 'date';
  QueryBuilderConstants.INPUT_BOOL = 'bool';
  QueryBuilderConstants.INPUT_AGE = 'age';
  QueryBuilderConstants.INPUT_BETWEEN = 'between';
  QueryBuilderConstants.DATATYPE_STRING = 'string';
  QueryBuilderConstants.DATATYPE_NUMBER = 'number';
  QueryBuilderConstants.DATATYPE_DECIMAL = 'decimal';
  QueryBuilderConstants.DATATYPE_DATE = 'date';
  QueryBuilderConstants.DATATYPE_BOOL = 'bool';
  QueryBuilderConstants.COMPARATOR_EQUALS = 'eq';
  QueryBuilderConstants.COMPARATOR_NOT_EQUAL = 'neq';
  QueryBuilderConstants.COMPARATOR_EQUALS_INSENSITIVE = 'eqi';
  QueryBuilderConstants.COMPARATOR_NOT_EQUALS_INSENSITIVE = 'neqi';
  QueryBuilderConstants.COMPARATOR_IN = 'in';
  QueryBuilderConstants.COMPARATOR_NOT_IN = 'nin';
  QueryBuilderConstants.COMPARATOR_GREATER = 'gt';
  QueryBuilderConstants.COMPARATOR_GREATER_EQUAL = 'gte';
  QueryBuilderConstants.COMPARATOR_LESS = 'lt';
  QueryBuilderConstants.COMPARATOR_LESS_EQUAL = 'lte';
  QueryBuilderConstants.COMPARATOR_BETWEEN = 'bet';
  QueryBuilderConstants.COMPARATOR_NOT_BETWEEN = 'nbet';
  QueryBuilderConstants.COMPARATOR_LIKE = 'like';
  QueryBuilderConstants.COMPARATOR_NOT_LIKE = 'nlike';
  QueryBuilderConstants.COMPARATOR_STARTS = 'starts';
  QueryBuilderConstants.COMPARATOR_NOT_STARTS = 'nstarts';
  QueryBuilderConstants.COMPARATOR_ENDS = 'ends';
  QueryBuilderConstants.COMPARATOR_NOT_ENDS = 'nends';
  QueryBuilderConstants.COMPARATOR_BEFORE = 'before';
  QueryBuilderConstants.COMPARATOR_AFTER = 'after';

  $.fn.QueryBuilder = function (command)
  {
    var args = Array.prototype.slice.call(arguments);
    if(!command)
    {
      command = 'init';
    }
    else if(typeof command === 'object')
    {
      command = 'init';
      args.unshift('init');
    }
    if(typeof QueryBuilder.prototype[command] !== 'function')
    {
      throw 'QueryBuilder command \'' + command + '\' not found';
    }
    args.shift();
    var retVal = $(this);
    $(this).each(
      function ()
      {
        var $this = $(this), instance = $this.data(QB_DATA_NS);
        if(!instance)
        {
          $this.data(QB_DATA_NS, new QueryBuilder(this));
          instance = $this.data(QB_DATA_NS);
        }
        var result = instance[command].apply(instance, args);
        if(result)
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
      var $container = $(this).closest('.qb-container'),
        qb = $container.data(QB_DATA_NS),
        $rule = $(this).closest('.qb-rule'),
        qbr = $rule.data(QB_DATA_NS_RULE);
      qbr.setKey($(this).val());
    }
  );
  $(document).on(
    'change', '.qb-rule .qb-comparator', function ()
    {
      var $container = $(this).closest('.qb-container'),
        qb = $container.data(QB_DATA_NS),
        $rule = $(this).closest('.qb-rule'),
        qbr = $rule.data(QB_DATA_NS_RULE);
      qbr.setComparator($(this).val());
    }
  );
  /*$(document).on(
   'change', '.qb-container .qb-value', function ()
   {
   var $container = $(this).closest('.qb-container'),
   qb = $container.data(QB_DATA_NS),
   $rule = $(this).closest('.qb-rule'),
   qbr = $rule.data(QB_DATA_NS_RULE);
   qbr.setValue($(this).val());
   }
   );*/
  $(document).on(
    'click', 'button.qb-remove-rule', function ()
    {
      var $container = $(this).closest('.qb-container'),
        qb = $container.data(QB_DATA_NS),
        $rule = $(this).closest('.qb-rule'),
        qbr = $rule.data(QB_DATA_NS_RULE);
      qb.removeRule(qbr);
    }
  );
  $(document).on(
    'click', 'button.qb-add-rule', function ()
    {
      $(this).closest('.qb-container').QueryBuilder('addRule');
    }
  );

  /**
   * @constructor
   */
  function QueryBuilderDefinition(data)
  {
    this.key = '';
    this.displayName = '- SELECT -';
    this.dataType = QueryBuilderConstants.DATATYPE_STRING;
    this.comparators = [QueryBuilderConstants.COMPARATOR_EQUALS];
    this.inputType = null;
    this.required = false;
    this.unique = false;
    this.values = null;
    this.valuesUrl = '';
    this.strictValues = true;
    this.count = 0;

    var self = this;
    if(data)
    {
      $.each(
        data,
        function (k, v)
        {
          if(self.hasOwnProperty(k))
          {
            self[k] = v;
          }
        }
      );
    }
    if(this.values && this.values instanceof Array)
    {
      // convert array to object
      var newValues = {};
      $(this.values).each(
        function (idx)
        {
          if(self.dataType == QueryBuilderConstants.DATATYPE_NUMBER
            || self.dataType == QueryBuilderConstants.DATATYPE_BOOL)
          {
            newValues[idx] = self.values[idx];
          }
          else
          {
            newValues[self.values[idx]] = self.values[idx];
          }
        }
      );
      this.values = newValues;
    }
  }

  (function ()
  {
    QueryBuilderDefinition.prototype.hasValues = function ()
    {
      return !!this.values;
    };
    QueryBuilderDefinition.prototype.hasAjaxValues = function ()
    {
      return !!this.valuesUrl;
    };
    QueryBuilderDefinition.prototype.isStrict = function ()
    {
      return !!this.strictValues;
    };
  })();

  /**
   * @param queryBuilder
   * @param key
   * @param comparator
   * @param value
   * @constructor
   */
  function QueryBuilderRule(queryBuilder, key, comparator, value)
  {
    this._queryBuilder = queryBuilder;
    this._key = key || '';
    this._comparator = comparator || '';

    // normalise value to remove invalid values if array
    if(value instanceof Object)
    {
      value = $.grep(value, function (n) { return (!!n); });
      if(value.length)
      {
        var definition = this.getDefinition();
        if(definition && definition.values)
        {
          value = $.grep(
            value, function (n) { return definition.values.hasOwnProperty(n); }
          );
        }
      }
    }

    this._value = value !== null ? value : null;
    this._valCache = {};
    this._valCache[this._comparator] = this._value;
    this._element = null;
  }

  (function ()
  {
    QueryBuilderRule.prototype.constructor = QueryBuilderRule;

    /**
     * Get an input for a specified rule/definition
     *
     * @returns {jQuery}
     * @private
     */
    function getInput()
    {
      var
        inputType = this._queryBuilder.getInputTypeForRule(this),
        inputTypeFn = this._queryBuilder.getInputMethod(inputType);

      if(!inputTypeFn)
      {
        throw 'Input type not found for ' + this.getComparator() + ' ' + this.getDefinition().dataType;
      }
      return new inputTypeFn(this);
    } // getInput

    QueryBuilderRule.prototype.getValue = function ()
    {
      return this._value;
    };

    QueryBuilderRule.prototype.setValue = function (value)
    {
      this._setValue(value);
      this.render();
      $(this._queryBuilder._ele).trigger(
        'change.querybuilder', [this._queryBuilder.rules()]
      );
    };

    QueryBuilderRule.prototype._setValue = function (value)
    {
      this._value = value;
      $(this._queryBuilder._ele).trigger(
        'change.querybuilder', [this._queryBuilder.rules()]
      );
    };

    QueryBuilderRule.prototype.getComparator = function ()
    {
      return this._comparator;
    };

    QueryBuilderRule.prototype.setComparator = function (value)
    {
      this._valCache[this._comparator] = this.getValue();
      this._comparator = value;
      if(this._element && $('.qb-comparator', this._element).length)
      {
        $('.qb-comparator', this._element).val(value);
      }
      if(this._valCache[this._comparator])
      {
        this.setValue(this._valCache[this._comparator]);
      }
      else
      {
        this.setValue(null);
      }
    };

    QueryBuilderRule.prototype.getKey = function ()
    {
      return this._key;
    };

    QueryBuilderRule.prototype.setKey = function (value)
    {
      this._queryBuilder.changeCount(this._key, value);
      this._key = value;
      if(this._element)
      {
        $('.qb-key', this._element).val(value);
      }

      // if comparator doesnt exist
      var comparators = this.getDefinition().comparators;
      if(comparators.indexOf(this.getComparator()) == -1)
      {
        this.setComparator(comparators[0]);
      }
      else
      {
        this.setValue(null);
      }
    };

    QueryBuilderRule.prototype.render = function ()
    {
      var self = this,
        $row = $('<div class="qb-rule"/>'),
        $propertySel = $('<select class="qb-key"/>'),
        ruleKey = this.getKey();

      $row.data(QB_DATA_NS_RULE, this);

      $row.append($propertySel);
      /**
       * @type {QueryBuilderDefinition|null}
       */
      var definition = this.getDefinition();
      if(!ruleKey)
      {
        $propertySel.append(
          '<option selected="selected" value="">- SELECT -</option>'
        );
      }
      if(ruleKey && !definition)
      {
        // no definition for ruleKey
        $propertySel.append(
          '<option selected="selected" value="' + ruleKey + '">' + ruleKey + '</option>'
        );
      }
      $.each(
        this._queryBuilder.definitions(), function (idx, def)
        {
          var $option = $(
            '<option value="' + def.key + '">' + this.displayName + '</option>'
          );
          if(ruleKey == def.key)
          {
            $option.attr('selected', 'selected');
          }
          if(def.unique)
          {
            $option.addClass('unique-' + def.key);
            if(self._queryBuilder.getCount(def.key))
            {
              $option.attr('disabled', 'disabled');
            }
          }
          $propertySel.append($option);
        }
      );

      if(definition)
      {
        if(definition && definition.required && definition.count <= 1)
        {
          $propertySel.attr('disabled', 'disabled');
        }
        if(definition && !definition.dataType)
        {
          definition.dataType = 'string';
        }
        if(definition && !definition['comparators'])
        {
          definition['comparators'] = ['eq'];
        }
        var $comparatorSel = $('<select class="qb-comparator"/>');
        if(definition.dataType != QueryBuilderConstants.DATATYPE_BOOL)
        {
          $row.append($comparatorSel);
        }
        $.each(
          definition ? definition['comparators'] : [QueryBuilderConstants.COMPARATOR_EQUALS],
          function (idx, ident)
          {
            var selected = (self.getComparator() == ident) ? ' selected="selected"' : '';
            $comparatorSel.append(
              '<option' + selected + ' value="' + ident + '">'
              + self._queryBuilder.getComparatorName(ident)
              + '</option>'
            );
          }
        );
        var valueObject = getInput.call(this),
          $value = valueObject.render();
        if((this.getValue() === null)
          && $value.is('select') && ($('option[selected]', $value).length == 0))
        {
          this.setValue(
            $('option', $value).first()
                               .attr('selected', 'selected')
                               .attr('value')
          );
        }
        $row.append($value);
        if(valueObject['postRender'])
        {
          valueObject.postRender();
        }
      }

      var $removeButton = $(
        '<button class="qb-button qb-remove-rule">x</button>'
      );
      $row.append($removeButton);
      if(definition && definition.required && definition.count <= 1)
      {
        $removeButton.hide();
      }

      if(!definition && this.getKey())
      {
        $propertySel.attr('disabled', 'disabled');
        $comparatorSel.attr('disabled', 'disabled');
        $value.attr('disabled', 'disabled');
      }

      if(this._element)
      {
        this._element.replaceWith($row);
        this._element = $row;
        $(this._queryBuilder._ele).trigger('render.querybuilder', this);
      }
      else
      {
        this._element = $row;
      }
      return $row;
    };

    QueryBuilderRule.prototype.getDefinition = function ()
    {
      return this._queryBuilder.getDefinition(this.getKey());
    };

    QueryBuilderRule.prototype.getData = function ()
    {
      return {
        'key':        this.getKey(),
        'comparator': this.getComparator(),
        'value':      this.getValue()
      }
    };

    QueryBuilderRule.prototype.removeElement = function ()
    {
      if(this._element)
      {
        this._element.remove();
      }
    };

    QueryBuilderRule.prototype.getElement = function ()
    {
      return this._element;
    };
  })();

  /**
   * @param ele
   * @constructor
   *
   * @private {Object.<String, String>} _options
   * @private {QueryBuilderDefinition[]} _definitions
   * @private {QueryBuilderRule[]} _rules
   */
  function QueryBuilder(ele)
  {
    this._ele = ele;
    this._options = {};
    this._definitions = [];
    this._rules = [new QueryBuilderRule(this, '', '', null)];
    this._initialisedRules = false;
    this._initialisedDefinitions = false;

    this._inputTypeProcessors = [];
    this._inputMethods = {};
    this._comparatorNames = {};
    this.setInputMethod(
      QueryBuilderConstants.INPUT_TEXT, QueryBuilderTextInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_NUMBER, QueryBuilderNumberInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_DECIMAL, QueryBuilderDecimalInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_SELECT, QueryBuilderSelectInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_DATE, QueryBuilderDateInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_BOOL, QueryBuilderBooleanInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_AGE, QueryBuilderAgeInput
    );
    this.setInputMethod(
      QueryBuilderConstants.INPUT_BETWEEN, QueryBuilderBetweenInput
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_EQUALS, 'Equals');
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_EQUALS_INSENSITIVE,
      'Equals (insensitive)'
    );
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_NOT_EQUALS_INSENSITIVE,
      'Does Not Equal (insensitive)'
    );
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_NOT_EQUAL, 'Does Not Equal'
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_IN, 'In');
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_NOT_IN, 'Not In');
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_GREATER, 'Greater Than'
    );
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_GREATER_EQUAL, 'Greater Than or Equal to'
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_LESS, 'Less Than');
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_LESS_EQUAL, 'Less Than or Equal to'
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_BETWEEN, 'Between');
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_NOT_BETWEEN, 'Not Between'
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_LIKE, 'Like');
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_NOT_LIKE, 'Not Like'
    );
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_STARTS, 'Starts With'
    );
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_NOT_STARTS, 'Does Not Start With'
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_ENDS, 'Ends With');
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_NOT_ENDS, 'Does Not End With'
    );
    this.setComparatorName(
      QueryBuilderConstants.COMPARATOR_BEFORE, 'Was Before'
    );
    this.setComparatorName(QueryBuilderConstants.COMPARATOR_AFTER, 'Was After');

    this.addInputTypeProcessor(
      function (comparator, dataType)
      {
        if(dataType == QueryBuilderConstants.DATATYPE_NUMBER)
        {
          return QueryBuilderConstants.INPUT_NUMBER;
        }
        else if(dataType == QueryBuilderConstants.DATATYPE_DECIMAL)
        {
          return QueryBuilderConstants.INPUT_DECIMAL;
        }
      }
    );
    this.addInputTypeProcessor(
      function (comparator, dataType)
      {
        if(dataType == QueryBuilderConstants.DATATYPE_BOOL)
        {
          return QueryBuilderConstants.INPUT_BOOL;
        }
      }
    );
    this.addInputTypeProcessor(
      function (comparator, dataType)
      {
        if(dataType == QueryBuilderConstants.DATATYPE_DATE)
        {
          return QueryBuilderConstants.INPUT_DATE;
        }
      }
    );
    this.addInputTypeProcessor(
      function (comparator, dataType)
      {
        if(comparator == QueryBuilderConstants.COMPARATOR_BETWEEN
          || comparator == QueryBuilderConstants.COMPARATOR_NOT_BETWEEN)
        {
          return QueryBuilderConstants.INPUT_BETWEEN;
        }
      }
    );
    this.addInputTypeProcessor(
      function (comparator, dataType)
      {
        if(comparator == QueryBuilderConstants.COMPARATOR_BEFORE
          || comparator == QueryBuilderConstants.COMPARATOR_AFTER)
        {
          return QueryBuilderConstants.INPUT_AGE;
        }
      }
    );
    this.addInputTypeProcessor(
      function (comparator, dataType, rule)
      {
        var definition = rule.getDefinition();
        if(definition && definition.hasValues() && definition.isStrict())
        {
          return QueryBuilderConstants.INPUT_SELECT;
        }
      }
    );
  }

  (function ()
  {
    QueryBuilder.prototype.constructor = QueryBuilder;

    QueryBuilder.prototype.setInputMethod = function (ident, fn)
    {
      this._inputMethods[ident] = fn;
    };

    QueryBuilder.prototype.getInputMethod = function (ident)
    {
      return this._inputMethods[ident];
    };

    QueryBuilder.prototype.setComparatorName = function (comparator, text)
    {
      this._comparatorNames[comparator] = text;
    };

    QueryBuilder.prototype.getComparatorName = function (comparator)
    {
      if(this._comparatorNames[comparator])
      {
        return this._comparatorNames[comparator];
      }
      return comparator;
    };

    QueryBuilder.prototype.addInputTypeProcessor = function (fn)
    {
      this._inputTypeProcessors.push(fn);
    };

    QueryBuilder.prototype.getInputTypeForRule = function (rule)
    {
      var definition = rule.getDefinition();
      if(definition && definition.inputType)
      {
        return definition.inputType;
      }
      var dataType = definition && definition.dataType ? definition.dataType : QueryBuilderConstants.DATATYPE_STRING;

      var inputType = QueryBuilderConstants.INPUT_TEXT;
      $(this._inputTypeProcessors).each(
        function ()
        {
          inputType = this(rule.getComparator(), dataType, rule) || inputType;
        }
      );
      return inputType;
    };

    /**
     * Initialise with options - also the default command
     *
     * @param {Object} options
     */
    QueryBuilder.prototype.init = function (options)
    {
      var $ele = $(this._ele);
      $ele.addClass('qb-container')
          .html($('<div class="qb-rules"/>'))
          .append($('<button class="qb-button qb-add-rule">+</button>'));

      $ele.trigger('init.querybuilder', this);

      options = $.extend({}, $ele.data(), options);
      this.options(options);
      if(this._options && 'definitions' in this._options && this._options.definitions)
      {
        this.definitions(this._options.definitions);
      }
      if(this._options && 'rules' in this._options && this._options.rules)
      {
        this.rules(this._options.rules);
      }
    }; // init

    /**
     * Set/Get options
     *
     * @param data
     * @returns {*}
     */
    QueryBuilder.prototype.options = function (data)
    {
      if(data === undefined)
      {
        return this._options;
      }
      this._options = data;
      this.redraw();
    }; // options

    /**
     * Set/Get definitions
     *
     * @param data
     * @returns {*}
     */
    QueryBuilder.prototype.definitions = function (data)
    {
      var self = this;
      if(data === undefined)
      {
        return this._definitions;
      }

      this._initialisedDefinitions = false;

      if(typeof data === 'string')
      {
        $.getJSON(
          data, {}, function (defs)
          {
            self._definitions = [];
            $.each(
              defs, function ()
              {
                self._definitions.push(new QueryBuilderDefinition(this));
              }
            );
            self._initialisedDefinitions = true;
            self.redraw();
          }
        );
      }
      else
      {
        this._definitions = [];
        $.each(
          data, function ()
          {
            self._definitions.push(new QueryBuilderDefinition(this));
          }
        );
        self._initialisedDefinitions = true;
        this.redraw();
      }
    }; // definitions

    QueryBuilder.prototype.getDefinition = function (key)
    {
      var def = null;
      $.each(
        this._definitions, function ()
        {
          if(this.key == key)
          {
            def = this;
            return false;
          }
        }
      );
      return def;
    };

    /**
     * Set/Get rules
     * Set triggers redraw
     *
     * @param data
     * @returns {Array}
     */
    QueryBuilder.prototype.rules = function (data)
    {
      var self = this;
      if(data === undefined)
      {
        // no data - return object of all rules
        var currentData = [];
        $(this._rules).each(
          function ()
          {
            if(this.getKey())
            {
              currentData.push(this.getData());
            }
          }
        );
        return currentData;
      }

      this._initialisedRules = false;

      // if data is object, read it into rules
      if(typeof data === 'object')
      {
        processRules.call(this, data);
        return null;
      }
      else if(typeof data === 'function')
      {
        processRules.call(this, data());
        return null;
      }
      else if(typeof data === 'string')
      {
        $.getJSON(
          data, {}, function (rules)
          {
            processRules.call(self, rules);
          }
        );
        return null;
      }
      throw 'Unknown data format for rules';
    }; // rules

    /**
     * @param {String} key
     * @param {String} comparator
     * @param {String} value
     * @returns {QueryBuilderRule}
     */
    QueryBuilder.prototype.addRule = function (key, comparator, value)
    {
      this.incrementCounter(key);
      var rule = new QueryBuilderRule(this, key, comparator, value);
      if((!key) || rule.getDefinition())
      {
        this._rules.push(rule);
        if(this._initialisedDefinitions)
        {
          var $ele = rule.render();
          $('.qb-rules', this._ele).append($ele);
          $(this._ele).trigger('render.querybuilder', rule);
        }
      }
    };

    /**
     * Redraw the container
     */
    QueryBuilder.prototype.redraw = function ()
    {
      if(!(this._initialisedDefinitions))
      {
        return;
      }

      var self = this;
      $('.qb-rules', this._ele).empty();

      $.each(
        this._rules, function ()
        {
          var $ele = this.render();
          $('.qb-rules', self._ele).append($ele);
          $(self._ele).trigger('render.querybuilder', this);
        }
      );

      if(self._definitions)
      {
        // add any required fields which are not already added
        $.each(
          self._definitions, function ()
          {
            if(this.required)
            {
              var def = this, found = false;
              $.each(
                self._rules, function ()
                {
                  if(this.getKey() == def.key)
                  {
                    found = true;
                  }
                }
              );
              if(!found)
              {
                self.addRule(def.key, def.comparators[0], null);
              }
            }
          }
        );

        if(this._definitions.length)
        {
          var count = 0;
          $.each(
            this._definitions, function ()
            {
              if(!this.unique)
              {
                count++;
              }
            }
          );
          if(!count)
          {
            $('.qb-add-rule').hide();
          }
        }
      }
      if(this._initialisedRules)
      {
        $(self._ele).trigger('change.querybuilder', [self.rules()]);
      }
    }; // redraw

    QueryBuilder.prototype.removeRule = function (rule, noEmptyRule)
    {
      var self = this, key = rule.getKey();
      this.decrementCounter(key);
      rule.removeElement();
      $.each(
        this._rules, function (idx)
        {
          if(this == rule)
          {
            self._rules.splice(idx, 1);
          }
        }
      );
      if((!$('.qb-rule', this._ele).length) && (!noEmptyRule))
      {
        this.addRule('', '', null);
      }
      $(this._ele).trigger('change.querybuilder', [this.rules()]);
    }; // removeRule

    QueryBuilder.prototype.getCount = function (key)
    {
      var def = this.getDefinition(key);
      if(def)
      {
        return def.count;
      }
      return 0;
    };

    QueryBuilder.prototype.changeCount = function (oldKey, newKey)
    {
      this.decrementCounter(oldKey);
      this.incrementCounter(newKey);
    };

    QueryBuilder.prototype.incrementCounter = function (key)
    {
      var def = this.getDefinition(key);
      if(def)
      {
        def.count++;
        if(def.unique)
        {
          $('.qb-key .unique-' + key, this._ele).attr('disabled', 'disabled');
        }
        if(def.required && def.count > 1)
        {
          $.each(
            this._rules, function ()
            {
              if(this.getKey() == key)
              {
                $('.qb-remove-rule', this.getElement()).show();
                $('.qb-key', this.getElement()).attr('disabled', false);
              }
            }
          );
        }
      }
    };

    QueryBuilder.prototype.decrementCounter = function (key)
    {
      var def = this.getDefinition(key);
      if(def)
      {
        def.count--;
        if(def.unique && def.count == 0)
        {
          // allow this on all again
          $('.qb-key .unique-' + key, this._ele).attr('disabled', null);
        }
        if(def.required && def.count == 1)
        {
          // remove the delete button
          $.each(
            this._rules, function ()
            {
              if(this.getKey() == key)
              {
                $('.qb-remove-rule', this.getElement()).hide();
              }
            }
          );
        }
      }
    };

    function processRules(data)
    {
      if(this._definitions.length > 0)
      {
        _processRules.call(this, data);
      }
      else
      {
        var self = this,
          intervalId = setInterval(
            function ()
            {
              if(self._definitions.length > 0)
              {
                _processRules.call(self, data);
                clearInterval(intervalId);
              }
            }, 100
          );
      }
    }

    function _processRules(data)
    {
      var self = this;

      while(this._rules.length)
      {
        self.removeRule(this._rules[0], true);
      }

      if(data)
      {
        $.each(
          data, function (key)
          {
            var definition = self.getDefinition(key),
              defaultComparator = definition ? definition.comparators[0] : 'eq';
            if(typeof this == 'object')
            {
              if(this instanceof String)
              {
                self.addRule(key, defaultComparator, this);
              }
              else if('key' in this && 'comparator' in this && 'value' in this)
              {
                self.addRule(this.key, this.comparator, this.value)
              }
              else if(this.length == 1)
              {
                self.addRule(key, defaultComparator, this[0]);
              }
              else
              {
                self.addRule(key, 'in', this);
              }
            }
            else
            {
              self.addRule(key, defaultComparator, this);
            }
          }
        );
        self._initialisedRules = true;
        this.redraw();
        if(!self._rules.length)
        {
          self.addRule('', '', null);
        }
      }
    }
  })();

  function drawSelect(options, value)
  {
    var $select = $('<select/>');
    if(value && Object.keys(options).indexOf(value) == -1)
    {
      var $option = $('<option/>').text(value).attr('value', value);
      $option.attr('selected', 'selected');
      $option.attr('disabled', 'disabled');
      $select.append($option);
    }
    $.each(
      options, function (idx)
      {
        var $option = $('<option/>').text(this).attr('value', idx);
        if(idx == value)
        {
          $option.attr('selected', 'selected');
        }
        $select.append($option);
      }
    );
    return $select;
  } // drawSelect

  var QueryBuilderTextInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = '';
      }
    }

    Constructor.prototype.render = function ()
    {
      var self = this;
      return $('<input type="text"/>').attr('value', this._rule._value).on(
        'change', function ()
        {
          self._rule._setValue($(this).val());
        }
      );
    };

    return Constructor;
  })();

  var QueryBuilderBooleanInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = '1';
      }
    }

    Constructor.prototype.render = function ()
    {
      var self = this;
      return drawSelect(
        {'1': 'True', '0': 'False'}, this._rule._value
      ).on(
        'change', function ()
        {
          self._rule._setValue($(this).val());
        }
      );
    };

    return Constructor;
  })();

  var QueryBuilderSelectInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = null;
      }
    }

    Constructor.prototype.render = function ()
    {
      var self = this;
      return drawSelect(
        this._rule.getDefinition().values, this._rule._value
      ).on(
        'change', function ()
        {
          self._rule._setValue($(this).val());
        }
      );
    };

    return Constructor;
  })();

  var QueryBuilderDecimalInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = 0;
      }
    }

    Constructor.prototype.render = function ()
    {
      var self = this;
      return $('<input type="number" step="0.01" />')
        .attr('value', this._rule._value)
        .on(
          'change', function ()
          {
            self._rule._setValue($(this).val());
          }
        );
    };

    return Constructor;
  })();

  var QueryBuilderNumberInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = 0;
      }
    }

    Constructor.prototype.render = function ()
    {
      var self = this;
      return $('<input type="number" />')
        .attr(
          'value', this._rule._value
        )
        .on(
          'change', function ()
          {
            self._rule._setValue($(this).val());
          }
        );
    };

    return Constructor;
  })();

  var QueryBuilderDateInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = getToday();
      }
    }

    function getToday()
    {
      var d = new Date();
      var today = d.getFullYear();
      today += '-' + ("0" + (d.getMonth() + 1)).slice(-2);
      today += '-' + ("0" + d.getDate()).slice(-2);
      return today;
    }

    Constructor.prototype.render = function ()
    {
      var self = this;
      return $('<input type="date" />')
        .val(this._rule._value)
        .on(
          'change', function ()
          {
            self._rule._setValue($(this).val());
          }
        );
    };

    return Constructor;
  })();

  var QueryBuilderAgeInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        this._rule._value = -10080;
      }
    }

    Constructor.prototype.render = function ()
    {
      var self = this,
        value = this._rule._value,
        unit = 1,
        $count = $('<input class="age-count" type="number" />'),
        $unit = $('<select class="age-unit"/>'),
        $negate = $('<select class="age-unit"></select>');

      var units = {
        'Minutes': 1,
        'Hours':   60,
        'Days':    1440,
        'Weeks':   10080
      };
      var sortedUnits = [];
      for(var u in units)
      {
        if(units.hasOwnProperty(u))
        {
          sortedUnits.push([u, units[u]])
        }
      }
      sortedUnits.sort(function (a, b) {return a[1] - b[1]});

      // find unit and mutate value
      $.each(
        sortedUnits.slice().reverse(), function (idx, v)
        {
          if(value % v[1] == 0)
          {
            unit = v[1];
            value = value / v[1];
            return false;
          }
        }
      );

      $.each(
        sortedUnits, function (idx, v)
        {
          var $option = $('<option>').val(v[1]).text(v[0]);
          if(unit == v[1])
          {
            $option.attr('selected', true);
          }
          $unit.append($option);
        }
      );

      $count.val(Math.abs(value));
      var $ago = $('<option value="-1">Ago</option>'),
        $fromNow = $('<option value="1">From now</option>');
      if(this._rule._value <= 0)
      {
        $ago.attr('selected', true);
      }
      else
      {
        $fromNow.attr('selected', true);
      }
      $negate.append($ago, $fromNow);

      // create event to set the value
      var $return = $().add($count).add($unit).add($negate);
      $return.on(
        'change', function ()
        {
          self._rule._setValue($count.val() * $unit.val() * $negate.val());
        }
      );
      return $return;
    };

    return Constructor;
  })();

  var QueryBuilderBetweenInput = (function ()
  {
    function Constructor(rule)
    {
      this._rule = rule;
      if(this._rule._value === null)
      {
        if(this._rule.getDefinition().dataType == QueryBuilderConstants.DATATYPE_DATE)
        {
          this._rule._value = getToday() + ',' + getToday();
        }
        else
        {
          this._rule._value = '0,0';
        }
      }
    }

    function getToday()
    {
      var d = new Date();
      var today = d.getFullYear();
      today += '-' + ("0" + (d.getMonth() + 1)).slice(-2);
      today += '-' + ("0" + d.getDate()).slice(-2);
      return today;
    }

    Constructor.prototype.render = function ()
    {
      var self = this,
        values = this._rule._value.split(','),
        $min = $('<input class="qb-between-min">'),
        $max = $('<input class="qb-between-max">');

      switch(this._rule.getDefinition().dataType)
      {
        case QueryBuilderConstants.DATATYPE_DECIMAL:
          $min.attr('type', 'number').attr('step', '0.01').val(values[0]);
          $max.attr('type', 'number').attr('step', '0.01').val(values[1]);
          break;
        case QueryBuilderConstants.DATATYPE_NUMBER:
          $min.attr('type', 'number').val(values[0]);
          $max.attr('type', 'number').val(values[1]);
          break;
        case QueryBuilderConstants.DATATYPE_DATE:
          $min.attr('type', 'date').val(values[0]);
          $max.attr('type', 'date').val(values[1]);
          break;
        default:
          $min.attr('type', 'text').val(values[0]);
          $max.attr('type', 'text').val(values[1]);
          break;
      }

      // create event to set the value
      var $return = $().add($min).add($max);
      $return.on(
        'change', function ()
        {
          self._rule._setValue($min.val() + ',' + $max.val());
        }
      );
      return $return;
    };

    return Constructor;
  })();

}(jQuery, window, document));
