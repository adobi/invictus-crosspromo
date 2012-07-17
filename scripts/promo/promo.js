
!function($,sr){
 
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;
 
      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
 
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
 
          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
 
} (jQuery,'smartresize');

!function($) {

  $.fn.spin = function(opts) {
    this.each(function() {
      var $this = $(this),
          data = $this.data();

      if (data.spinner) {
        data.spinner.stop();
        delete data.spinner;
      }
      if (opts !== false) {
        data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
      }
    });
    return this;
  };

  $.subnav = function() 
  {
      
      var $win = $(window)
        , $nav = $('.subnav')
        , navTop = $('.subnav').length && $('.subnav').offset().top - 40
        , isFixed = 0
  
      processScroll()
  
      $win.on('scroll', processScroll)
  
      function processScroll() {
        var i, scrollTop = $win.scrollTop()
        if (scrollTop >= navTop && !isFixed) {
          isFixed = 1
          $nav.addClass('subnav-fixed')
        } else if (scrollTop <= navTop && isFixed) {
          isFixed = 0
          $nav.removeClass('subnav-fixed')
        }
      }   
  }
  App.Tooltip = function(option) 
  {
    $('[rel=tooltip]').tooltip(option||null);
  };
  
  App.Loader = function() 
  {
    $('#loading-global')
       .ajaxStart(function() {
          
    		$(this).show();
       })
       .ajaxStop(function() {
    		var self = $(this);
            //self.html('Done!');
            self.html(App.Message)
            
            self
              .css('left', ($(window).width() - self.width()) / 2)
            
            var interval = (App.Message === undefined || App.Message === 'Working...' ? 100 : 6000 )
            //console.log(interval)
            setTimeout(function() {
                self.html('Working...');
                App.Message = "Working...";
                self.hide();
            }, interval)
        });
    
  };  
  
  App.PreloadImages = function(items) 
  {
    $.each(items, function(i, v) {
      //console.log('loading image: ', $(v).data('src'))
      if (!$(v).attr('src'))
        //$(v).parent().spin()
      
      $(v).attr('src', $(v).data('src')+'?'+ new Date().getTime()).bind('load', function() {
        //console.log($(v), ' loaded')
        $(v).parent().find('.spinner').remove()

        $('.the-selected-game').addClass('selected-game').removeClass('the-selected-game')
        
      })
      //$(v).prevAll('.spinner').remove()
    })
    //console.log('images loaded')
  }
  window.App = App;
  
  App.CloseWindow = function() 
  {
    $('#close').on('click', function(e) {
      window.close()
      e.preventDefault()
    })
  }
  
  App.OpenPromoWindow = function() 
  {
    
    $('.open-window').on('click', function(e) {
      
      window.open($(this).attr('href'))
      
      e.preventDefault()
    })
  }
  
  App.Redirect = function() 
  {
    if ($('#redirect').length) {
      setTimeout(function() {
        window.location = $('#redirect').attr('href')
      }, 3000)
    }
  }
  
  App.TrackClick = function() 
  {
    $('body').on('click', '.item a', function() {
      var self = $(this),
          data = {
            'game_id':self.parents('.item:first').data('game-id'),
            'user_id': $('.items').data('user-id'),
            'type': self.parents('.item:first').data('type')
          },
          name = $('.csrf-form').find('[type=hidden]').attr('name'),
          value = $('.csrf-form').find('[type=hidden]').attr('value')
      
      data[name] = value
      
      //if (Unity) {
      //  Unity.call(self.attr('href'))
      //}
      
      $.post(App.URL+'promo/click', data, function(response) {})
    })
    
    return true;
  }
  
  $(function() 
  {
    //App.Redirect()
    
    App.PreloadImages($('.promo-item-image img'))
    
    
    App.TrackClick()
    
    $('body').on('click', '.toggle', function(e) {
      e.preventDefault();
      
      $(this).find('i').toggleClass('icon-minus').toggleClass('icon-plus')
      $(this).parent().next().toggle()
    }) 
    $('#ajax-loader-img, #loading-global').hide()
    $('body').on('click', '.crosspromo-tabs a', function() {
      $('#ajax-loader-img, #loading-global').show()
      //$(this).find('img').attr('src', App.URL+'img/ajax-loader.gif').css({'width':"15px", 'height':"15px"})
    })   
    
    App.Tooltip();
    
    //$(".chosen").chosen({
    //    no_results_text: "No results matched", 
    //});
        
    window.opener = window.window
    App.CloseWindow()
    App.OpenPromoWindow()
    $('.show').show()
    $('.dont-show').hide()
    
    $.subnav();

    /*
    $('.add-device-form').on('submit', function(e) {
      var self = $(this)
      self.find('.alert-success').hide()
      self.find('.alert-error').hide()
      $.post(self.attr('action'), self.serialize(), function(response) {
        response = $.parseJSON(response)
        //console.log(response)
        response.error && self.find('.alert-error').show().html(response.error)
        response.success && self.find('.alert-success').show().html(response.success)
      })
      
      e.preventDefault()
    })    
    */
  });
  
  $(window).unload( function () { $('#ajax-loader-img, #loading-global').show() } );  
} (jQuery);

