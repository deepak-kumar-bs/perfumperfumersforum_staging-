/**
 * Draggable Background plugin for jQuery
 *
 * v1.2.4
 *
 * Copyright (c) 2014 Kenneth Chung
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */
;(function($) {
  var $window = $(window);

  // Helper function to guarantee a value between low and hi unless bool is false
  var limit = function(low, hi, value, bool) {
    if (arguments.length === 3 || bool) {
      if (value < low) return low;
      if (value > hi) return hi;
    }
    return value;
  };

  // Adds clientX and clientY properties to the jQuery's event object from touch
  var modifyEventForTouch = function(e) {
    e.clientX = e.originalEvent.touches[0].clientX;
    e.clientY = e.originalEvent.touches[0].clientY;
  };
  var getBackgroundImageDimensions = function($el) {
    var bgSrc = ($el.attr('src') || []);
    if (!bgSrc) return;
		console.log(bgSrc,'bgSrcIn');
    var imageDimensions = { width: 0, height: 0 },
        image = new Image();
    image.onload = function() {
			console.log(image,image.width,image.height,'imageDimensions');
      if ($el.css('background-size') == "cover") {
        var elementWidth = $el.innerWidth(),
            elementHeight = $el.innerHeight(),
            elementAspectRatio = elementWidth / elementHeight;
            imageAspectRatio = image.width / image.height,
            scale = 1;
        if (imageAspectRatio >= elementAspectRatio) {
          scale = elementHeight / image.height;
        } else {
          scale = elementWidth / image.width;
        }
        imageDimensions.width = image.width * scale;
        imageDimensions.height = image.height * scale;
      } else {
        imageDimensions.width = image.width;
        imageDimensions.height = image.height;
      }
    };
    image.src = bgSrc;
		console.log(imageDimensions,'imageDimensions');
    return imageDimensions;
  };
  function Plugin(element, options) {
    this.element = element;
    this.options = options;
    this.init();
  }
  Plugin.prototype.init = function() {
    var $el = $(this.element),
        bgSrc = ($el.attr('src') || []),
        options = this.options;
		console.log($el,'$el');
		console.log(bgSrc,'bgSrc');
    if (!bgSrc) return;
    // Get the image's width and height if bound
    var imageDimensions = { width: 0, height: 0 };
    if (options.bound) {
      imageDimensions = getBackgroundImageDimensions($el);
    }
		console.log(imageDimensions,'imageDimensions');
    $el.on('mousedown.dbg touchstart.dbg', function(e) {
      if (e.target !== $el[0]) {
        return;
      }
      e.preventDefault();
      if (e.originalEvent.touches) {
        modifyEventForTouch(e);
      } else if (e.which !== 1) {
        return;
      }
      var x0 = e.clientX,
          y0 = e.clientY,
          pos = $el.css('top') || [],
          xPos = parseInt(pos) || 0;
		 console.log(xPos);
      $window.on('mousemove.dbg touchmove.dbg', function(e) {
        e.preventDefault();
        if (e.originalEvent.touches) {
          modifyEventForTouch(e);
        }
        var x = e.clientX,
        xPos = options.axis === 'y' ? xPos : limit($el.innerWidth()-imageDimensions.width, 0, xPos+x-x0, options.bound);
        x0 = x;
        $el.css('top', xPos );
      });
			console.log(xPos);
      $window.on('mouseup.dbg touchend.dbg mouseleave.dbg', function() {
        if (options.done) {
          options.done();
        }
        $window.off('mousemove.dbg touchmove.dbg');
        $window.off('mouseup.dbg touchend.dbg mouseleave.dbg');
      });
    });
  };
  Plugin.prototype.disable = function() {
    var $el = $(this.element);
    $el.off('mousedown.dbg touchstart.dbg');
    $window.off('mousemove.dbg touchmove.dbg mouseup.dbg touchend.dbg mouseleave.dbg');
  }

  $.fn.backgroundDraggable = function(options) {
    var options = options;
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function() {
      var $this = $(this);

      if (typeof options == 'undefined' || typeof options == 'object') {
        options = $.extend({}, $.fn.backgroundDraggable.defaults, options);
        var plugin = new Plugin(this, options);
        $this.data('dbg', plugin);
      } else if (typeof options == 'string' && $this.data('dbg')) {
        var plugin = $this.data('dbg');
        Plugin.prototype[options].apply(plugin, args);
      }
    });
  };

  $.fn.backgroundDraggable.defaults = {
    bound: true,
    axis: undefined
  };
}(jQuery));
