/* global window, document, jQuery */

(function (window, document, $, undefined) {

  var DATA_NS = 'jq.lightbox';
  var lightboxes = [];

  var _firstLoadEvents = ['mouseenter', 'open-lightbox'];

  /**
   * This event is added to [data-url] lightboxes and removed on first load
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
    var parent = element.closest('.lightbox-content');
    if(parent.length > 0)
    {
      var parentTree = _getContentTree($(parent).Lightbox()._action);
      if(parentTree)
      {
        parent = parent.add(parentTree);
      }
    }
    return parent;
  }

  function _getLightboxContainer() {
    var c = $('body > #lightbox-container');
    if(c.length === 0)
    {
      c = $('<div id="lightbox-container"/>').appendTo('body');
    }
    return c;
  }

  /**
   * loop over all lightboxes, close any which are not in the target
   */
  function _closeAll(sender) {
    var tree = _getContentTree($(sender))
      .add(sender.closest('.lightbox-action')); // add closest action

    $(lightboxes).each(function () {
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
    $(lightboxes).each(function () {
      this.reposition();
    });
  });

  function isConnected(ele) {
    return jQuery.contains(document, ele);
  }

  function Lightbox(ele) {
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
  Lightbox.prototype.triggerEvent = function (eventName, options) {
    eventName = eventName + '-lightbox';
    options = $.extend(true, {cancelable: false, bubbles: true, target: this._ele, detail: {lightbox: this}}, options);
    return this._action[0].dispatchEvent(new CustomEvent(eventName, options));
  };

  Lightbox.prototype.isOpen = function () {
    return this._content.is('.lightbox-open');
  };

  Lightbox.prototype.toggle = function () {
    this.isOpen() ? this.close() : this.open();
  };

  Lightbox.prototype.updateContent = function (html) {
    var $content = this._content;
    $content.html(html);
    this.reposition();
    this.triggerEvent('update');
  };

  Lightbox.prototype.refreshContent = function () {
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
        xhr.setRequestHeader('X-Fortifi-Req-With', 'ui.lightbox');
        xhr.send();
      }
    }
  };

  Lightbox.prototype.close = function () {
    if(this.triggerEvent('close', {cancelable: true}))
    {
      this._content.insertAfter(this._action).removeClass('lightbox-open');
      this.triggerEvent('closed');
    }
  };

  Lightbox.prototype.open = function () {
    if(this.triggerEvent('open', {cancelable: true}))
    {
      _closeAll(this._action);
      this._content.appendTo('body').addClass('lightbox-open');
      this.reposition();
      this.triggerEvent('opened');
    }
  };

  Lightbox.prototype.reposition = function () {
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

    offsetTop += $action.offset().top;
    offsetLeft += $action.offset().left;

    scrollBarOffset += this._options.margin;

    var
      css = {},
      offsetRight = $action.offset().left + $content.outerWidth(true),
      docWidth = document.body.clientWidth - scrollBarOffset;

    if(offsetRight > docWidth)
    {
      css.left = Math.max(
        offsetLeft + (docWidth - offsetRight), // keep moving left until:
        ($content.offset().left - scrollBarOffset) * -1 // it hits the left side of the screen
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

  Lightbox.prototype.init = function (options) {
    if(!this._isInitialised)
    {
      console.log('init', this);
      var self = this;
      options = $.extend(
        {margin: 10, position: 'bottom', contentUrl: null, modal: false},
        $(this._ele).data(),
        options
      );

      this._options = options;

      this._action = $(this._ele)
        .addClass('lightbox-action')
        .on('click', _toggleEvent.bind(this));
      this._content = $('+ .lightbox-content', this._ele);
      if(!this._content.length)
      {
        this._content = $('<div />').addClass('lightbox-content').insertAfter(this._action);
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

      lightboxes.push(this);

      this._isInitialised = true;
    }
    return this;
  };

  $.fn.Lightbox = function (command, options) {
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
    if(typeof Lightbox.prototype[command] !== 'function')
    {
      throw 'Lightbox command \'' + command + '\' not found';
    }
    args.shift();
    var retVal = $(this);
    $(this).each(
      function () {
        var $this = $(this), instance = $this.data(DATA_NS);
        if(!instance)
        {
          $this.data(DATA_NS, new Lightbox(this));
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

  document.dispatchEvent(new CustomEvent('ready-lightbox'));
}(window, document, jQuery));
