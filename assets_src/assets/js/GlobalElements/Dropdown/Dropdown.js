/* global window, document, jQuery */

(function (window, document, $, undefined) {

  var DATA_NS = 'jq.dropdown';
  var dropdowns = [];

  $(document).on('click', function (e) {
    // loop over all dropdowns, close any which are not in the target
    $(dropdowns).each(function () {
      var tree = $(e.target).parents().addBack();
      if(this.isOpen() && isConnected(e.target)
        && (tree.index(this._action) === -1)
        && (tree.index(this._content) === -1)
      )
      {
        this.close();
      }
    });
  });

  $(window).on('resize', function (e) {
    $(dropdowns).each(function () {
      this.reposition();
    });
  });

  function isConnected(ele) {
    return jQuery.contains(document, ele);
  }

  function Dropdown(ele) {
    this._ele = ele;
    this._options = {};
    this._action = null;
    this._content = null;
    this._isInitialised = false;
  }

  /**
   * @param {string} eventName
   * @param {CustomEventInit?} options
   * @returns {boolean}
   */
  Dropdown.prototype.triggerEvent = function (eventName, options) {
    eventName = eventName + '-dropdown';
    options = $.extend({cancelable: false, bubbles: true, detail: {dropdown: this}}, options);
    return this._action[0].dispatchEvent(new CustomEvent(eventName, options));
  };

  Dropdown.prototype.isOpen = function () {
    return this._content.is('.dropdown-open');
  };

  Dropdown.prototype.toggle = function () {
    this.isOpen() ? this.close() : this.open();
  };

  Dropdown.prototype.refreshContent = function () {
    var self = this;
    var $content = this._content;
    var xhr = new XMLHttpRequest();
    if(this.triggerEvent('content-request', {cancelable: true, detail: {xhr: xhr}}))
    {
      xhr.addEventListener('readystatechange', function () {
        if(xhr.readyState === XMLHttpRequest.DONE)
        {
          $content.html(xhr.response);
          self.reposition();
        }
      });
      xhr.open('GET', this._options.contentUrl);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.setRequestHeader('X-Fortifi-Req-With', 'ui.dropdown');
      xhr.send();
    }
  };

  Dropdown.prototype.close = function () {
    if(this.triggerEvent('close', {cancelable: true}))
    {
      this._content.appendTo(this._action).removeClass('dropdown-open');
      this.triggerEvent('closed');
    }
  };

  Dropdown.prototype.open = function () {
    if(this.triggerEvent('open', {cancelable: true}))
    {
      if(this._options.attachTo)
      {
        this._content.appendTo(this._options.attachTo)
      }
      this._content.addClass('dropdown-open');
      this.reposition();
      this.triggerEvent('opened');
    }
  };

  Dropdown.prototype.reposition = function () {
    if(this.isOpen())
    {
      var $action = this._action;
      var $content = this._content;
      var $parent = this._content.parent();
      $content.css({left: 0, top: 0});

      var offsetLeft = 0;
      var offsetTop = 0;
      if(!$parent.is($action))
      {
        offsetTop = $action.offset().top + document.body.scrollTop;
        offsetLeft = $action.offset().left;
      }

      var
        css = {},
        offsetRight = $content.offset().left + $content.outerWidth(true);

      if(offsetRight > document.body.clientWidth - this._options.margin)
      {
        css.left = Math.max(
          document.body.clientWidth - offsetRight - this._options.margin,
          ($content.offset().left - this._options.margin) * -1
        );
      }
      else
      {
        css.left = offsetLeft;
      }

      switch(this._options.position)
      {
        case 'top':
          css.top = offsetTop - $content.outerHeight(true);
          break;
        case 'bottom':
        default:
          css.top = offsetTop + $action.outerHeight(true);
          break;
      }

      $content.css(css);
    }
  };

  Dropdown.prototype.init = function (options) {
    if(!this._isInitialised)
    {
      var self = this;
      options = $.extend(
        {margin: 10, position: 'bottom', contentUrl: null, attachTo: null},
        $(this._ele).data(),
        options
      );

      this._options = options;

      this._action = $(this._ele)
        .addClass('dropdown-action')
        .on('click', this.toggle.bind(this));
      this._content = $('.dropdown-content', this._ele);
      if(!this._content.length)
      {
        this._content = $('<div />').addClass('dropdown-content').appendTo(this._action);
      }

      if(this._options.contentUrl)
      {
        this._action.on('mouseenter', function () {
          self.refreshContent();
          self._action.off('mouseenter');
        });
      }

      this._content.data(DATA_NS, this);

      dropdowns.push(this);

      this._isInitialised = true;
    }
  };

  $.fn.Dropdown = function (command, options) {
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
    if(typeof Dropdown.prototype[command] !== 'function')
    {
      throw 'Dropdown command \'' + command + '\' not found';
    }
    args.shift();
    var retVal = $(this);
    $(this).each(
      function () {
        var $this = $(this), instance = $this.data(DATA_NS);
        if(!instance)
        {
          $this.data(DATA_NS, new Dropdown(this));
          instance = $this.data(DATA_NS);
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

  document.dispatchEvent(new CustomEvent('ready-dropdown'));
}(window, document, jQuery));
