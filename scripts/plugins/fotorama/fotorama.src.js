/*! Fotorama 2.0.2 (v1320) | http://fotoramajs.com/license.txt */


(function ($) {
  /* Modernizr 2.0.6 (Custom Build) | MIT & BSD
   * Build: http://www.modernizr.com/download/#-csstransforms-csstransitions-canvas-testprop-testallprops-domprefixes
   */
  var Mdrnzr = function (a, b, c) {
    function z(a, b) {
      var c = a.charAt(0).toUpperCase() + a.substr(1), d = (a + " " + m.join(c + " ") + c).split(" ");
      return y(d, b)
    }

    function y(a, b) {
      for (var d in a)if (j[a[d]] !== c)return b == "pfx" ? a[d] : !0;
      return!1
    }

    function x(a, b) {
      return!!~("" + a).indexOf(b)
    }

    function w(a, b) {
      return typeof a === b
    }

    function v(a, b) {
      return u(prefixes.join(a + ";") + (b || ""))
    }

    function u(a) {
      j.cssText = a
    }

    var d = "2.0.6", e = {}, f = b.documentElement, g = b.head || b.getElementsByTagName("head")[0], h = "modernizr", i = b.createElement(h), j = i.style, k, l = Object.prototype.toString, m = "Webkit Moz O ms Khtml".split(" "), n = {}, o = {}, p = {}, q = [], r, s = {}.hasOwnProperty, t;
    !w(s, c) && !w(s.call, c) ? t = function (a, b) {
      return s.call(a, b)
    } : t = function (a, b) {
      return b in a && w(a.constructor.prototype[b], c)
    }, n.canvas = function () {
      var a = b.createElement("canvas");
      return!!a.getContext && !!a.getContext("2d")
    }, n.csstransforms = function () {
      return!!y(["transformProperty", "WebkitTransform", "MozTransform", "OTransform", "msTransform"])
    }, n.csstransitions = function () {
      return z("transitionProperty")
    };
    for (var A in n)t(n, A) && (r = A.toLowerCase(), e[r] = n[A](), q.push((e[r] ? "" : "no-") + r));
    u(""), i = k = null, e._version = d, e._domPrefixes = m, e.testProp = function (a) {
      return y([a])
    }, e.testAllProps = z;
    return e
  }(this, this.document);

  /*!
   * Bez v1.0.10-g5ae0136
   * http://github.com/rdallasgray/bez
   *
   * A plugin to convert CSS3 cubic-bezier co-ordinates to jQuery-compatible easing functions
   *
   * With thanks to Nikolay Nemshilov for clarification on the cubic-bezier maths
   * See http://st-on-it.blogspot.com/2011/05/calculating-cubic-bezier-function.html
   *
   * Copyright 2011 Robert Dallas Gray. All rights reserved.
   * Provided under the FreeBSD license: https://github.com/rdallasgray/bez/blob/master/LICENSE.txt
   */
  $.extend({bez:function (a) {
    var b = "bez_" + $.makeArray(arguments).join("_").replace(".", "p");
    if (typeof jQuery.easing[b] != "function") {
      var c = function (a, b) {
        var c = [null, null], d = [null, null], e = [null, null], f = function (f, g) {
          return e[g] = 3 * a[g], d[g] = 3 * (b[g] - a[g]) - e[g], c[g] = 1 - e[g] - d[g], f * (e[g] + f * (d[g] + f * c[g]))
        }, g = function (a) {
          return e[0] + a * (2 * d[0] + 3 * c[0] * a)
        }, h = function (a) {
          var b = a, c = 0, d;
          while (++c < 14) {
            d = f(b, 0) - a;
            if (Math.abs(d) < .001)break;
            b -= d / g(b)
          }
          return b
        };
        return function (a) {
          return f(h(a), 1)
        }
      };
      jQuery.easing[b] = function (b, d, e, f, g) {
        return f * c([a[0], a[1]], [a[2], a[3]])(d / g) + e
      }
    }
    return b
  }});

  var touchFLAG = ('ontouchstart' in document);
  var mobileFLAG = navigator.userAgent.toLowerCase().match(/(iphone|ipod|ipad|iemobile|windows ce|netfront|playstation|midp|up\.browser|symbian|nintendo|wii)/);
  var csstrFLAG = Mdrnzr.csstransforms && Mdrnzr.csstransitions && !$.browser.mozilla;
  var ieFLAG = $.browser.msie;
  var ie6FLAG = ieFLAG && '6.0' == $.browser.version;
  var quirksFLAG = document.compatMode != 'CSS1Compat' && ieFLAG;

  var o__dragTimeout = 300;
  var o__bez = $.bez([.1, 0, .25, 1]);
  var o__transitionDuration = 333;

  var F = 'fotorama';

  var $window = $(window),
      $document = $(document),
      $html,
      $body;

  var _options = [
    ['width', 'string', null],
    //
    ['height', 'string', null],
    //
    ['aspectRatio', 'number', null],

    ['touchStyle', 'boolean', true],
    //
    ['click', 'boolean', null],
    //
    ['pseudoClick', 'boolean', true],
    //
    ['loop', 'boolean', false],
    //
    ['autoplay', 'boolean-number', false],
    //
    ['stopAutoplayOnAction', 'boolean', true],

    ['transitionDuration', 'number', o__transitionDuration],
    //

    ['background', 'string', null],
    //
    ['backgroundColor', 'string', null],
    //
    ['margin', 'number', 5],
    //
    ['minPadding', 'number', 10],
    //
    ['alwaysPadding', 'boolean', false],
    //
    ['zoomToFit', 'boolean', true],
    //
    ['cropToFit', 'boolean', false],
    //

    ['flexible', 'boolean', false],
    //
    ['fitToWindowHeight', 'boolean', false],
    //
    ['fullscreen', 'boolean', false],
    ['fullscreenIcon', 'boolean', false],

    ['vertical', 'boolean', false],
    //

    ['arrows', 'boolean', true],
    //
    ['arrowsColor', 'string', null],
    //
    ['arrowPrev', 'string', null],
    //
    ['arrowNext', 'string', null],
    //

    ['nav', 'string', null],
    //
    ['thumbs', 'boolean', true],
    //
    ['navPosition', 'string', null],
    //
    ['thumbsOnTop', 'boolean', false],
    //
    ['thumbsOnRight', 'boolean', false],
    //
    ['navBackground', 'string', null],
    //
    ['thumbsBackgroundColor', 'string', null],
    //
    ['dotColor', 'string', null],
    //
    ['thumbColor', 'string', null],
    //
    ['thumbsPreview', 'boolean', true],
    //
    ['thumbSize', 'number', null],
    //
    ['thumbMargin', 'number', 5],
    //
    ['thumbBorderWidth', 'number', 3],
    //
    ['thumbBorderColor', 'string', null],
    //

    ['caption', 'string', false],
    //

    ['preload', 'number', 3],
    //
    ['preloader', 'boolean', 'dark'],
    //

    ['shadows', 'boolean', true],
    //

    ['data', 'array', null],
    //
    ['html', 'array', null],
    //


    ['hash', 'boolean', false],
    //
    ['startImg', 'number', 0],

    ['onShowImg', 'function', null],
    //
    ['onClick', 'function', null],
    //
    ['onSlideStop', 'function', null],
    //
    ['detachSiblings', 'boolean', true] //
  ];

  function collectOptions(block) {
    var options = {};
    for (var _i = 0; _i < _options.length; _i++) {
      var name = _options[_i][0];
      var type = _options[_i][1];
      if (block) {
        var attr = block.attr('data-' + name);
        if (attr) {
          if (type == 'number') {
            attr = Number(attr);
            if (!isNaN(attr)) {
              options[name] = attr;
            }
          } else if (type == 'boolean') {
            //////////////console.log(name, type, attr);
            if (attr == 'true') {
              options[name] = true;
            } else if (attr == 'false') {
              options[name] = false;
            }
          } else if (type == 'string') {
            options[name] = attr;
          } else if (type == 'boolean-number') {
            //////////////console.log('boolean-number', attr);
            if (attr == 'true') {
              options[name] = true;
            } else if (attr == 'false') {
              options[name] = false;
            } else {
              attr = Number(attr);
              if (!isNaN(attr)) {
                options[name] = attr;
              }
            }
          }
        }
      } else {
        options[name] = _options[_i][2];
      }
    }
    
    return options;
  }

  $.fn[F] = function (options) {
    if (typeof(fotoramaDefaults) == 'undefined') {
      fotoramaDefaults = {};
    }

    var o = $.extend(collectOptions(), $.extend({}, fotoramaDefaults, options));
    
    ////////////////console.log('lightbox', o().lightbox);

    this.each(function () {
      var fotorama = $(this);
      if (!fotorama.data('ini')) {
        doFotorama(fotorama, o);
      }
    });

    //Chainability
    return this;
  };

  $(function() {
    $html = $('html');
    $body = $('body');

    // Авто-инициализация по классу.
    $('.' + F).each(function () {
      var $this = $(this);
      $this[F](collectOptions($this));
    });
  });

  var _prefix = ['-webkit-', '-moz-', '-o-', '-ms-', ''];

  function getCSS(prop, val) {
    var obj = {};
    for (var _i = 0; _i < _prefix.length; _i++) {
      obj[_prefix[_i] + prop] = val;
    }
    return obj;
  }

  function getTranslate(pos, vert) {
    if (csstrFLAG) {
      return getCSS('transform', vert ? 'translate(0,' + pos + 'px)' : 'translate(' + pos + 'px,0)');
    } else {
      var obj = {};
      obj[vert ? 'top' : 'left'] = pos;
      return obj;
    }
  }

  function preventClick() {
    return false;
  }

  function getDuration(time) {
    return getCSS('transition-duration', time + 'ms');
  }

  function disableSelection(target) {
    target
        .mousemove(function (e) {
      e.preventDefault();
    })
        .mousedown(function (e) {
          e.preventDefault();
        });
  }

  function clearSelection() {
    if (document.selection && document.selection.empty) {
      document.selection.empty();
    } else if (window.getSelection) {
      var sel = window.getSelection();
      sel.removeAllRanges();
    }
  }

  var _base64Test = 'data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
  var base64Test = new Image();
  var base64FLAG = true;
  base64Test.onerror = function () {
    if (this.width != 1 || this.height != 1) {
      base64FLAG = false;
    }
  };
  base64Test.src = _base64Test;

  function doFotorama(fotorama, o) {
    fotorama.data({ini:true, options:o});

    o = function () {
      return fotorama.data('options');
    };

    // Обратная совместимость со старыми опциями
    if (o().backgroundColor && !o().background) {
      o().background = o().backgroundColor;
    }

    if (o().thumbsBackgroundColor && !o().navBackground) {
      o().navBackground = o().thumbsBackgroundColor;
    }

    if (o().thumbColor && !o().dotColor) {
      o().dotColor = o().thumbColor;
    }

    if (o().click !== null) {
      o().pseudoClick = o().click;
    }

    if (o().nav === true || o().nav == 'true' || o().nav == 'thumbs') {
      o().thumbs = true;
      o().thumbsPreview = true;
    } else if (o().nav == 'dots') {
      o().thumbs = true;
      o().thumbsPreview = false;
    } else if (o().nav === false || o().nav == 'false' || o().nav == 'none') {
      o().thumbs = false;
    }

    if (o().caption) {
      if (o().caption === true || o().caption == 'true' || o().caption == 'simple') {
        o().caption = true;
      } else if (o().caption != 'overlay') {
        o().caption = false;
      }
    }

    if (o().navPosition == 'top') {
      o().thumbsOnTop = true;
      o().thumbsOnRight = false;
    } else if (o().navPosition == 'right') {
      o().thumbsOnTop = false;
      o().thumbsOnRight = true;
    } else if (o().navPosition == 'bottom') {
      o().thumbsOnTop = false;
      o().thumbsOnRight = false;
    } else if (o().navPosition == 'left') {
      o().thumbsOnTop = false;
      o().thumbsOnRight = false;
    }

    var fotoramaState;

    var timestamp = new Date().getTime();

    if (o().hash && document.location.hash) {
      o().startImg = parseInt(document.location.hash.replace('#', '')) - 1;
    }

    // Все изображения
    var img;
    var dataFLAG = o().data && (typeof(o().data) == 'object' || typeof(o().data) == 'string');
    if (!dataFLAG) {
      img = fotorama.children().filter(function () {
        var thisChild = $(this);
        return ((thisChild.is('a') && thisChild.children('img').size()) || thisChild.is('img')) && (thisChild.attr('href') || thisChild.attr('src') || thisChild.children().attr('src'));
      });
    } else {
      img = $(o().data).filter(function () {
        //////////////console.log('filter data');
        return this.img || this.href || this.length;
      });
    }
    var size = img.size();
    fotorama.data({size:size});

    o().preload = Math.min(o().preload, size);

    if (o().startImg > size - 1 || typeof(o().startImg) != 'number') {
      o().startImg = 0;
    }
    
    var src = [];
    
    img.each(function (i, v) {
      if (!dataFLAG) {
        var thisImg = $(this);
        src[i] = {imgHref:thisImg.attr('href'), imgSrc:thisImg.attr('src'), thumbSrc:thisImg.children().attr('src'), imgRel:thisImg.attr('rel') ? thisImg.attr('rel') : thisImg.children().attr('rel')};
        if (o().caption) {
          this.caption = thisImg.attr('alt') || thisImg.children().attr('alt');
        }
      } else {
        src[i] = {imgHref:this.img ? this.img : this.href ? this.href : this.length ? String(this) : null, thumbSrc:this.thumb, imgRel:this.full};
      }
      //console.log(thisImg.children().data())
      for(j in thisImg.data()) {
        src[i][j] = thisImg.data()[j]
        
      }
    });
    
    // Очищаем DOM, присваиваем классы
    fotorama.html('').addClass(F + ' ' + (o().vertical ? F + '_vertical' : F + '_horizontal'));


    if (ie6FLAG || mobileFLAG) {
      var outer = fotorama.wrap('<div class="fotorama-outer"></div>').parent();
    }

    /*if (o().touchStyle) {
     //o().loop = false;
     } else */
    if (!o().arrows) {
      o().loop = true;
    }

    var srcState = [];

    var wrapSize, wrapSize2;
    var wrapWidth, wrapHeight, wrapWidthIdeal, wrapHeightIdeal;
    var percentWidth = 1;
    var heightAutoFLAG = true;
    var widthAutoFLAG = true;
    var resizeFLAG;
    var exp = {
      no:/^[0-9.]+$/,
      px:/^[0-9.]+px/,
      '%':/^[0-9.]+%/
    };

    var wrapRatio, wrapRatioIdeal, wrapRatioForced, ratioAutoFLAG;
    var wrapWidthLast, wrapHeightLast, wrapRatioLast;
    var wrapIsSetFLAG, wrapSizeFromFirstFLAG, forcedRatioFLAG, fullscreenFLAG, bindedRescaleFLAG, animatingFLAG, setAnimatingFLAG, scrollTop, scrollLeft;
    //var rfs = fotorama[0].requestFullScreen || fotorama[0].webkitRequestFullScreen || fotorama[0].mozRequestFullScreen;
    var loadTimeout, playFLAG, playingTimeout;


    //////////////console.log('o().autoplay', o().autoplay);
    if (o().autoplay === true || o().autoplay == 'true' || o().autoplay > 0) {
      playFLAG = true;
    }
    if (typeof(o().autoplay) != 'number') {
      o().autoplay = 5000;
    }

    if (o().touchStyle) {
      var shaftSize = 0,
          shaftSize2;

      var shaftGrabbingFLAG = false;
      var shaftMouseDownFLAG = false;
      var setShaftGrabbingFLAGTimeout;
    }

    if (o().thumbs && o().thumbsPreview) {
      var thumbsShaftMouseDownFLAG = false;
      var thumbsShaftDraggedFLAG = false;
      var thumbsShaftJerkFLAG = false;
      var thumbsShaftGrabbingFLAG = false;
      var setThumbsShaftGrabbingFLAGTimeout;
      var thumbsReadyFLAG = false;
      var thumbsReadySize = 0;
    }


    var _pos, _pos2, _coo, _coo2, _size, _size2;
    if (!o().vertical) {
      _pos = 'left';
      _pos2 = 'top';
      _coo = 'pageX';
      _coo2 = 'pageY';
      _size = 'width';
      _size2 = 'height';
    } else {
      _pos = 'top';
      _pos2 = 'left';
      _coo = 'pageY';
      _coo2 = 'pageX';
      _size = 'height';
      _size2 = 'width';
    }

    var wrap = $('<div class="' + F + '__wrap"></div>').appendTo(fotorama);
    var shaft = $('<div class="' + F + '__shaft"></div>').appendTo(wrap);

    // Запрещаем выделять фотораму
    if (!o().touchStyle) {
      disableSelection(wrap);
      disableSelection(shaft);
    }

    var stateIcon = $('<div class="' + F + '__state"></div>').appendTo(shaft);
    if (o().preloader == 'white' || (o().background && o().background.match(/(white|#fff|#FFF)/))) {
      stateIcon.addClass(F + '__state_white');
    }
    var stateIconPositionTimeout;

    if (o().fullscreenIcon) {
      var fullscreenIcon = $('<div class="' + F + '__fsi"><i class="i1"><i class="i1"></i></i><i class="i2"><i class="i2"></i></i><i class="i3"><i class="i3"></i></i><i class="i4"><i class="i4"></i></i><i class="i0"></i></div>').appendTo(wrap);
    }

//		function stateIconSpinner() {
//			stateIcon.css({backgroundPosition: '24px ' + (24 - 56*stateIconSpinnerIntervalI) + 'px'});
//			stateIconSpinnerIntervalI++;
//			if (stateIconSpinnerIntervalI > 7) stateIconSpinnerIntervalI = 0;
//		}

    if (touchFLAG) fotorama.addClass(F + '_touch');
    if (mobileFLAG) o().shadows = false;
    if (o().touchStyle) {
      wrap.addClass(F + '__wrap_style_touch');
      if (o().shadows) {
        wrap.append('<i class="' + F + '__shadow ' + F + '__shadow_prev"></i><i class="' + F + '__shadow ' + F + '__shadow_next"></i>');
      }
    } else {
      wrap.addClass(F + '__wrap_style_fade');
    }

    if (o().shadows) {
      fotorama.addClass(F + '_shadows');
    }

    if (csstrFLAG) {
      fotorama.addClass(F + '_csstransitions');
    }

    if (o().arrows) {
      var _arrPrev, _arrNext;
      if (!o().vertical) {
        _arrPrev = o().arrowPrev ? o().arrowPrev : '&#9668;';
        _arrNext = o().arrowNext ? o().arrowNext : '&#9658;';
      } else {
        _arrPrev = o().arrowPrev ? o().arrowPrev : '&#9650;';
        _arrNext = o().arrowNext ? o().arrowNext : '&#9660;';
      }

      var arrs = $('<i class="' + F + '__arr ' + F + '__arr_prev">' + _arrPrev + '</i><i class="' + F + '__arr ' + F + '__arr_next">' + _arrNext + '</i>').appendTo(wrap);
      var arrPrev = arrs.eq(0);
      var arrNext = arrs.eq(1);

      if (!touchFLAG) {
        if (o().pseudoClick) {
          var wrapMouseCoo, wrapMouseMoveTimeout;

          function hiliteArrs() {
            clearTimeout(wrapMouseMoveTimeout);
            wrapMouseMoveTimeout = setTimeout(function () {
              var forwardFLAG = wrapMouseCoo >= wrapSize / 2;
              //if (forwardFLAG != forwardFLAGLast) {
              arrNext[!forwardFLAG ? 'removeClass' : 'addClass'](F + '__arr_hover');
              arrPrev[forwardFLAG ? 'removeClass' : 'addClass'](F + '__arr_hover');

              if (!o().touchStyle) {
                shaft.css({cursor:(forwardFLAG && arrNext.data('disabled')) || (!forwardFLAG && arrPrev.data('disabled')) ? 'default' : 'pointer'});
              }
            }, 10);
          }

          wrap.mousemove(function (e) {
            wrapMouseCoo = e[_coo] - wrap.offset()[_pos];
            hiliteArrs();
          });
        }
      }
    } else if (!o().touchStyle && o().pseudoClick && size > 1) {
      shaft.css({cursor:'pointer'});
    }

    if (!touchFLAG) {
      // Стрелочки при наведении на фотораму
      var wrapEnteredFLAG = false;
      var wrapLeaveTimeout;

      function wrapEnter() {
        wrapEnteredFLAG = true;
        clearTimeout(wrapLeaveTimeout);
        if (o().arrows) {
          arrs.css(getDuration(0));
        }
        wrap.removeClass(F + '__wrap_mouseout');
        setTimeout(function () {
          if (o().arrows) {
            arrs.css(getDuration(o().transitionDuration));
          }
          setTimeout(function () {
            wrap.addClass(F + '__wrap_mouseover');
          }, 1);
        }, 1);
      }

      function wrapLeave() {
        clearTimeout(wrapLeaveTimeout);
        wrapLeaveTimeout = setTimeout(function () {
          if (!shaftGrabbingFLAG && !wrapEnteredFLAG) {
            wrap
                .removeClass(F + '__wrap_mouseover')
                .addClass(F + '__wrap_mouseout');
          }
        }, o().transitionDuration * 3);
      }

      wrap.mouseenter(function () {
        wrapEnter();
      });
      wrap.mouseleave(function () {
        wrapEnteredFLAG = false;
        wrapLeave();
      });
    }

    var activeImg, activeIndex, activeCaption;

    var imgFrame = $();
    img.each(function (i) {
      // Заготавливаем фреймы под фотки
      var _imgFrame = $('<div class="' + F + '__frame" style="visibility: hidden;"></div>');
      imgFrame = imgFrame.add(_imgFrame);
    });

    if (o().thumbs) {
      var o__thumbSize = Number(o().thumbSize);
      if (isNaN(o__thumbSize) || !o__thumbSize) {
        o__thumbSize = o().vertical ? 64 : 48;
      }
      // Если тумбсы или превьюшки
      var activeThumb;
      var activeThumbPrevIndex = 0;
      // Контейнер для тумбсов-переключалок
      var thumbs = $('<div class="' + F + '__thumbs" style="visibility: hidden;"></div>')[o().thumbsOnTop ? 'prependTo' : 'appendTo'](fotorama);
      var thumbsSize2;

      if (o().thumbsPreview) {
        thumbsSize2 = o__thumbSize + o().thumbMargin * 2;
        thumbs
            .addClass(F + '__thumbs_previews')
            .css(_size2, thumbsSize2);
      }

      var thumbsShaft = $('<div class="' + F + '__thumbs-shaft"></div>').appendTo(thumbs);
      if (o().thumbsPreview) {
        var thumbsShaftSize = 0;
        var thumbsShaftPos = undefined;
        if (o().shadows) {
          $('<i class="' + F + '__shadow ' + F + '__shadow_prev"></i><i class="' + F + '__shadow ' + F + '__shadow_next"></i>').appendTo(thumbs);
        }

        var thumbBorderSize2 = o__thumbSize - (quirksFLAG ? 0 : o().thumbBorderWidth * 2);
        var thumbBorderPos2 = o().thumbMargin;
        var _css = {};
        _css[_size2] = thumbBorderSize2;
        _css[_pos2] = thumbBorderPos2;
        _css.borderWidth = o().thumbBorderWidth;
        var thumbBorder = $('<i class="' + F + '__thumb-border"></i>')/*.hide()*/.css(_css).appendTo(thumbsShaft);
        var thumbBorderVisibleFLAG;
      }

      // Создаём точки и превьюшки
      img.each(function (i) {
        // Одна точка-переключалка
        var _thumb;
        if (o().thumbsPreview) {
          _thumb = $('<div class="' + F + '__thumb"></div>');
          var _css = {};
          _css[_size2] = o__thumbSize;
          _css.margin = o().thumbMargin;
          _thumb.css(_css);
        } else {
          _thumb = $('<i class="' + F + '__thumb"><i class="' + F + '__thumb__dot"></i></i>');
        }
        _thumb.appendTo(thumbsShaft);
      });

      var thumb = $('.' + F + '__thumb', fotorama);

      if (o().thumbsPreview) {
        // Загружаем превьюшки
        function thumbOnLoad(thisThumbNew, thumbWidth, thumbHeight, thumbRatio, srcKey, i) {
          var $thisThumbNew = $(thisThumbNew);
          // Одна точка-переключалка на загрузке
          var _thumbSize = o().vertical ? Math.round(o__thumbSize / thumbRatio) : Math.round(o__thumbSize * thumbRatio);

          if (Mdrnzr.canvas) {
            $thisThumbNew.remove();
            $thisThumbNew = $('<canvas class="' + F + '__thumb__img"></canvas>');
            $thisThumbNew.appendTo(thumb.eq(i));
          } else {
            $thisThumbNew.addClass(F + '__thumb__img');
          }

          var _css = {};
          _css[_size] = _thumbSize;
          _css[_size2] = o__thumbSize;
          $thisThumbNew.attr(_css).css(_css).css({visibility:'visible'});

          if (Mdrnzr.canvas) {
            var ctx = $thisThumbNew[0].getContext('2d');
            $thisThumbNew[0].getContext('2d').drawImage(thisThumbNew, 0, 0, o().vertical ? o__thumbSize : _thumbSize, o().vertical ? _thumbSize : o__thumbSize);
          }

          thumbsShaftSize += _thumbSize + o().thumbMargin - (o__thumbSize + o().thumbMargin);
          thumbsShaft.css(_size, thumbsShaftSize);
          _css[_size2] = null;
          thumb.eq(i).css(_css).data(_css);

          setThumbsShaft();
        }

        function loadThumb(i) {
          if (!thumbsShaftGrabbingFLAG && !thumbsShaftMouseDownFLAG && !shaftMouseDownFLAG && !animatingFLAG) {
            if (!i) i = 0;
            loadImg(i, thumb.eq(i), thumbOnLoad, 'thumb');

            // Если включены превьюшки, придётся загружать все картинки разом
            // Будем делать это порциями по 20 в секунду
            setTimeout(function () {
              if (i + 1 < size) {
                loadThumb(i + 1);
              }
            }, 50);
          } else {
            setTimeout(function () {
              loadThumb(i);
            }, 100);
          }
        }
      }

    }

    if (o().caption) {
      var caption = $('<p class="' + F + '__caption"></p>');
      if (o().caption == 'overlay') {
        caption.appendTo(wrap).addClass(F + '__caption_overlay');
      } else {
        caption.appendTo(fotorama);
        var captionOuter = caption.wrap('<div class="' + F + '__caption-outer"></div>').parent();
      }

    }

    function setWidthAndHeight(width, height, ratio) {
      //////////console.log('setWidthAndHeight');
      if (width) {
        if (exp.no.test(width) || exp.px.test(width)) {
          wrapWidth = Number(String(width).replace('px', ''));
          wrapWidthIdeal = wrapWidth;
          resizeFLAG = false;
          widthAutoFLAG = false;
        } else if (exp['%'].test(width)) {
          percentWidth = Number(String(width).replace('%', '')) / 100;
          resizeFLAG = !o().flexible;
          if (!wrapWidth) {
            wrapWidth = fotorama.width() * (fullscreenFLAG ? 1 : percentWidth) - (o().vertical && thumbs ? thumbs.width() : 0);
          }
          widthAutoFLAG = false;
        } else {
          widthAutoFLAG = true;
        }
      }
      if (height) {
        if (exp.no.test(height) || exp.px.test(height)) {
          wrapHeight = Number(String(height).replace('px', ''));
          wrapHeightIdeal = wrapHeight;
          heightAutoFLAG = false;
        } else {
          heightAutoFLAG = true;
        }
      }

      if (width == 'auto' || !width || height == 'auto' || !height) {


        //////console.log('srcKey', srcKey);

        var _wrapRatio = Number(ratio);
        var srcKey = imgFrame.filter(
            function () {
              return $(this).data('state') != 'error';
            }).filter(':first').data('srcKey');

        if (isNaN(_wrapRatio) || !_wrapRatio) {
          _wrapRatio = null;
          if (srcKey) {
            _wrapRatio = src[srcKey].imgRatio;
          }
        }

        if (_wrapRatio) {
          wrapRatio = _wrapRatio;
          wrapRatioIdeal = _wrapRatio;
          wrapRatioForced = _wrapRatio;
          if (srcKey) {
            if (width == 'auto' || !width) {
              wrapWidth = src[srcKey].imgWidth;
              wrapWidthIdeal = wrapWidth;
              widthAutoFLAG = true;
            }
            if (height == 'auto' || !height) {
              wrapHeight = src[srcKey].imgHeight;
              wrapHeightIdeal = wrapHeight;
              heightAutoFLAG = true;
            }
          }

          if (heightAutoFLAG && _wrapRatio && !widthAutoFLAG) {
            wrapHeight = Math.round(wrapWidth / _wrapRatio);
            wrapHeightIdeal = wrapHeight;
          }

          if (!heightAutoFLAG && _wrapRatio && widthAutoFLAG) {
            wrapWidth = Math.round(wrapHeight * _wrapRatio);
            wrapWidthIdeal = wrapWidth;
          }
        }
      }
    }

    setWidthAndHeight(o().width, o().height, o().aspectRatio);

    function getRatioWidthHeight(forceResize) {
      var windowHeight;
      if (o().fitToWindowHeight || fullscreenFLAG) {
        windowHeight = $window.height();
      }

      if (!wrapRatio || forceResize) {
        wrapRatio = wrapWidth / wrapHeight;
        wrapRatioIdeal = wrapRatio;
        wrapRatioForced = wrapRatio;
      }
      if (o().thumbs && !thumbsSize2) {
        thumbsSize2 = o().vertical ? thumbs.width() : thumbs.height();
      }
      ////if (resizeFLAG) {

      if (!forcedRatioFLAG) {
        wrapRatio = wrapRatioIdeal;
      } else {
        wrapRatio = wrapRatioForced;
      }

      fotorama.css({overflow:resizeFLAG || fullscreenFLAG ? 'hidden' : ''});

      if (resizeFLAG || fullscreenFLAG) {
        wrapWidth = fotorama.width() * (fullscreenFLAG ? 1 : percentWidth) - (o().vertical && thumbsSize2 ? thumbsSize2 : 0);
      } else if (wrapWidthIdeal) {
        wrapWidth = wrapWidthIdeal;
      }

      if (fullscreenFLAG) {
        wrapHeight = windowHeight - (!o().vertical && thumbsSize2 ? thumbsSize2 : 0);
        wrapRatio = wrapWidth / wrapHeight;
      } else {
        if (heightAutoFLAG) {
          wrapHeight = Math.round(wrapWidth / wrapRatio);
        } else {
          wrapHeight = wrapHeightIdeal;
          wrapRatio = wrapWidth / wrapHeight;
        }
      }

      if (o().fitToWindowHeight && !fullscreenFLAG) {
        if (wrapHeight > windowHeight - 20 - (!o().vertical && thumbsSize2 ? thumbsSize2 : 0)) {
          wrapHeight = windowHeight - 20 - (!o().vertical && thumbsSize2 ? thumbsSize2 : 0);
          wrapRatio = wrapWidth / wrapHeight;
        }
      }
      ////}
    }

    var resizeStack = [];

    function setFotoramaSize(forceResize, time, resetThumbs) {
      //if (wrapWidth && wrapHeight && (!wrapIsSetFLAG || forceResize)) {
      //if (!forceRatioWidthHeight) {
      getRatioWidthHeight(forceResize);
      //}
      if (!time) time = 0;
      var newDimensions = wrapWidth != wrapWidthLast || wrapHeight != wrapHeightLast || wrapRatio != wrapRatioLast;
      var needToResizeFLAG = forceResize || newDimensions;

      //////////console.log(wrapWidth, wrapHeight, wrapRatio);
      //////////console.log('needToResizeFLAG', needToResizeFLAG);

      if (needToResizeFLAG) {
        //////////////console.log('Resize!!!');

        if (!o().vertical) {
          wrapSize = wrapWidth;
          wrapSize2 = wrapHeight;
        } else {
          wrapSize = wrapHeight;
          wrapSize2 = wrapWidth;
        }

        wrap.add(imgFrame).animate({width:wrapWidth, height:wrapHeight}, time);

        // navPosition
        if (o().thumbs && o().vertical) {
          if (!o().thumbsOnRight) {
            wrap.animate({left:thumbsSize2}, time);
          } else {
            thumbs.animate({left:wrapWidth}, time);
          }
        }

        var _css;
        if (!o().touchStyle) {
          shaft.animate({width:wrapWidth, height:wrapHeight}, time);
        } else {
          shaftSize = (wrapSize + o().margin) * size - o().margin;
          shaftSize2 = wrapSize2;

          _css = {};
          _css[_size] = shaftSize;
          _css[_size2] = shaftSize2;
          shaft.animate(_css, time).data(_css).data({minPos:-(shaftSize - wrapSize), maxPos:0});
        }
        if (o().thumbs) {
          if (!o().vertical) {
            thumbs.animate({width:wrapWidth}, time);
          } else {
            thumbs.animate({height:wrapHeight}, time);
          }
          if (o().thumbsPreview && newDimensions) {
            setThumbsShaft(time, resetThumbs);
          }
          thumbs.css({visibility:'visible'});
        }

        if (ieFLAG && !o().vertical) {
          if (o().arrows) {
            arrs.animate({top:wrapHeight / 2}, time);
          }

          _css = {};
          _css[_pos2] = wrapSize2 / 2;
          stateIcon.animate(_css, time);
        }

        if (fotoramaState == 'loading' || fotoramaState == 'error') {
          _css = {};
          _css[_pos] = (o().touchStyle ? activeIndex : 0) * (wrapSize + o().margin) + wrapSize / 2;
          stateIcon.animate(_css, time);
        }

        if (activeImg) {
          if (o().touchStyle) {
            var pos = -activeIndex * (wrapSize + o().margin);
            animate(shaft, pos, 0);
          }
        }

        wrapIsSetFLAG = true;

        //if (forceResize) {
        //////////////console.log('setImgSize from setFotoramaSize', activeImg, activeIndex);
        var interval = 0;

        $(resizeStack).each(function () {
          clearTimeout(this);
        });
        resizeStack = [];

        //var timeout = setTimeout(function(){
        setImgSize(activeImg, activeIndex, time);
        //}, 0);
        //resizeStack.push(timeout);

        imgFrame.each(function (i) {
          if (i != activeIndex) {
            var thisImgFrame = $(this);
            var thisImg = thisImgFrame.data('img');
            if (thisImg) {
              thisImgFrame.data('img').css({visibility:'hidden'});
            }

            //Ресайзим порциями, чтобы не падали слабенькие Айпады
            var timeout = setTimeout(function () {
              ////////////////console.log(i);
              setImgSize(thisImgFrame, i);
            }, interval * 50 + 50);
            resizeStack.push(timeout);
            interval++;
          }
        });
        //}
      }
      //}

      wrapWidthLast = wrapWidth;
      wrapHeightLast = wrapHeight;
      wrapRatioLast = wrapRatio;
    }

    function flexRescale() {
      var srcKey = activeImg.data('srcKey');
      if (srcKey) {
        if (src[srcKey].imgWidth && src[srcKey].imgHeight && src[srcKey].imgRatio) {
          wrapWidth = src[srcKey].imgWidth;
          wrapWidthIdeal = wrapWidth;
          wrapHeight = src[srcKey].imgHeight;
          wrapHeightIdeal = wrapHeight;
          wrapRatio = src[srcKey].imgRatio;
          wrapRatioIdeal = wrapRatio;
          /*resizeFLAG = resize;
           forcedRatioFLAG = !resize;*/
          //////////console.log('flexRescale');
          setFotoramaSize(false, o().transitionDuration);
        }
      }
    }

    function setFotoramaState(state, index, time) {
      clearTimeout(stateIconPositionTimeout);
      function stateIconPosition() {
        ////////////console.log('stateIconPosition', o().touchStyle);
        if (!o().touchStyle) {
          index = 0;
        }
        stateIcon.css(_pos, index * (wrapSize + o().margin) + wrapSize / 2);
        stateIconPositionTimeout = setTimeout(function () {
          stateIcon.stop().show().fadeTo(0, 1);
        }, 100);
      }

      if (state == 'loading') {
        stateIconPosition();
        fotorama.addClass(F + '_loading').removeClass(F + '_error');
        if (!base64FLAG) {
          stateIcon.html('<span>&middot;&middot;&middot;</span>').css({backgroundImage:'none'});
        }
      } else if (state == 'error') {
        stateIconPosition();
        fotorama.addClass(F + '_error').removeClass(F + '_loading');
        if (!base64FLAG) {
          stateIcon.html('<span>?</span>').css({backgroundImage:'none'});
        }
      } else if (state == 'loaded') {
        fotorama.removeClass(F + '_loading ' + F + '_error');
        stateIcon.stop().fadeTo(Math.min(o__transitionDuration, time), 0, function () {
          stateIcon.hide();
        });
      }
      fotoramaState = state;
    }

    function dataOut() {
      return {index:activeIndex, src:src[activeIndex], img:activeImg[0], thumb:o().thumbs ? activeThumb[0] : null, caption:activeCaption};
    }

    function clearBackAnimate(block) {
      clearTimeout(block.data('backAnimate'));
    }

    function animate(block, pos, time, overPos) {
      var POS = isNaN(pos) ? 0 : Math.round(pos);
      clearBackAnimate(block);
      if (overPos) {
        POS = overPos;
        block.data({
          backAnimate:setTimeout(function () {
            animate(block, pos, Math.max(o__transitionDuration, time / 2));
          }, time)
        });
      } else if (o().onSlideStop) {
        setTimeout(function () {
          o().onSlideStop.call(fotorama[0], dataOut());
        }, time);
      }


      if (time) {
        clearTimeout(setAnimatingFLAG);
        animatingFLAG = true;
      }
      if (csstrFLAG) {
        block.css(getDuration(time));
        setTimeout(function () {
          block.css(getTranslate(POS, o().vertical));
        }, 1);
      } else {
        block.stop().animate(getTranslate(POS, o().vertical), time, o__bez);
      }

      setAnimatingFLAG = setTimeout(function () {
        animatingFLAG = false;
        if (o().flexible && block == shaft) {
          flexRescale();
        }
      }, time);
    }

    // Прокручиваем ленту превьюшек
    function slideThumbsShaft(time, x, auto) {
      if (thumbsShaftSize) {
        if (!auto || thumbsShaftSize < wrapSize) {
          thumbsShaftDraggedFLAG = false;
        }

        var thumbPos = activeThumb.position()[_pos];
        var thumbSize = activeThumb.data()[_size];
        //////////console.log('thumbSize', thumbSize);
        if (!thumbSize && thumbBorderVisibleFLAG) {
          thumbBorder.hide();
          thumbBorderVisibleFLAG = false;
        } else {
          if (!thumbBorderVisibleFLAG) {
            thumbBorder.show();
            thumbBorderVisibleFLAG = true;
          }
          if (thumbsShaftSize > wrapSize) {
            var thumbCenter = thumbPos + thumbSize / 2;
            var thumbPlace = wrapSize / 2;
            var index = thumb.index(activeThumb);
            var direction = index - activeThumbPrevIndex;
            if (thumbsShaftPos == undefined) {
              thumbsShaftPos = thumbsShaft.position()[_pos];
            }
            if (thumbsReadyFLAG && x && x > Math.max(36, o().thumbMargin * 2) && x < wrapSize - Math.max(36, o().thumbMargin * 2) && ((direction > 0 && x > thumbPlace * .75) || (direction < 0 && x < thumbPlace * 1.25))) {
              var i;
              if (direction > 0) {
                i = index + 1;
              } else {
                i = index - 1;
              }
              if (i < 0) {
                i = 0;
              } else if (i > size - 1) {
                i = size - 1;
              }
              if (index != i) {
                var nextThumb = thumb.eq(i);
                thumbCenter = nextThumb.position()[_pos] + nextThumb.data()[_size] / 2;
                thumbPlace = x;
              }
            }
            var minPos = -(thumbsShaftSize - wrapSize);
            var newPos = Math.round(-(thumbCenter - thumbPlace) + o().thumbMargin);

            if ((direction > 0 && newPos > thumbsShaftPos) || (direction < 0 && newPos < thumbsShaftPos)) {
              if (thumbPos + thumbsShaftPos < o().thumbMargin) {
                newPos = -(thumbPos - o().thumbMargin);
              } else if (thumbPos + thumbsShaftPos + thumbSize > wrapSize) {
                newPos = -(thumbPos * 2 - wrapSize + thumbSize + o().thumbMargin);
              } else {
                newPos = thumbsShaftPos;
              }
            }

            if (newPos <= minPos) {
              newPos = minPos;
            } else if (newPos >= o().thumbMargin) {
              newPos = o().thumbMargin;
            }
            thumbsShaft.data({minPos:minPos});
            setThumbsShadow(newPos);

            if (!thumbsShaftMouseDownFLAG) {
              thumbsShaft.data({maxPos:o().thumbMargin});
            }
          } else {
            newPos = wrapSize / 2 - thumbsShaftSize / 2;
            thumbsShaft.data({minPos:newPos});
            if (!thumbsShaftMouseDownFLAG) {
              thumbsShaft.data({maxPos:newPos});
            }
          }

          if (!thumbsShaftDraggedFLAG && !thumbsShaftMouseDownFLAG) {
            animate(thumbsShaft, newPos, time);
            if (thumbsShaftJerkFLAG) {
              thumbsShaftDraggedFLAG = true;
            }
            thumbsShaftPos = newPos;
          } else {
            thumbsShaftJerkFLAG = true;
          }

          var thumbBorderSize = thumbSize - (quirksFLAG ? 0 : o().thumbBorderWidth * 2);
          var thumbBorderPos = thumbPos;

          if (csstrFLAG) {
            thumbBorder.css(getDuration(time));
            setTimeout(function () {
              thumbBorder
                  .css(getTranslate(thumbBorderPos, o().vertical))
                  .css(_size, thumbBorderSize);
            }, 1);
          } else {
            if (!o().vertical) {
              thumbBorder.stop().animate({left:thumbBorderPos, width:thumbBorderSize}, time, o__bez);
            } else {
              thumbBorder.stop().animate({top:thumbBorderPos, height:thumbBorderSize}, time, o__bez);
            }
          }
        }
      }
    }

    function setThumbsShadow(pos) {
      if (o().shadows) {
        if (thumbsShaftSize > wrapSize) {
          // TODO: Тут могут возникнуть проблемы если превьюшек мало, но их дотащить до края (тени не будет, а должна). Передумать.
          thumbs.addClass(F + '__thumbs_shadow');
          if (pos <= thumbsShaft.data('minPos')) {
            thumbs.removeClass(F + '__thumbs_shadow_no-left').addClass(F + '__thumbs_shadow_no-right');
          } else if (pos >= o().thumbMargin) {
            thumbs.removeClass(F + '__thumbs_shadow_no-right').addClass(F + '__thumbs_shadow_no-left');
          } else {
            thumbs.removeClass(F + '__thumbs_shadow_no-left ' + F + '__thumbs_shadow_no-right');
          }
        }
      }
    }

    function setThumbsShaft(time, resetThumbs) {
      if ((!thumbsShaftGrabbingFLAG && !thumbsShaftMouseDownFLAG && !shaftMouseDownFLAG && !animatingFLAG) || resetThumbs) {
        if (!fullscreenFLAG) {
          setThumbsShadow();
        }
        slideThumbsShaft(time ? time : 0, false, !resetThumbs);
      }
    }

    function setImgSize(thisImgFrame, index, time) {
      //if (!index) index = imgFrame.index(thisImgFrame);
      var thisImg = thisImgFrame.data('img');
      ////////////////console.log(thisImg, index);
      var detachedFLAG = thisImgFrame.data('detached');
      time = time ? time : 0;
      //////////////console.log('setImgSize in', index, thisImg, detachedFLAG);
      if (thisImg && !detachedFLAG) {
        //////////////console.log('setImgSize work', index);
        var srcKey = thisImgFrame.data('srcKey');
        var thisImgWidth = src[srcKey].imgWidth;
        var thisImgHeight = src[srcKey].imgHeight;
        var thisImgRatio = src[srcKey].imgRatio;

        var thisImgTop = 0, thisImgLeft = 0;
        if (o().touchStyle) {
          thisImgFrame.css(_pos, index * (wrapSize + o().margin));
        }

        if (thisImgWidth != wrapWidth || thisImgHeight != wrapHeight || o().alwaysPadding || fullscreenFLAG) {
          var minPadding = 0;
          if (thisImgRatio / wrapRatio < .99 || thisImgRatio / wrapRatio > 1.01 || o().alwaysPadding || fullscreenFLAG) {
            minPadding = o().minPadding * 2;
          }

          //////console.log(thisImgRatio, wrapRatio);
          if (thisImgRatio >= wrapRatio) {
            if (!o().cropToFit) {
              thisImgWidth = Math.round(wrapWidth - minPadding) < thisImgWidth || o().zoomToFit || (fullscreenFLAG && src[index].imgRel) ? Math.round(wrapWidth - minPadding) : thisImgWidth;
              thisImgHeight = Math.round((thisImgWidth) / thisImgRatio);
              if (wrapHeight - thisImgHeight < 4) {
                thisImgHeight += wrapHeight - thisImgHeight;
              }
            } else {
              thisImgHeight = wrapHeight;
              thisImgWidth = Math.round((thisImgHeight) * thisImgRatio);
            }
          } else {
            if (!o().cropToFit) {
              thisImgHeight = Math.round(wrapHeight - minPadding) < thisImgHeight || o().zoomToFit || (fullscreenFLAG && src[index].imgRel) ? Math.round(wrapHeight - minPadding) : thisImgHeight;
              thisImgWidth = Math.round((thisImgHeight) * thisImgRatio);
              if (wrapWidth - thisImgWidth < 4) {
                thisImgWidth += wrapWidth - thisImgWidth;
              }
            } else {
              thisImgWidth = wrapWidth;
              thisImgHeight = Math.round((thisImgWidth) / thisImgRatio);
            }

          }
        }


        if (thisImgWidth && thisImgHeight) {
          var _css = {width:thisImgWidth, height:thisImgHeight};
          //thisImg.attr(_css);

          if (thisImgHeight != wrapHeight) {
            thisImgTop = Math.round((wrapHeight - thisImgHeight) / 2);
          }
          if (thisImgWidth != wrapWidth) {
            thisImgLeft = Math.round((wrapWidth - thisImgWidth) / 2);
          }
          _css.top = thisImgTop;
          _css.left = thisImgLeft;
          thisImg.animate(_css, time);
        }

        thisImg.css({visibility:'visible'});

        replaceSrc(thisImgFrame, index);
      } else if (thisImg && detachedFLAG) {
        //////////////console.log('set needToResize FLAG', index);
        thisImgFrame.data({needToResize:true});
      }
    }

    function loadImg(index, container, callback, type) {
      var thisImgFrame = imgFrame.eq(index);
      var thisImgNew = new Image();
      var $thisImgNew = $(thisImgNew);
      var _src = [];
      var _srcI = 0;
      var imgHref = src[index].imgHref;
      var imgSrc = src[index].imgSrc;
      var thumbSrc = src[index].thumbSrc;
      if (type == 'img') {
        if (imgHref) {
          _src.push(imgHref);
          _src.push(imgHref + '?' + timestamp);
        }
        if (imgSrc) {
          _src.push(imgSrc);
          _src.push(imgSrc + '?' + timestamp);
        }
        if (thumbSrc) {
          _src.push(thumbSrc);
          _src.push(thumbSrc + '?' + timestamp);
        }
      } else {
        if (thumbSrc) {
          _src.push(thumbSrc);
          _src.push(thumbSrc + '?' + timestamp);
        }
        if (imgSrc) {
          _src.push(imgSrc);
          _src.push(imgSrc + '?' + timestamp);
        }
        if (imgHref) {
          _src.push(imgHref);
          _src.push(imgHref + '?' + timestamp);
        }
      }

      function loadScope(imgSrcScope) {
        //////////////console.log('loadScope', imgSrcScope);

        function loadStart() {
          $thisImgNew.css({visibility:'hidden'});
          thisImgNew.src = imgSrcScope;

          if (_srcI == 0) {
            $thisImgNew.appendTo(container);

            if (type == 'thumb') {
              thumbsShaftSize += o__thumbSize + o().thumbMargin;
              thumbsShaft.css(_size, thumbsShaftSize).data(_size, thumbsShaftSize);
              container.css(_size, o__thumbSize).data(_size, o__thumbSize);
            }
          }
        }

        function plusThumb() {
          thumbsReadySize++;
          if (thumbsReadySize == size) {
            thumbsReadyFLAG = true;
          }
        }

        function loadFinish() {
          srcState[imgSrcScope] = 'loaded';
          $thisImgNew
              .unbind('error load')
              .error(function () {
                $thisImgNew[0].src = imgSrcScope;
                src[index].imgRel = false;
                setImgSize(imgFrame.eq(index), index);
                $thisImgNew.unbind('error');
              });
          container.trigger('load.' + F).data({state:'loaded'});

          setTimeout(function () {
            if (!src[imgSrcScope]) {
              src[imgSrcScope] = [];
              src[imgSrcScope].imgWidth = $thisImgNew.width();
              src[imgSrcScope].imgHeight = $thisImgNew.height();
              src[imgSrcScope].imgRatio = src[imgSrcScope].imgWidth / src[imgSrcScope].imgHeight;
            }

            callback(thisImgNew, src[imgSrcScope].imgWidth, src[imgSrcScope].imgHeight, src[imgSrcScope].imgRatio, imgSrcScope, index);
          }, 100);
          if (type == 'thumb') {
            plusThumb();
          }
        }

        function loadError(primary) {
          srcState[imgSrcScope] = 'error';
          $thisImgNew.unbind('error load');
          if (_srcI < _src.length && primary) {
            _srcI++;
            loadScope(_src[_srcI]);
          } else {
            container.trigger('error.' + F).data({state:'error'});
            if (type == 'thumb') {
              plusThumb();
            }
          }
        }

        if (!srcState[imgSrcScope]) {
          srcState[imgSrcScope] = 'loading';
          //thisImgFrame.data({loading: true});
          $thisImgNew
              .unbind('error load')
              .error(function () {
                loadError(true);
              })
              .load(loadFinish);
          loadStart();
        } else {
          function justWait() {
            if (srcState[imgSrcScope] == 'error') {
              loadError(false);
            } else if (srcState[imgSrcScope] == 'loaded') {
              loadFinish();
            } else {
              setTimeout(justWait, 100);
            }
          }

          loadStart();
          justWait();
        }
      }


      loadScope(_src[_srcI]);
    }

    function replaceSrc(newImg, index) {
      var thisImg = newImg.data('img');
      var normalSrc = newImg.data('srcKey');
      var bigSrc = src[index].imgRel;
      if (thisImg && bigSrc && bigSrc != normalSrc && !mobileFLAG) {
        ////////////console.log('replaceSrc call', index);
        var fullFLAG = thisImg.data('full');
        var detachedFLAG = newImg.data('detached');
        if (((fullscreenFLAG && !fullFLAG) || (!fullscreenFLAG && fullFLAG)) && !detachedFLAG) {
          ////////////console.log('need to replace src!!!', index, fullscreenFLAG ? 'увеличить' : 'уменьшить');

          thisImg[0].src = fullscreenFLAG ? bigSrc : normalSrc;

          ////////////console.log('smallSRC', newImg.data('srcKey'));

          thisImg.data({full:fullscreenFLAG});
        }
      }
    }

    // Загружаем, отрисовываем
    function loadDraw(newImg, index) {
      //if (!index) index = imgFrame.index(newImg);

      if (!newImg.data('wraped')) {
        //console.log('loadDraw', 'wrap', index);

        shaft.append(newImg.data({state:'loading'}));

        if (index != activeIndex && !o().touchStyle) {
          newImg.stop().fadeTo(0, 0);
        }

        function onLoad(thisImgNew, imgWidth, imgHeight, imgRatio, srcKey) {
          var $thisImgNew = $(thisImgNew);
          
          $thisImgNew.addClass(F + '__img');
          newImg.data({img:$thisImgNew, srcKey:srcKey});
          //////////////console.log($thisImgNew, newImg.data('img'), index);

          var justSetWrapSizeFLAG = false;

          ////////////console.log(index, wrapWidth, wrapHeight, wrapIsSetFLAG, wrapSizeFromFirstFLAG, o().startImg);

          if (((!wrapWidth || !wrapHeight) && !wrapIsSetFLAG) || (!wrapSizeFromFirstFLAG && index == o().startImg)) {
            //Задаём размер всей Фотораме по первой загруженной картинке, если он не задан в опциях
            ////////////console.log('Задаём размер всей Фотораме по первой загруженной картинке', index);
            wrapWidth = imgWidth;
            o().width = imgWidth;

            if (heightAutoFLAG) {
              wrapHeight = imgHeight;
              o().height = imgHeight;
            } else if (widthAutoFLAG) {
              var _wrapRatio = imgWidth / imgHeight;
              wrapWidth = Math.round(wrapHeight * _wrapRatio);
              o().width = wrapWidth;
            }
            justSetWrapSizeFLAG = true;
            wrapSizeFromFirstFLAG = index == o().startImg;
            //getRatioWidthHeight();
          }


          if (justSetWrapSizeFLAG || o().flexible) {
            setFotoramaSize(true);
          } else {
            //////////////console.log('setImgSize', index);
            setImgSize(newImg, index);
          }

          newImg.css({visibility:'visible'});
        }

        newImg.data({wraped:true, detached:false});

        loadImg(index, newImg, onLoad, 'img');

        if ((dataFLAG && img[index].html && img[index].html.length) || (o().html && o().html[index] && o().html[index].length)) {
          var html = img[index].html || o().html[index];
          newImg.append(html);
        }
      } else if (o().detachSiblings && newImg.data('detached')) {
        //console.log('loadDraw', 'attach', index);

        newImg.data({detached:false}).appendTo(shaft);
        if (newImg.data('needToResize')) {
          //////////////console.log('needToResize', index);
          setImgSize(newImg, index);
          newImg.data({needToResize:false});
        }
      }
    }

    function preloadSiblings(newImg, index) {
      //if (!index) index = imgFrame.index(newImg);
      var sizeToLoad = 0;
      var limitFLAG = false;
      var indexNew = [];
      var indexNewAll = [];
      var preload = fullscreenFLAG ? Math.min(1, o().preload) : o().preload;
      ////console.log('preload', preload);
      for (i = 0; i < preload * 2 + 1; i++) {
        var _indexNew = index - preload + i;
        if ((_indexNew >= 0 && _indexNew < size && !o().loop) || o().loop) {
          if (_indexNew < 0) _indexNew = size + _indexNew;
          if (_indexNew > size - 1) _indexNew = _indexNew - size;
          if (!imgFrame.eq(_indexNew).data('wraped') || imgFrame.eq(_indexNew).data('detached')) {
            sizeToLoad++;
            indexNew.push(_indexNew);
          }
          indexNewAll.push(_indexNew);
        } else {
          limitFLAG = true;
        }
      }

      if (sizeToLoad >= preload || limitFLAG) {
        $(indexNew).each(function (i) {
          // Порциями опять же
          var interval = i * 50;
          setTimeout(function () {
            loadDraw(imgFrame.eq(indexNew[i]), indexNew[i]);
          }, interval);
        });

        if (o().detachSiblings) {
          /*var leftEdge = index - preload;
           if (leftEdge < 0) leftEdge = 0;
           var rightEdge = index + preload + 1;
           if (rightEdge > size - 1) rightEdge = size - 1;*/
          imgFrame.filter(
              function (i) {
                //////////console.log($(this).data('state'));
                var $this = $(this);
                var isToLoadFLAG = false;
                for (var _i = 0; _i < indexNewAll.length && !isToLoadFLAG; _i++) {
                  if (indexNewAll[_i] == i) isToLoadFLAG = true;
                }
                return $this.data('state') != 'loading' && !isToLoadFLAG && index != i;
              }).data({detached:true}).detach();
        }
      }
    }

    function setArrows() {
      if ((activeIndex == 0 || size < 2) && !o().loop) {
        arrPrev.addClass(F + '__arr_disabled').data('disabled', true);
      } else {
        arrPrev.removeClass(F + '__arr_disabled').data('disabled', false);
      }
      if ((activeIndex == size - 1 || size < 2) && !o().loop) {
        arrNext.addClass(F + '__arr_disabled').data('disabled', true);
      } else {
        arrNext.removeClass(F + '__arr_disabled').data('disabled', false);
      }
    }

    function setHash() {
      document.location.replace('#' + (activeIndex + 1));
    }

    function bindPlayInterval(time) {
      if (!time) time = 0;
      // Сначала очищаю предыдущий таймаут, чтобы действие пользователя не пересеклось с автоматическим переходом
      clearTimeout(playingTimeout);
      // Назначаю новый таймаут
      playingTimeout = setTimeout(function () {
        if (playFLAG) {
          // Если воспроизведение включено, показываю следующий кадр
          fotorama.trigger('showimg', [activeIndex + 1, false, true]);
        }
      }, Math.max(o().autoplay, time * 2));
    }


    // Показываем картинки, выделяем тумбсы
    function showImg(newImg, e, x, reset, time, overPos, auto) {
      var prevActiveImg, prevActiveThumb;
      var prevIndex;
      var newIndex = imgFrame.index(newImg);

      imgFrame.each(function () {
        $(this).unbind('load.' + F + ' error.' + F);
      });


      if (typeof(time) != 'number') {
        if (reset) {
          time = 0;
        } else {
          time = o().transitionDuration;
        }
      }

      if (!reset && e && e.altKey) {
        time = time * 10;
      }

      function setCaption() {
        if (o().caption) {
          activeCaption = img[newIndex].caption ? img[newIndex].caption : img[newIndex].title;
          if (activeCaption) {
            caption.html(activeCaption).show();
          } else {
            caption.html('').hide();
          }
        }
      }

      var state = newImg.data('state');
      if (state == 'loading' || !state) {
        setFotoramaState('loading', newIndex, time);

        newImg.one('load.' + F, function () {
          setFotoramaState('loaded', newIndex, time);
          setCaption();
        });
        newImg.one('error.' + F, function () {
          setFotoramaState('error', newIndex, time);
          setCaption();
        });
      } else if (state == 'error') {
        setFotoramaState('error', newIndex, time);
      } else if (state != fotoramaState) {
        setFotoramaState('loaded', newIndex, 0);
      }
      setCaption();

      if (activeImg) {
        prevActiveImg = activeImg;
        prevIndex = activeIndex;
        if (o().thumbs) {
          prevActiveThumb = activeThumb;
        }
      } else {
        prevActiveImg = imgFrame.not(newImg);
        if (o().thumbs) {
          prevActiveThumb = thumb.not(thumb.eq(newIndex));
        }
      }
      if (o().thumbs) {
        activeThumb = thumb.eq(newIndex);
        if (prevIndex) {
          activeThumbPrevIndex = prevIndex;
        }
        prevActiveThumb
            .removeClass(F + '__thumb_selected')
            .data('disabled', false);
        activeThumb
            .addClass(F + '__thumb_selected')
            .data('disabled', true);
      }

      function setActiveClass() {
        if (o().shadows || !o().touchStyle) {
          prevActiveImg.removeClass(F + '__frame_active');
          newImg.addClass(F + '__frame_active');
        }
      }

      if (o().thumbs && o().thumbsPreview && (prevIndex != newIndex || reset)) {
        slideThumbsShaft(time, x);
      }

      if (o().touchStyle) {
        var pos = -(newIndex) * (wrapSize + o().margin);
        setActiveClass();
        animate(shaft, pos, time, overPos);
      } else {
        function crossFade(error) {
          if (prevIndex != newIndex || reset) {
            var inTime = time;
            var outTime = 0;
            if (error) {
              inTime = 0;
              outTime = time;
            }
            imgFrame.not(prevActiveImg.stop()).stop().fadeTo(0, 0);
            setTimeout(function () {
              setActiveClass();
              newImg.stop().fadeTo(inTime, 1, function () {
                prevActiveImg.not(newImg).stop().fadeTo(outTime, 0, function () {
                  if (o().flexible) {
                    flexRescale();
                  }
                });
              });
            }, 10);
          }
        }

        if (state == 'loaded') {
          crossFade();
        } else if (state == 'error') {
          crossFade(true);
        } else {
          newImg.one('load.' + F, function () {
            crossFade();
          });
          newImg.one('error.' + F, function () {
            crossFade(true);
          });
        }
      }

      activeImg = newImg;
      activeIndex = newIndex;

      if (o().hash) {
        setHash();
      }


      if (playFLAG && !auto && o().stopAutoplayOnAction) {
        playFLAG = false;
      }

      bindPlayInterval(time);

      var data = dataOut();

      fotorama.data(data);

      if (o().arrows) {
        setArrows();
      }

      var readyFLAG = newImg.data('wraped');

      clearTimeout(loadTimeout);
      loadTimeout = setTimeout(function () {
        if (!readyFLAG && newIndex != o().startImg) {
          loadDraw(newImg, newIndex);
          if (o().onShowImg) {
            o().onShowImg.call(fotorama[0], data, auto);
          }
        }
        preloadSiblings(newImg, newIndex);
      }, time + 10);

      if (readyFLAG || newIndex == o().startImg) {
        loadDraw(newImg, newIndex);
        if (o().onShowImg) {
          o().onShowImg.call(fotorama[0], data, auto);
        }
      }
    }

    showImg(imgFrame.eq(o().startImg), false, false, true, false, false, true);

    if (wrapWidth && wrapHeight) {
      wrapSizeFromFirstFLAG = true;
      setFotoramaSize();
    }


    if (o().thumbs && o().thumbsPreview) {
      loadThumb(0);
    }

    if (o().thumbs) {
      if (o().dotColor && !o().thumbsPreview) {
        // Если переназначен цвет тумбсов
        thumb.children().css({backgroundColor:o().dotColor});
      }

      if (o().navBackground) {
        // Если переназначен фон под тумбсами или превьюшками
        thumbs.css({background:o().navBackground});
      }

      if (o().thumbsPreview) {
        if (o().thumbBorderColor) {
          // Если переназначен цвет рамочки вокруг активной превьюшки
          thumbBorder.css({borderColor:o().thumbBorderColor});
        }
      }
    }

    if (o().background) {
      // Если переназначен цвет фона
      wrap.add(imgFrame).css({background:o().background});
    }

    if (o().arrowsColor && o().arrows) {
      // Если переназначен цвет стрелок
      arrs.css({color:o().arrowsColor});
    }

    function callShowImg(delta, e) {
      e.stopPropagation();
      e.preventDefault();
      var indexNew = activeIndex + delta;
      if (indexNew < 0) {
        indexNew = o().loop ? size - 1 : 0;
      }
      if (indexNew > size - 1) {
        indexNew = o().loop ? 0 : size - 1;
      }

      showImg(imgFrame.eq(indexNew), e);
    }

    var resizeTimeout = false;

    function rescale() {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(function () {
        setFotoramaSize();
      }, 50);
    }

    function bindrescale() {
      if (!bindedRescaleFLAG) {
        $window.bind('resize', rescale);
        if (touchFLAG) {
          window.addEventListener('orientationchange', rescale, false);
        }
        bindedRescaleFLAG = true;
      }
    }

    bindrescale();

    // Биндим хендлеры
    fotorama.bind('dblclick', clearSelection);
    fotorama.bind('showimg', function (e, index, time, auto) {
      if (typeof(index) != 'number') {
        if (index == 'next') {
          index = activeIndex + 1;
        } else if (index == 'prev') {
          index = activeIndex - 1;
        } else if (index == 'first') {
          index = 0;
        } else if (index == 'last') {
          index = size - 1;
        } else {
          index = activeIndex;
          auto = true;
        }
      }

      if (index > size - 1) {
        index = 0
      }
      if (!o().touchStyle || !shaftMouseDownFLAG) {
        ////console.log(auto);
        showImg(imgFrame.eq(index), e, false, false, time, false, auto);
      }
    });

    fotorama.bind('play', function (e, interval) {
      playFLAG = true;
      interval = Number(interval);
      if (!isNaN(interval)) {
        o().autoplay = interval;
      }
      bindPlayInterval(o__transitionDuration);
    });

    fotorama.bind('pause', function () {
      playFLAG = false;
    });


    fotorama.bind('rescale', function (e, width, height, ratio, time) {
      setWidthAndHeight(width, height, ratio);
      wrapRatio = wrapWidth / wrapHeight;
      wrapRatioForced = wrapRatio;
      forcedRatioFLAG = !resizeFLAG;
      //////////console.log('forcedRatioFLAG', forcedRatioFLAG);
      time = Number(time);
      if (isNaN(time)) time = 0;
      setFotoramaSize(false, time);
    });

    fotorama.bind('fullscreenopen', function () {
      scrollTop = $window.scrollTop();
      scrollLeft = $window.scrollLeft();

      fullscreenFLAG = true;
      if (fullscreenIcon) {
        fullscreenIcon.trigger('mouseleave', true);
      }

      $window.scrollTop(0);
      $html.add($body).addClass('fullscreen');//.css({backgroundColor: o().background});
      fotorama.addClass(F + '_fullscreen');

      if (ie6FLAG || mobileFLAG) {
        fotorama.appendTo($body).addClass(F + '_fullscreen_quirks');
      }

      if (o().caption && !o().caption != 'overlay') {
        caption.appendTo(wrap);
      }

      //rfs.call(fotorama[0]);

      bindrescale();
      if (activeImg) {
        showImg(activeImg, false, false, true, 0, false, true);
      }
      setFotoramaSize(false, false, true);
    });

    fotorama.bind('fullscreenclose', function () {
      fullscreenFLAG = false;
      if (fullscreenIcon) {
        fullscreenIcon.trigger('mouseleave', true);
      }
      $html.add($body).removeClass('fullscreen');//.css({backgroundColor: ''});
      fotorama.removeClass(F + '_fullscreen');

      if (ie6FLAG || mobileFLAG) {
        fotorama.appendTo(outer).removeClass(F + '_fullscreen_quirks');
      }

      if (o().caption && !o().caption != 'overlay') {
        caption.appendTo(captionOuter);
      }

      $window.scrollTop(scrollTop);
      $window.scrollLeft(scrollLeft);

      if (!resizeFLAG) {
        wrapWidth = o().width;
        wrapHeight = o().height;
      }
      if (activeImg) {
        showImg(activeImg, false, false, true, 0, false, true);
      }
      if (!o().flexible) {
        setFotoramaSize(false, false, true);
      } else {
        flexRescale();
      }
    });

    $document.bind('keydown', function (e) {
      if (fullscreenFLAG) {
        if (e.keyCode == 27 && !o().fullscreen) {
          fotorama.trigger('fullscreenclose');
        } else if (e.keyCode == 39 || e.keyCode == 40) {
          fotorama.trigger('showimg', activeIndex + 1);
        } else if (e.keyCode == 37 || e.keyCode == 38) {
          fotorama.trigger('showimg', activeIndex - 1);
        }
      }
    });

    if (o().thumbs) {
      // Клик по тумбсам
      function onThumbClick(e) {
        e.stopPropagation();
        var thisThumb = $(this);
        if (!thisThumb.data('disabled')) {
          var i = thumb.index($(this));
          var x = e[_coo] - thumbs.offset()[_pos];
          showImg(imgFrame.eq(i), e, x);
        }
      }

      thumb.bind('click', onThumbClick);
    }

    if (o().arrows) {
      // Клик по стрелочкам, если они включены
      arrPrev.bind('click', function (e) {
        if (!$(this).data('disabled')) {
          callShowImg(-1, e);
        }
      });
      arrNext.bind('click', function (e) {
        if (!$(this).data('disabled')) {
          callShowImg(+1, e);
        }
      });
    }

    if (!o().touchStyle && !touchFLAG && o().pseudoClick) {
      // Клик по картинке, если отключён режим таскания
      wrap.bind('click', function (e) {
        var forwardFLAG = e[_coo] - wrap.offset()[_pos] >= wrapSize / 2;
        if (o().onClick) {
          var _onClick = o().onClick.call(fotorama[0], dataOut());
        }
        if (_onClick !== false) {
          if ((!e.shiftKey && forwardFLAG && o().arrows) || (e.shiftKey && !forwardFLAG && o().arrows) || (!o().arrows && !e.shiftKey)) {
            // Если клик без шифта
            callShowImg(+1, e);
          } else {
            // Если с шифтом
            callShowImg(-1, e);
          }
        }
      });
    }

    if (fullscreenIcon) {
      fullscreenIcon
          .bind('click', function (e) {
        e.stopPropagation();
        fotorama.trigger(fullscreenFLAG ? 'fullscreenclose' : 'fullscreenopen');
      })
          .bind('mouseenter mouseleave', function (e, stopPropagation) {
            if (stopPropagation) {
              e.stopPropagation();
            }
            fullscreenIcon[e.type == 'mouseenter' ? 'addClass' : 'removeClass'](F + '__fsi_hover');
          });
    }

    if (o().fullscreen) {
      fotorama.trigger('fullscreenopen');
    }

    if (o().touchStyle || touchFLAG || (o().thumbs && o().thumbsPreview)) {
      function touch(el, mouseDown, mouseMove, mouseUp) {
        var elPos,
            coo,
            coo2,
            downPos,
            downPos2,
            downElPos,
            downTime,
            moveCoo = [],
            moveTime,
            directionLast,
            upTime,
            upTimeLast = 0;

        var movableFLAG = false;
        var checkedDirectionFLAG = false;
        var limitFLAG = false;

        function onMouseDown(e) {
          if ((touchFLAG || e.which < 2) && activeImg) {
            function act() {
              downTime = new Date().getTime();
              downPos = coo;
              downPos2 = coo2;
              moveCoo = [
                [downTime, coo]
              ];

              clearBackAnimate(el);
              if (csstrFLAG) {
                el.css(getDuration(0));
              } else {
                el.stop();
              }
              elPos = el.position()[_pos];
              el.css(getTranslate(elPos, o().vertical));
              downElPos = elPos;

              mouseDown();
            }

            if (!touchFLAG) {
              coo = e[_coo];
              e.preventDefault();
              act();
              $document.mousemove(onMouseMove);
              $document.mouseup(onMouseUp);
            } else if (touchFLAG && e.targetTouches.length == 1) {
              coo = e.targetTouches[0][_coo];
              coo2 = e.targetTouches[0][_coo2];
              act();
              el[0].addEventListener('touchmove', onMouseMove, false);
              el[0].addEventListener('touchend', onMouseUp, false);
            } else if (touchFLAG && e.targetTouches.length > 1) {
              return false;
            }
          }
        }

        function onMouseMove(e) {
          function act() {
            e.preventDefault();

            moveTime = new Date().getTime();
            moveCoo.push([moveTime, coo]);

            var pos = downPos - coo;
            elPos = downElPos - pos;

            if (elPos > el.data('maxPos')) {
              elPos = Math.round(elPos + ((el.data('maxPos') - elPos) / 1.5));
              limitFLAG = 'left';

            } else if (elPos < el.data('minPos')) {
              elPos = Math.round(elPos + ((el.data('minPos') - elPos) / 1.5));
              limitFLAG = 'right';
            } else {
              limitFLAG = false;
            }

            if (o().touchStyle) {
              el.css(getTranslate(elPos, o().vertical));
            }

            mouseMove(elPos, pos, limitFLAG);
          }

          if (!touchFLAG) {
            coo = e[_coo];
            act();
          } else if (touchFLAG && e.targetTouches.length == 1) {
            coo = e.targetTouches[0][_coo];
            coo2 = e.targetTouches[0][_coo2];

            if (!checkedDirectionFLAG) {
              if (Math.abs(coo - downPos) - Math.abs(coo2 - downPos2) >= -5) {
                movableFLAG = true;
                e.preventDefault();
                checkedDirectionFLAG = true;
              } else if (Math.abs(coo2 - downPos2) - Math.abs(coo - downPos) >= -5) {
                movableFLAG = 'prevent';
                checkedDirectionFLAG = true;
              }
            } else if (movableFLAG === true) {
              act();
            }
          }
        }

        function onMouseUp(e) {
          if (!touchFLAG || !e.targetTouches.length) {
            if (!touchFLAG) {
              $document.unbind('mouseup');
              $document.unbind('mousemove');
            } else {
              el[0].removeEventListener('touchmove', onMouseMove, false);
              el[0].removeEventListener('touchend', onMouseUp, false);
            }

            upTime = new Date().getTime();
            var dirtyLeft = -elPos;

            var _backTimeIdeal = upTime - o__dragTimeout;
            var _diff, _diffMin, backTime, backCoo;
            for (i = 0; i < moveCoo.length; i++) {
              _diff = Math.abs(_backTimeIdeal - moveCoo[i][0]);

              if (i == 0) {
                _diffMin = _diff;
                backTime = upTime - moveCoo[i][0];
                backCoo = moveCoo[i][1];
              }
              if (_diff <= _diffMin) {
                _diffMin = _diff;
                backTime = moveCoo[i][0];
                backCoo = moveCoo[i][1];
              }
            }

            var posDiff = backCoo - coo;
            var direction = posDiff >= 0;
            var timeDiff = upTime - backTime;
            var isSwipe = timeDiff <= o__dragTimeout;
            var timeFromLast = upTime - upTimeLast;
            var sameDirection = direction === directionLast;

            mouseUp(dirtyLeft, timeDiff, isSwipe, timeFromLast, sameDirection, posDiff, e, movableFLAG);

            upTimeLast = upTime;
            directionLast = direction;

            movableFLAG = false;
            checkedDirectionFLAG = false;
          }
        }

        if (!touchFLAG) {
          el.mousedown(onMouseDown);
        } else {
          el[0].addEventListener('touchstart', onMouseDown, false);
        }
      }
    }

    if (o().touchStyle || touchFLAG) {
      var clickPreventedFLAG = false;

      function shaftOnMouseDown() {
        shaftMouseDownFLAG = true;
      }

      function shaftOnMouseMove(pos, posDiff, limitFLAG) {
        clearTimeout(setShaftGrabbingFLAGTimeout);

        if (!shaftGrabbingFLAG) {
          if (o().shadows) {
            wrap.addClass(F + '__wrap_shadow');
          }
          if (!touchFLAG) {
            shaft.addClass(F + '__shaft_grabbing');
          }
          shaftGrabbingFLAG = true;
        }

        if (o().shadows) {
          if (limitFLAG) {
            var antiLimit = limitFLAG == 'left' ? 'right' : 'left';
            wrap
                .addClass(F + '__wrap_shadow_no-' + limitFLAG)
                .removeClass(F + '__wrap_shadow_no-' + antiLimit);
          } else {
            if (o().shadows) {
              wrap.removeClass(F + '__wrap_shadow_no-left ' + F + '__wrap_shadow_no-right');
            }
          }
        }

        if (Math.abs(posDiff) >= 5 && !clickPreventedFLAG) {
          // Отменяем клик по ссылкам!
          clickPreventedFLAG = true;
          $('a', wrap).bind('click', preventClick);
        }

      }

      function shaftOnMouseUp(dirtyLeft, timeDiff, isSwipe, timeFromLast, sameDirection, posDiff, e, movableFLAG) {
        shaftMouseDownFLAG = false;
        setShaftGrabbingFLAGTimeout = setTimeout(function () {
          if (!touchFLAG && o().arrows) {
            wrapLeave();
          }
          // Разрешаем клик по ссылкам!
          clickPreventedFLAG = false;
          $('a', wrap).unbind('click', preventClick);
        }, o__dragTimeout);

        if (!touchFLAG) {
          shaft.removeClass(F + '__shaft_grabbing');
        }

        if (o().shadows) {
          wrap.removeClass(F + '__wrap_shadow');
        }

        var forceLeft = false;
        var forceRight = false;

        var $target, a;

        if (o().html) {
          $target = $(e.target);
          a = $target.filter('a');
          if (!a.length) {
            a = $target.parents('a');
          }
        }

        if (o().touchStyle) {
          if (shaftGrabbingFLAG) {
            if (isSwipe) {
              if (posDiff <= -10) {
                forceLeft = true;
              } else if (posDiff >= 10) {
                forceRight = true;
              }
            }

            var time = o__transitionDuration;

            var index = Math.round(dirtyLeft / (wrapSize + o().margin));

            if (forceLeft || forceRight) {
              posDiff = -posDiff;
              var speed = posDiff / timeDiff;
              var virtualPos = Math.round(-dirtyLeft + speed * 250);
              var newPos, maxPos, overPos;
              //animate(shaft, virtualPos, o().transitionDuration);
              var outFactor = .03;
              if (forceLeft) {
                index = Math.ceil(dirtyLeft / (wrapSize + o().margin)) - 1;
                newPos = -index * (wrapSize + o().margin);
                if (virtualPos > newPos) {
                  overPos = Math.abs(virtualPos - newPos);
                  time = Math.abs(time / ((speed * 250) / (Math.abs(speed * 250) - overPos * (1 - outFactor))));
                  overPos = newPos + overPos * .03;
                }
              } else if (forceRight) {
                index = Math.floor(dirtyLeft / (wrapSize + o().margin)) + 1;
                newPos = -index * (wrapSize + o().margin);
                if (virtualPos < newPos) {
                  overPos = Math.abs(virtualPos - newPos);
                  time = Math.abs(time / ((speed * 250) / (Math.abs(speed * 250) - overPos * (1 - outFactor))));
                  overPos = newPos - overPos * outFactor;
                }
              }
            }
            if (index < 0) {
              index = 0;
              overPos = false;
              time = o__transitionDuration;
            }
            if (index > size - 1) {
              index = size - 1;
              overPos = false;
              time = o__transitionDuration;
            }
            showImg(imgFrame.eq(index), e, false, false, time, overPos);
          } else if (o().html && a.length) {
            return false;
          } else {
            if (o().onClick && movableFLAG != 'prevent') {
              var _onClick = o().onClick.call(fotorama[0], dataOut());
            }

            if (_onClick !== false && o().pseudoClick && !touchFLAG && timeDiff < o__dragTimeout) {
              var forwardFLAG = e[_coo] - wrap.offset()[_pos] >= wrapSize / 2;
              if ((!e.shiftKey && forwardFLAG && o().arrows) || (e.shiftKey && !forwardFLAG && o().arrows) || (!o().arrows && !e.shiftKey)) {
                // Если клик без шифта
                callShowImg(+1, e);
              } else {
                // Если с шифтом
                callShowImg(-1, e);
              }
            } else {
              showImg(activeImg, e, false, false, false, false, true);
            }
          }
        } else {
          if (posDiff == 0 && o().html && a.length) {
            return false;
          } else if (posDiff >= 0) {
            callShowImg(+1, e);
          } else if (posDiff < 0) {
            callShowImg(-1, e);
          }
        }

        shaftGrabbingFLAG = false;
      }

      touch(shaft, shaftOnMouseDown, shaftOnMouseMove, shaftOnMouseUp);

      if (o().touchStyle && o().thumbs && o().thumbsPreview) {
        var thumbClickUnbindedFLAG = false;

        function thumbsShaftOnMouseDown() {
          thumbsShaftMouseDownFLAG = true;
          thumbsShaftDraggedFLAG = true;
        }

        function thumbsShaftOnMouseMove(pos, posDiff) {
          if (!thumbsShaftGrabbingFLAG && Math.abs(posDiff) >= 5) {
            thumb.unbind('click', onThumbClick);
            thumbClickUnbindedFLAG = true;
            clearTimeout(setThumbsShaftGrabbingFLAGTimeout);
            thumbsShaftGrabbingFLAG = true;
//						if (!touchFLAG) {
//							thumbsShaft.addClass(F+'__thumbs-shaft_grabbing');
//						}
          }

          setThumbsShadow(pos);
        }

        function thumbsShaftOnMouseUp(dirtyLeft, timeDiff, isSwipe, timeFromLast, sameDirection, posDiff, e) {
          thumbsShaftMouseDownFLAG = false;
          thumbsShaftGrabbingFLAG = false;
//					if (!touchFLAG) {
//						thumbsShaft.removeClass(F+'__thumbs-shaft_grabbing');
//					}
          setThumbsShaftGrabbingFLAGTimeout = setTimeout(function () {
            if (thumbClickUnbindedFLAG) {
              thumb.bind('click', onThumbClick);
              thumbClickUnbindedFLAG = false;
            }
          }, o__dragTimeout);


          dirtyLeft = -dirtyLeft;

          var newPos = dirtyLeft;
          var overPos;
          var time = o__transitionDuration * 2;

          if (thumbsShaftJerkFLAG && thumbsShaftGrabbingFLAG) {
            slideThumbsShaft(0, false, false);
            thumbsShaftJerkFLAG = false;
          }

          if (dirtyLeft > thumbsShaft.data('maxPos')) {
            newPos = thumbsShaft.data('maxPos');
            time = time / 2;
          } else if (dirtyLeft < thumbsShaft.data('minPos')) {
            newPos = thumbsShaft.data('minPos');
            time = time / 2;
          } else {
            if (isSwipe) {
              posDiff = -posDiff;
              var speed = posDiff / timeDiff;
              newPos = Math.round(dirtyLeft + speed * 250);
              var outFactor = .04;
              if (newPos > thumbsShaft.data('maxPos')) {
                overPos = Math.abs(newPos - thumbsShaft.data('maxPos'));
                time = Math.abs(time / ((speed * 250) / (Math.abs(speed * 250) - overPos * (1 - outFactor))));
                newPos = thumbsShaft.data('maxPos');
                overPos = newPos + overPos * outFactor;
              } else if (newPos < thumbsShaft.data('minPos')) {
                overPos = Math.abs(newPos - thumbsShaft.data('minPos'));
                time = Math.abs(time / ((speed * 250) / (Math.abs(speed * 250) - overPos * (1 - outFactor))));
                newPos = thumbsShaft.data('minPos');
                overPos = newPos - overPos * outFactor;
              }
            }
          }

          if (e.altKey) {
            time = time * 10;
          }

          thumbsShaftPos = newPos;

          if (newPos != dirtyLeft) {
            animate(thumbsShaft, newPos, time, overPos);
            setThumbsShadow(newPos);
          }
        }

        touch(thumbsShaft, thumbsShaftOnMouseDown, thumbsShaftOnMouseMove, thumbsShaftOnMouseUp);
      }
    }
  }
})(jQuery);