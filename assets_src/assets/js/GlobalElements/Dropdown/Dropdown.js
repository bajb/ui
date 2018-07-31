/* global window, document, jQuery */

(function (window, document, $, undefined) {

  var DATA_NS = 'jq.dropdown';
  var dropdowns = [];

  $(document).on('click', function (e) {
    // loop over all dropdowns, close any which are not in the target
    $(dropdowns).each(function () {
      var tree = $(e.target).parents().addBack();
      if(this.isOpen() && !(
        (tree.index(this._action) > -1)
        || (tree.index(this._content) > -1)
      ))
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

  function Dropdown(ele) {
    this._ele = ele;
    this._options = {};
    this._action = null;
    this._content = null;
  }

  Dropdown.prototype.isOpen = function () {
    return jQuery.contains(document.documentElement, this._content[0]);
  };

  Dropdown.prototype.toggle = function () {
    this.isOpen() ? this.close() : this.open();
  };

  Dropdown.prototype.refreshContent = function () {
    var self = this;
    var $content = this._content;
    var xhr = new XMLHttpRequest();
    xhr.addEventListener('readystatechange', function () {
      if(xhr.readyState === XMLHttpRequest.DONE)
      {
        $content.html(xhr.response);
        self.reposition();
      }
    });
    xhr.open('GET', this._action.attr('data-content-url'));
    xhr.send();
  };

  Dropdown.prototype.open = function () {
    this._content.appendTo('body');
    this.reposition();
  };

  Dropdown.prototype.reposition = function () {
    if(this.isOpen())
    {
      var $action = this._action;
      var $content = this._content;
      console.log('repos', $content);
      $content.css({left: '', top: ''});

      var
        left = $action.offset().left,
        right = left + $content.outerWidth(true),
        top = $action.offset().top + $action.outerHeight(true);

      if(right > window.innerWidth - this._options.margin)
      {
        left = Math.max(2, left - (right - window.innerWidth) - this._options.margin);
      }

      $content.css({left: left, top: top});
    }
  };

  Dropdown.prototype.close = function () {
    this._content.detach();
  };

  Dropdown.prototype.init = function (options) {
    var self = this;
    options = $.extend({margin: 10}, options);
    this._options = options;

    this._action = $(this._ele).on('click', this.toggle.bind(this));

    if(this._action.attr('data-content-url'))
    {
      this._action.on('mouseenter', function () {
        self.refreshContent();
        self._action.off('mouseenter');
      });
      this._content = $('<div />').addClass('dropdown-content');
    }
    else
    {
      this._content = $('.dropdown-content', this._ele).detach();
    }

    dropdowns.push(this);
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

  $('.dropdown-action').Dropdown()

}(window, document, jQuery));
