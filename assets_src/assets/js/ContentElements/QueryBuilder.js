/*
 * Query Builder
 */

(function ($)
{
  'use strict';

  const QB_DATA_NS = 'querybuilder';
  const QB_DATA_NS_RULE = QB_DATA_NS + '.rule';

  const INPUT_TEXT = 'text';
  const INPUT_NUMBER = 'number';
  const INPUT_DECIMAL = 'decimal';
  const INPUT_SELECT = 'select';
  const INPUT_TOKEN = 'token';
  const INPUT_DATE = 'date';
  const INPUT_BOOL = 'bool';
  const INPUT_AGE = 'age';

  const DATATYPE_STRING = 'string';
  const DATATYPE_NUMBER = 'number';
  const DATATYPE_DECIMAL = 'decimal';
  const DATATYPE_DATE = 'date';
  const DATATYPE_BOOL = 'bool';

  const COMPARATOR_EQUALS = 'eq';
  const COMPARATOR_EQUALS_INSENSITIVE = 'eqi';
  const COMPARATOR_NOT_EQUAL = 'neq';
  const COMPARATOR_IN = 'in';
  const COMPARATOR_NOT_IN = 'nin';
  const COMPARATOR_GREATER = 'gt';
  const COMPARATOR_GREATER_EQUAL = 'gte';
  const COMPARATOR_LESS = 'lt';
  const COMPARATOR_LESS_EQUAL = 'lte';
  const COMPARATOR_BETWEEN = 'bet';
  const COMPARATOR_AGE = 'age';
  const COMPARATOR_LIKE = 'like';
  const COMPARATOR_STARTS = 'starts';
  const COMPARATOR_ENDS = 'ends';

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
      throw 'QueryBuilder command \'' + command + '\' not found';
    }
    args.shift();
    var retVal = $(this);
    $(this).each(
      function ()
      {
        var $this = $(this), instance = $this.data(QB_DATA_NS);
        if (!instance)
        {
          $this.data(QB_DATA_NS, new QueryBuilder(this));
          instance = $this.data(QB_DATA_NS);
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
      var $container = $(this).closest('.qb-container'),
        qb = $container.data(QB_DATA_NS),
        $rule = $(this).closest('.qb-rule'),
        qbr = $rule.data(QB_DATA_NS_RULE);
      qbr.setKey($(this).val());
      qbr.render();
      $container.trigger('change.querybuilder', [qb.rules()]);
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
      qbr.render();
      $container.trigger('change.querybuilder', [qb.rules()]);
    }
  );
  $(document).on(
    'change', '.qb-container .qb-value', function ()
    {
      var $container = $(this).closest('.qb-container'),
        qb = $container.data(QB_DATA_NS),
        $rule = $(this).closest('.qb-rule'),
        qbr = $rule.data(QB_DATA_NS_RULE);
      qbr.setValue($(this).val());
      $container.trigger('change.querybuilder', [qb.rules()]);
    }
  );
  $(document).on(
    'click', 'button.qb-remove-rule', function ()
    {
      var $container = $(this).closest('.qb-container'),
        qb = $container.data(QB_DATA_NS),
        $rule = $(this).closest('.qb-rule'),
        qbr = $rule.data(QB_DATA_NS_RULE);
      qb.removeRule(qbr);
      $container.trigger('change.querybuilder', [qb.rules()]);
    }
  );
  $(document).on(
    'click', 'button.qb-add-rule', function ()
    {
      $(this).closest('.qb-container').QueryBuilder('addRule');
    }
  );

  /**
   * @property {String} key
   * @property {String} display
   * @property {String[]} comparators
   * @property {String} values
   * @property {String} ajaxUrl
   * @property {String} dataType
   * @property {String} inputType
   * @property {Boolean} required
   * @property {Boolean} unique
   * @property {Number} count
   * @constructor
   */
  var QueryBuilderDefinition = function (data)
  {
    this.key = '';
    this.display = '- SELECT -';
    this.dataType = DATATYPE_STRING;
    this.comparators = [COMPARATOR_EQUALS];
    this.inputType = null;
    this.required = false;
    this.unique = false;
    this.values = '';
    this.ajaxUrl = '';
    this.count = 0;

    if (data)
    {
      var self = this;
      $.each(
        data,
        function (k, v)
        {
          if (self.hasOwnProperty(k))
          {
            self[k] = v;
          }
        }
      );
    }
  };

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
    this._value = value || '';
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
      var $input,
        inputType = getInputType.call(this),
        inputTypeFn = this._queryBuilder.getInputMethod(inputType);

      if (!inputTypeFn)
      {
        throw 'Input type not found for ' + this.getComparator() + ' ' + this.getDefinition().dataType;
      }
      $input = inputTypeFn.call(this);
      $input.addClass('qb-value');
      return $input;
    } // getInput

    function getInputType()
    {
      var definition = this.getDefinition(),
        qb = this._queryBuilder,
        inputType = definition && definition.inputType ? definition.inputType : null;
      if (!inputType)
      {
        var dataType = definition && definition.dataType ? definition.dataType : DATATYPE_STRING;
        inputType = qb.getInputType(this.getComparator(), dataType);
      }

      if (inputType == INPUT_TEXT && definition && definition.values && (!definition.ajaxUrl))
      {
        inputType = INPUT_SELECT;
      }
      return inputType;
    }

    QueryBuilderRule.prototype.getValue = function ()
    {
      if (this._element && $('.qb-value', this._element).length)
      {
        if ($('.qb-value', this._element).is('select'))
        {
          return $('.qb-value option:selected', this._element).attr('value');
        }
        else
        {
          return $('.qb-value', this._element).val();
        }
      }
      return this._value;
    };

    QueryBuilderRule.prototype.setValue = function (value)
    {
      this._value = value;
      if (this._element && $('.qb-value', this._element).length)
      {
        $('.qb-value', this._element).val(value);
      }
    };

    QueryBuilderRule.prototype.getComparator = function ()
    {
      if (this._element && $('.qb-comparator', this._element).length)
      {
        return $('.qb-comparator', this._element).val();
      }
      return this._comparator;
    };

    QueryBuilderRule.prototype.setComparator = function (value)
    {
      this._comparator = value;
      if (this._element && $('.qb-comparator', this._element).length)
      {
        $('.qb-comparator', this._element).val(value);
      }
    };

    QueryBuilderRule.prototype.getKey = function ()
    {
      if (this._element)
      {
        return $('.qb-key option:selected', this._element).attr('value');
      }
      return this._key;
    };

    QueryBuilderRule.prototype.setKey = function (value)
    {
      this._queryBuilder.changeCount(this._key, value);
      this._key = value;
      if (this._element)
      {
        $('.qb-key', this._element).val(value);
      }

      // if comparator doesnt exist
      var comparators = this.getDefinition().comparators;
      if (comparators.indexOf(this.getComparator()) == -1)
      {
        this.setComparator(comparators[0]);
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
      if (!ruleKey)
      {
        $propertySel.append(
          '<option selected="selected" value="">- SELECT -</option>'
        );
      }
      if (ruleKey && !definition)
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
            '<option value="' + def.key + '">' + this.display + '</option>'
          );
          if (ruleKey == def.key)
          {
            $option.attr('selected', 'selected');
          }
          if (def.unique)
          {
            $option.addClass('unique-' + def.key);
            if (self._queryBuilder.getCount(def.key))
            {
              $option.attr('disabled', 'disabled');
            }
          }
          $propertySel.append($option);
        }
      );

      if (definition)
      {
        if (definition && definition.required && definition.count <= 1)
        {
          $propertySel.attr('disabled', 'disabled');
        }
        if (definition && !definition.dataType)
        {
          definition.dataType = 'string';
        }
        if (definition && !definition['comparators'])
        {
          definition['comparators'] = ['eq'];
        }
        var $comparatorSel = $('<select class="qb-comparator"/>');
        $row.append($comparatorSel);
        $.each(
          definition ? definition['comparators'] : [COMPARATOR_EQUALS],
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
        var $value = getInput.call(this);
        $row.append($value);
      }

      var $removeButton = $(
        '<button class="qb-button qb-remove-rule">x</button>'
      );
      $row.append($removeButton);
      if (definition && definition.required && definition.count <= 1)
      {
        $removeButton.hide();
      }

      if (!definition && this.getKey())
      {
        $propertySel.attr('disabled', 'disabled');
        $comparatorSel.attr('disabled', 'disabled');
        $value.attr('disabled', 'disabled');
      }

      if (this._element)
      {
        this._element.replaceWith($row);
      }
      this._element = $row;
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
      if (this._element)
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
    this._rules = [];
    this._initialisedRules = false;
    this._initialisedDefinitions = false;

    this._inputMethods = {};
    this._inputTypes = {};
    this._comparatorNames = {};
    this.setInputMethod(INPUT_TEXT, textInput);
    this.setInputMethod(INPUT_NUMBER, numberInput);
    this.setInputMethod(INPUT_DECIMAL, decimalInput);
    this.setInputMethod(INPUT_SELECT, selectInput);
    this.setInputMethod(INPUT_TOKEN, tokenInput);
    this.setInputMethod(INPUT_DATE, dateInput);
    this.setInputMethod(INPUT_BOOL, boolInput);
    this.setInputMethod(INPUT_AGE, boolInput);
    this.setInputType(COMPARATOR_EQUALS, DATATYPE_STRING, INPUT_TEXT);
    this.setInputType(COMPARATOR_EQUALS, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_EQUALS, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_EQUALS, DATATYPE_BOOL, INPUT_BOOL);
    this.setInputType(
      COMPARATOR_EQUALS_INSENSITIVE, DATATYPE_STRING, INPUT_TEXT
    );
    this.setInputType(
      COMPARATOR_EQUALS_INSENSITIVE, DATATYPE_NUMBER, INPUT_NUMBER
    );
    this.setInputType(COMPARATOR_EQUALS_INSENSITIVE, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_EQUALS_INSENSITIVE, DATATYPE_BOOL, INPUT_BOOL);
    this.setInputType(COMPARATOR_NOT_EQUAL, DATATYPE_STRING, INPUT_TEXT);
    this.setInputType(COMPARATOR_NOT_EQUAL, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_NOT_EQUAL, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_NOT_EQUAL, DATATYPE_BOOL, INPUT_BOOL);
    this.setInputType(COMPARATOR_IN, DATATYPE_STRING, INPUT_TOKEN);
    this.setInputType(COMPARATOR_IN, DATATYPE_NUMBER, INPUT_TOKEN);
    this.setInputType(COMPARATOR_NOT_IN, DATATYPE_STRING, INPUT_TOKEN);
    this.setInputType(COMPARATOR_NOT_IN, DATATYPE_NUMBER, INPUT_TOKEN);
    this.setInputType(COMPARATOR_GREATER, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_GREATER, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_GREATER, DATATYPE_DECIMAL, INPUT_DECIMAL);
    this.setInputType(COMPARATOR_GREATER_EQUAL, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_GREATER_EQUAL, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(
      COMPARATOR_GREATER_EQUAL, DATATYPE_DECIMAL, INPUT_DECIMAL
    );
    this.setInputType(COMPARATOR_LESS, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_LESS, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_LESS, DATATYPE_DECIMAL, INPUT_DECIMAL);
    this.setInputType(COMPARATOR_LESS_EQUAL, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_LESS_EQUAL, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_LESS_EQUAL, DATATYPE_DECIMAL, INPUT_DECIMAL);
    this.setInputType(COMPARATOR_BETWEEN, DATATYPE_NUMBER, INPUT_NUMBER);
    this.setInputType(COMPARATOR_BETWEEN, DATATYPE_DATE, INPUT_DATE);
    this.setInputType(COMPARATOR_BETWEEN, DATATYPE_DECIMAL, INPUT_DECIMAL);
    this.setInputType(COMPARATOR_AGE, DATATYPE_DATE, INPUT_AGE);
    this.setInputType(COMPARATOR_LIKE, DATATYPE_STRING, INPUT_TEXT);
    this.setInputType(COMPARATOR_STARTS, DATATYPE_STRING, INPUT_TEXT);
    this.setInputType(COMPARATOR_ENDS, DATATYPE_STRING, INPUT_TEXT);
    this.setComparatorName(COMPARATOR_EQUALS, 'Equals');
    this.setComparatorName(
      COMPARATOR_EQUALS_INSENSITIVE, 'Equals (insensitive)'
    );
    this.setComparatorName(COMPARATOR_NOT_EQUAL, 'Does Not Equal');
    this.setComparatorName(COMPARATOR_IN, 'In');
    this.setComparatorName(COMPARATOR_NOT_IN, 'Not In');
    this.setComparatorName(COMPARATOR_GREATER, 'Greater Than');
    this.setComparatorName(
      COMPARATOR_GREATER_EQUAL, 'Greater Than or Equal to'
    );
    this.setComparatorName(COMPARATOR_LESS, 'Less Than');
    this.setComparatorName(COMPARATOR_LESS_EQUAL, 'Less Than or Equal to');
    this.setComparatorName(COMPARATOR_BETWEEN, 'Between');
    this.setComparatorName(COMPARATOR_AGE, 'was');
    this.setComparatorName(COMPARATOR_LIKE, 'Like');
    this.setComparatorName(COMPARATOR_STARTS, 'Starts With');
    this.setComparatorName(COMPARATOR_ENDS, 'Ends With');
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

    QueryBuilder.prototype.setInputType = function (comparator, dataType, ident)
    {
      if (!this._inputTypes[comparator])
      {
        this._inputTypes[comparator] = {};
      }
      this._inputTypes[comparator][dataType] = ident;
    };

    QueryBuilder.prototype.getInputType = function (comparator, dataType)
    {
      if (this._inputTypes[comparator] && this._inputTypes[comparator][dataType])
      {
        return this._inputTypes[comparator][dataType];
      }
      return this._inputTypes[COMPARATOR_EQUALS][DATATYPE_STRING];
    };

    QueryBuilder.prototype.setComparatorName = function (comparator, text)
    {
      this._comparatorNames[comparator] = text;
    };

    QueryBuilder.prototype.getComparatorName = function (comparator)
    {
      if (this._comparatorNames[comparator])
      {
        return this._comparatorNames[comparator];
      }
      return comparator;
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

      options = $.extend({}, $ele.data(), options);
      this.options(options);
      if (this._options && 'definitions' in this._options && this._options.definitions)
      {
        this.definitions(this._options.definitions);
      }
      if (this._options && 'rules' in this._options && this._options.rules)
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
      if (data === undefined)
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
      if (data === undefined)
      {
        return this._definitions;
      }

      this._initialisedDefinitions = false;

      if (typeof data === 'string')
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
          if (this.key == key)
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
      if (data === undefined)
      {
        // no data - return object of all rules
        var currentData = [];
        $(this._rules).each(
          function ()
          {
            if (this.getKey())
            {
              currentData.push(this.getData());
            }
          }
        );
        return currentData;
      }

      this._initialisedRules = false;

      $.each(
        this._rules, function ()
        {
          self.removeRule(this, true);
        }
      );

      // if data is object, read it into rules
      if (typeof data === 'object')
      {
        processRules.call(this, data);
        this._initialisedRules = true;
        this.redraw();
        return null;
      }
      else if (typeof data === 'function')
      {
        processRules.call(this, data());
        this._initialisedRules = true;
        this.redraw();
        return null;
      }
      else if (typeof data === 'string')
      {
        $.getJSON(
          data, {}, function (rules)
          {
            processRules.call(self, rules);
            self._initialisedRules = true;
            self.redraw();
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
      this._rules.push(rule);
      if (this._initialisedDefinitions && this._initialisedRules)
      {
        $('.qb-rules', this._ele).append(rule.render());
      }
    };

    /**
     * Redraw the container
     */
    QueryBuilder.prototype.redraw = function ()
    {
      if (!(this._initialisedDefinitions && this._initialisedRules))
      {
        return;
      }

      var self = this;
      $('.qb-rules', this._ele).empty();

      $.each(
        this._rules, function ()
        {
          var $rendered = this.render();
          $('.qb-rules', self._ele).append($rendered);
        }
      );

      if (self._definitions)
      {
        // add any required fields which are not already added
        $.each(
          self._definitions, function ()
          {
            if (this.required)
            {
              var def = this, found = false;
              $.each(
                self._rules, function ()
                {
                  if (this.getKey() == def.key)
                  {
                    found = true;
                  }
                }
              );
              if (!found)
              {
                self.addRule(def.key, def.comparators[0], '');
              }
            }
          }
        );

        // if no rules, add an empty one
        if (this._rules.length == 0)
        {
          this.addRule('', '', '');
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
          if (this == rule)
          {
            self._rules.splice(idx, 1);
          }
        }
      );
      if ((!$('.qb-rule', this._ele).length) && (!noEmptyRule))
      {
        this.addRule('', '', '');
      }
    }; // removeRule

    QueryBuilder.prototype.getCount = function (key)
    {
      var def = this.getDefinition(key);
      if (def)
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
      if (def)
      {
        def.count++;
        if (def.unique)
        {
          $('.qb-key .unique-' + key, this._ele).attr('disabled', 'disabled');
        }
        if (def.required && def.count > 1)
        {
          $.each(
            this._rules, function ()
            {
              if (this.getKey() == key)
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
      if (def)
      {
        def.count--;
        if (def.unique && def.count == 0)
        {
          // allow this on all again
          $('.qb-key .unique-' + key, this._ele).attr('disabled', null);
        }
        if (def.required && def.count == 1)
        {
          // remove the delete button
          $.each(
            this._rules, function ()
            {
              if (this.getKey() == key)
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
      var self = this;
      if (data)
      {
        $.each(
          data, function (key)
          {
            if (typeof this == 'object')
            {
              if (this instanceof String)
              {
                self.addRule(key, 'eq', this);
              }
              else
              {
                if ('key' in this && 'comparator' in this && 'value' in this)
                {
                  self.addRule(this.key, this.comparator, this.value)
                }
                else
                {
                  self.addRule(key, 'in', this);
                }
              }
            }
            else
            {
              self.addRule(key, 'eq', this);
            }
          }
        );
      }
    }
  })();

  /**
   * @returns {jQuery}
   */
  function textInput()
  {
    // if ajaxUrl this should be typeahed
    return $('<input type="text"/>').attr('value', this.getValue());
  }

  /**
   * @returns {jQuery}
   */
  function numberInput()
  {
    return $('<input type="number"/>').attr('value', this.getValue());
  }

  /**
   * @returns {jQuery}
   */
  function decimalInput()
  {
    return $('<input type="number" step="0.01" />')
      .attr('value', this.getValue());
  }

  /**
   * @returns {jQuery}
   */
  function boolInput()
  {
    return drawSelect({'1': 'True', '0': 'False'}, this.getValue());
  }

  /**
   *
   * @returns {jQuery}
   */
  function selectInput()
  {
    return drawSelect(this.getDefinition().values, this.getValue());
  }

  /**
   * @returns {jQuery}
   */
  function dateInput()
  {
    return $('<input type="date"/>').attr('value', this.getValue());
  }

  /**
   * @returns {jQuery}
   */
  function tokenInput()
  {
    return $('<input type="text"/>').attr('value', this.getValue());
  }

  function drawSelect(options, value)
  {
    var $select = $('<select/>');
    if (value && Object.keys(options).indexOf(value) == -1)
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
        if (idx == value)
        {
          $option.attr('selected', 'selected');
        }
        $select.append($option);
      }
    );
    if ($(':selected', $select).length == 0)
    {
      $('option', $select).first().attr('selected', 'selected');
    }
    return $select;
  } // drawSelect
})(jQuery);
