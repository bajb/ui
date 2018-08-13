/* global window, document, jQuery */

(function (window, document, $, undefined) {

  var DATA_NS = 'jq.dropdown';
  var dropdowns = [];

  /**
   * loop over all dropdowns, close any which are not in the target
   */
  function _closeAll(sender) {
    $(dropdowns).each(function () {
      if(this.isOpen())
      {
        var canClose = true;
        if(sender)
        {
          var tree = $(sender).parents().addBack();
          canClose = isConnected(sender)
            && (tree.index(this._action) === -1)
            && (tree.index(this._content) === -1);
        }
        if(canClose)
        {
          this.close();
        }
      }
    });
  }

  function _toggleEvent(e) {
    if($(e.target).parents().addBack().index(this._content) === -1)
    {
      this.toggle();
    }
  }

  $(document).on('click', function (e) {
    _closeAll(e.target);
  });

  $(window).on('resize', function () {
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
      _closeAll();
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

      // iterate parents to find scrollbar offset :  += offsetWidth - clientWidth
      var scrollOffset = 0;
      var p = $parent.get(0);
      do
      {
        if(p.clientWidth > 0)
        {
          scrollOffset += p.offsetWidth - p.clientWidth;
        }
      }
      while(p = p.parentElement);
      scrollOffset += this._options.margin;

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

      if(offsetRight > document.body.clientWidth - scrollOffset)
      {
        css.left = Math.max(
          document.body.clientWidth - offsetRight - scrollOffset,
          ($content.offset().left - scrollOffset) * -1
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
        .on('click', _toggleEvent.bind(this));
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
