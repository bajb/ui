/* global window, document, jQuery */

(function (window, document, $, undefined) {

  var DATA_NS = 'jq.dropdown';
  var dropdowns = [];

  var _firstLoadEvents = ['mouseenter', 'open-dropdown'];

  /**
   * This event is added to [data-url] dropdowns and removed on first load
   * @private
   */
  function _firstLoadContent() {
    this.refreshContent();
    this._action.off(_firstLoadEvents.join(' '));
  }

  function _toggleEvent(e) {
    if(isConnected(e.target) && $(e.target).parents().addBack().index(this._content) === -1)
    {
      this.toggle();
    }
  }

  function _getContentTree(element) {
    var parent = element.closest('.dropdown-content');
    if(parent.length > 0)
    {
      var parentTree = _getContentTree($(parent).Dropdown()._action);
      if(parentTree)
      {
        parent = parent.add(parentTree);
      }
    }
    return parent;
  }

  /**
   * loop over all dropdowns, close any which are not in the target
   */
  function _closeAll(sender) {
    var tree = _getContentTree($(sender))
      .add(sender.closest('.dropdown-action')); // add closest action

    $(dropdowns).each(function () {
      if(this.isOpen())
      {
        var me = $().add(this._action).add(this._content);
        if((!sender)
          || ((isConnected(sender) && ($(tree).filter(me).length === 0))))
        {
          this.close();
        }
      }
    });
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
    options = $.extend(true, {cancelable: false, bubbles: true, target: this._ele, detail: {dropdown: this}}, options);
    return this._action[0].dispatchEvent(new CustomEvent(eventName, options));
  };

  Dropdown.prototype.isOpen = function () {
    return this._content.is('.dropdown-open');
  };

  Dropdown.prototype.toggle = function () {
    this.isOpen() ? this.close() : this.open();
  };

  Dropdown.prototype.updateContent = function (html) {
    var $content = this._content;
    $content.html(html);
    this.reposition();
    this.triggerEvent('update');
  };

  Dropdown.prototype.refreshContent = function () {
    var self = this;
    if(this._options.contentUrl)
    {
      var xhr = new XMLHttpRequest();
      if(this.triggerEvent('content-request', {cancelable: true, detail: {xhr: xhr}}))
      {
        xhr.addEventListener('readystatechange', function () {
          if(xhr.readyState === XMLHttpRequest.DONE)
          {
            self.updateContent(xhr.response);
          }
        });
        xhr.open('GET', this._options.contentUrl);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-Fortifi-Req-With', 'ui.dropdown');
        xhr.send();
      }
    }
  };

  Dropdown.prototype.close = function () {
    if(this.triggerEvent('close', {cancelable: true}))
    {
      this._content.insertAfter(this._action).removeClass('dropdown-open');
      this.triggerEvent('closed');
    }
  };

  Dropdown.prototype.open = function () {
    if(this.triggerEvent('open', {cancelable: true}))
    {
      _closeAll(this._action);
      if(this._options.attachToBody)
      {
        this._content.appendTo('body')
      }
      this._content.addClass('dropdown-open');
      this.reposition();
      this.triggerEvent('opened');
    }
  };

  Dropdown.prototype.reposition = function () {
    var $action = this._action;
    var $content = this._content.css({left: 0, top: 0});

    var offsetTop = 0;
    var offsetLeft = 0;

    var scrollBarOffset = 0;
    var scrollCheckParent = $action.get(0);
    do // this block detects the width of scrollbars, also includes scroll position in top offset until the first relative parent
    {
      if(scrollCheckParent.clientWidth > 0)
      {
        scrollBarOffset += scrollCheckParent.offsetWidth - scrollCheckParent.clientWidth;
      }
    }
    while(scrollCheckParent = scrollCheckParent.parentElement);

    if(this._options.attachToBody)
    {
      offsetTop += $action.offset().top;
      offsetLeft += $action.offset().left;
    }
    else
    {
      offsetTop = $action.get(0).offsetTop;
      offsetLeft = $action.get(0).offsetLeft;
    }

    scrollBarOffset += this._options.margin;

    var
      css = {},
      offsetRight = $content.offset().left + $content.outerWidth(true);

    if(offsetRight > document.body.clientWidth - scrollBarOffset)
    {
      css.left = Math.max(
        document.body.clientWidth - offsetRight - scrollBarOffset,
        ($content.offset().left - scrollBarOffset) * -1
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
  };

  Dropdown.prototype.init = function (options) {
    if(!this._isInitialised)
    {
      var self = this;
      options = $.extend(
        {margin: 10, position: 'bottom', contentUrl: null, attachToBody: false},
        $(this._ele).data(),
        options
      );

      this._options = options;

      this._action = $(this._ele)
        .addClass('dropdown-action')
        .on('click', _toggleEvent.bind(this));
      this._content = $('~ .dropdown-content', this._ele);
      if(!this._content.length)
      {
        this._content = $('<div />').addClass('dropdown-content').insertAfter(this._action);
      }

      if(this._options.contentUrl)
      {
        this._action.on(_firstLoadEvents.join(' '), _firstLoadContent.bind(this));
      }
      else
      {
        self.triggerEvent('update');
      }

      this._content.data(DATA_NS, this);

      dropdowns.push(this);

      this._isInitialised = true;
    }
    return this;
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
