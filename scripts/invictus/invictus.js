
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
  
  App.showNotification = function(message) 
  {
      var self = $('#loading-global');
      self
        .css('left', ($(window).width() - self.width()) / 2)
      
      self.html(message).show();

      setTimeout(function() {
          self.hide();
          self.html('Working...');

      }, 4000)
      
  };   
  
  App.disableFormButton = function() 
  {
    $('body').delegate('form', 'submit', function() {
      $(this).find('button').attr('disabled', true)
    })
  }

  App.AjaxForm = function(form) 
  {
      var button = form.find('button')
      
      button.attr('disabled', true)
      $.post(form.attr('action'), form.serialize(), function(resp) {
        resp = $.parseJSON(resp);
        
        //console.log(resp)
        
        App.Message = resp.message;

        button.attr('disabled', false)
        
        if (resp.success) {
          
          form.find('input[type=text], textarea').val('')
          form.find('.btn-group a').removeClass('active')
        }
      })     
  };
  
  App.Subscribe = function()
  {
    $('#subscribe-form').on('submit', function(e) {
      App.AjaxForm($(this))
      e.preventDefault()     
    })
  }  

  App.SelectContact = function() 
  {
    $('body').on('click', '.btn-group.emails a', function() {
      
      $('input[name=email_id]').val($(this).data('email'))
    })
  };
  
  App.SendContactMail = function() 
  {
    $('.contact-message-form').on('submit', function(e) {
      App.AjaxForm($(this))
      e.preventDefault()     
    })
    
  };

  App.Carousel = function() 
  {
    App.hiddenTeaser = $('.teaser.hide').remove()
    
    $('#simple-carousel').on('slid', function() {
      var currentHero = $(this).find('.active')
      
      $('.teasers').prepend(App.hiddenTeaser.removeClass('hide'))
      
      $('.teaser[data-item='+currentHero.data('item')+']').addClass('hide')
      App.hiddenTeaser = $('.teaser.hide').remove()
      
      //App.PreloadImages($('.teasers [data-src]'));
      $('.teasers .spinner').remove()
      
    })
  };
  
  App.LoadGame = function() 
  {
    $('body').on('click', '.all-games a', function(e) {
      
      $('.all-games').find('.selected-game').removeClass('selected-game')
      
      $(this).parents('li:first').addClass('selected-game')
      
      $('#game-shortcut').load($(this).attr('href'), function() {
        App.Tooltip()
      })
      
      e.preventDefault();
    })
  };
  
  App.Filter = function (el, items) 
  {
    var filter = el.data('platform')
    
    el.parents('ul').find('.active').removeClass('active')
    el.parents('li:first').addClass('active')    
    
    //console.log('filter ', filter)
    
    if (!$('#simple-carousel-details-videos').is(':visible')) {
      
      //console.log($.data($('#image-carousel').elastislide()[0], 'elastislide'))
      //console.log($.data($('#video-carousel').elastislide()[0], 'elastislide'))
      
      // reset elastislide images 
      if ($('#image-carousel').length)
        $.data($('#image-carousel').elastislide()[0], 'elastislide').reset()
      
      // reset elastislide videos
      if ($('#video-carousel').length)
        $.data($('#video-carousel').elastislide()[0], 'elastislide').reset()
      
      var carousel = $('#simple-carousel-details-images'),
          carouselItems = [], elastslideItems = []
      //console.log('all items', items.length)    
      //console.log('platform', filter)
      if (filter === 'all') {
        
        //items.show()
      } else {
        if (filter) {
          
          $.each(items, function (i, v) {
            
            var platforms = $(v).data('platforms')
            
            !platforms || $.inArray(filter.toString(), platforms) === -1 ? $(v) : carouselItems.push($(v).data('item-id')) && elastslideItems.push($(v).data('item-id'))
            
          })
        }
      }
      //console.log('carousel ', carouselItems) 
      //console.log('elastislide ', elastslideItems)
      if (carouselItems.length && elastslideItems.length) {
        var hiddenCarousel = $('#hidden-simple-carousel-details-images'),
            hiddenItems = hiddenCarousel.find('.item[data-item-id]'),
            visibleCarousel = $('#simple-carousel-details-images .carousel-inner'),
            filteredItems = hiddenItems.filter(function(index){
              return $.inArray($(this).data('item-id'), carouselItems) !== -1
            }),

            hiddenElastislide = $('#hidden-es-carousel-images'),
            hiddenElastislideItems = hiddenElastislide.find('li'),
            visibleElastislide = $('#image-carousel .es-carousel ul'),
            filteredElastislideItems = hiddenElastislideItems.filter(function(index){
              return $.inArray($(this).data('item-id'), elastslideItems) !== -1
            })
        
        //console.log(filteredElastislideItems)
        if (!filteredItems.length || !filteredElastislideItems.length) return
        
        visibleCarousel.empty()
        visibleElastislide.empty()
        
        for (var i = 0; i < filteredItems.length; i++) {
          
          visibleCarousel.append($(filteredItems[i]).clone(true, true))
          
          visibleElastislide.append($(filteredElastislideItems[i]).clone(true, true))
        }
        visibleCarousel.find('.item:first').addClass('active')
        visibleElastislide.find('.thumbnail:first').addClass('selected-carousel-item')
        
        $.data($('#image-carousel').elastislide()[0], 'elastislide').destroy()
        
        $('#image-carousel').elastislide({
            imageW  : 110,
            border: 1,
            minItems	: 5,
            onClick: function(e) { $.trackevent().track($(e).find('a'));}
        });        
        
      } else {
        
        var hiddenCarousel = $('#hidden-simple-carousel-details-images'),
            hiddenItems = hiddenCarousel.find('.item').clone(true, true),
            visibleCarousel = $('#simple-carousel-details-images .carousel-inner')
            hiddenElastislide = $('#hidden-es-carousel-images'),
            hiddenElastislideItems = hiddenElastislide.find('li').clone(true, true),
            visibleElastislide = $('#image-carousel .es-carousel ul')
        
        visibleCarousel.empty()
        visibleCarousel.append(hiddenItems)
        //console.log(hiddenElastislideItems)
        visibleElastislide.empty()
        visibleElastislide.append(hiddenElastislideItems)

        visibleCarousel.find('.item:first').addClass('active')
        visibleElastislide.find('.thumbnail:first').addClass('selected-carousel-item')

        $.data($('#image-carousel').elastislide()[0], 'elastislide').destroy()
        
        $('#image-carousel').elastislide({
            imageW  : 110,
            border: 1,
            minItems	: 5,
            onClick: function(e) { $.trackevent().track($(e).find('a'));}
        });        

      }

      // reset carousel
      carousel.carousel(0).carousel('pause')
      
      //$('#simple-carousel-details-images').carousel('pause')
      
      App.PreloadImages(visibleCarousel.find('[data-src]'))
    }
    el.parents('li.dropdown.open').removeClass('open')
  }  

  App.SimpleFilter = function(el, items) 
  {
    var filter = el.data('platform')
    
    el.parents('ul').find('.active').removeClass('active')
    el.parents('li:first').addClass('active')    
    
    
    if (filter === 'all') {
      
      items.show()
    } else {
      if (filter) {
        
        $.each(items, function (i, v) {
          
          var platforms = $(v).data('platforms')
          
          !platforms || $.inArray(filter.toString(), platforms) === -1 ? $(v).hide() : $(v).show()
          
        })
      }
    }    
  }

  App.PlayVideo = function(code, callback)
  {
    if (!code) return;
  
    setTimeout(function() {
      $.get(App.URL+'pages/video/'+code, function(resp) {
        callback(resp)
        //carousel.carousel('pause')
      })
    }, 500)    
  }
  
  App.HandleSmallCarousel = function() 
  {
    $('body').on('click', '.carousel-item', function(e) {
      
      var self = $(this),
          type = self.data('type'),
          carousel = $('#simple-carousel-details-'+type)
          
      self.parents('ul:first').find('.selected-carousel-item').removeClass('selected-carousel-item')
      self.addClass('selected-carousel-item')
          
      carousel.carousel(self.parents('li:first').index())
      carousel.carousel('pause')
      if (type==="videos" && self.data('code')) {
        App.PlayVideo(self.data('code'), function(resp) {
          carousel.find('.active').html(resp)
          //carousel.carousel('pause')
        })
      }
      
      e.preventDefault()
    });
    
    $('#simple-carousel-details-videos .active').on('click', function() {
      var that = $(this)
      App.PlayVideo($('#videos .selected-carousel-item').data('code'), function(resp) {
        that.html(resp)
      })
    })
    
  }
  
  App.ReverseContentColumns = function () 
  {
    var w = $(window),
        c = $('[data-reversable]');
    
    //$('.debug').append(w.width() + ', ')
        
    if (!App.Reversed && w.width() < 1023) {
      
      c.children().each(function(i,child){c.prepend(child)})
      
      //if (!$('.top-nav').find('.dropdown').length) {
      //  $('.top-nav').append($('.more-games').html())
        //$('.top-nav').find('.all-games-dropdown-menu').hide()
      //  $('.more-games').hide()
      //}
      
      App.Reversed = true
    } else {
      if (App.Reversed) {
        c.children().each(function(i,child){c.prepend(child)})
        App.Reversed = false
        
        //if ($('.top-nav').find('.dropdown').length) {
        //  $('.top-nav').find('.dropdown').remove()
        //  $('.more-games').show()
        //}
        
        var jobList = $('.jobs-list-wrapper')
        jobList.length && jobList.is(':hidden') && jobList.show()
        
      }
    }
  }

  App.LoadFacebookSdk = function() 
  {
    if ($('#facebook-jssdk').length) $('#facebook-jssdk').remove();
    
    
    ;(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId="+$('body').data('app-id');
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));    
    
  }
  
  App.xhr
  App.LoadSocialWidgets = function() 
  {
    var elem = $('.facebook-widget'),
        type = elem.data('type'),
        size = 300,
        page = elem.data('page'),
        win = $(window)
        width = win.width()
    
    if (width <= 480) size = width - 50
    else if (width <= 768) size = width - 50
    else if (width <= 1023) size = width - 50
    else if (width < 1200) size = 280
    else size = 360

    $('.debug').html('widget size: ' + size + ' window width: ' + width)
    
    App.xhr && App.xhr.abort()
    if (type) {
      App.xhr = $.ajax({
          type: "GET",
          url: App.URL+'pages/widget/'+type+'/'+size+'/'+page,
          success: function(resp){
           elem.html(resp)
            App.LoadFacebookSdk()
            window.FB && window.FB.init({ status: true, cookie: true, xfbml: true });
            _ga.trackFacebook();
          }
      });
      
    }
  }
  
  App.ToggleFacebookCommnet = function() 
  {
    if ($(window).width() <= 1023) {
      $('#fb-comments-desktop').hide()
      $('#fb-comments-mobile').show()
    } else {
      $('#fb-comments-desktop').show()
      $('#fb-comments-mobile').hide()
    }
  }
  
  App.ImageInModal = function() 
  {
    /*
    $('body').on('click', '[rel="in-modal"]', function(e) {
      var modal = $('#image-in-modal'),
          self = $(this)
      console.log(modal)  
      modal.css({
          'margin-top': -(modal.outerHeight() / 2),
          'margin-left': -(modal.outerWidth() / 2)
      });  
      modal.find('img').attr('src', self.data('href'))
      $('#download-image').attr('href', self.data('href'))
      modal.modal()
      e.preventDefault()
    })
    */
  }
  
  App.VideoInModal = function() 
  {
    $('body').on('click', '[rel="in-modal"]', function(e) {
      var modal = $('#video-in-modal'),
          modalBody = modal.find('.modal-body'),
          modalTitle = modal.find('.modal-title'),
          self = $(this),
          detailsButton = self
                            .parents('.options:first')
                            .find('.view-game-details')
                            .clone()
                            .addClass('btn-large')
      
      $('#simple-carousel').carousel('pause')
      modal.find('.modal-footer').find('.btn-large').remove()
      modal.find('.modal-footer').append(detailsButton)
      detailsButton = modal.find('.modal-footer').find('.btn-large')
      detailsButton.attr('data-ga-label', detailsButton.attr('data-ga-label') + ' - Popup')
          
      modal.modal()
      modalBody.html('<h1 style="text-align:center">Loading...</h1>')
      $.getJSON(self.data('href'), function(response) {
        
        modalBody.html(response.embed_code)
        modalTitle.html(response.title)
        
        modal.css({
            'margin-top': -(modal.outerHeight() / 2),
            'margin-left': -(modal.outerWidth() / 2)
        });  
        //$('#view-details-from-video').attr('href', self.attr('href').replace('video', ''))
      })
      
      e.preventDefault()
    })    

    $('#video-in-modal').on('hidden', function () {
      $(this).find('.modal-body').empty()
      $('#simple-carousel').carousel('cycle')
    })
  }
  
  App.PreloadImages = function(items) 
  {
    $.each(items, function(i, v) {
      //console.log('loading image: ', $(v).data('src'))
      if (!$(v).attr('src'))
        $(v).parent().spin()
      
      $(v).attr('src', $(v).data('src')+'?'+ new Date().getTime()).bind('load', function() {
        //console.log($(v), ' loaded')
        $(v).parent().find('.spinner').remove()

        $('the-selected-game').addClass('selected-game').removeClass('the-selected-game')
        
      })
      //$(v).prevAll('.spinner').remove()
    })
    //console.log('images loaded')
  }
  window.App = App;
  
  $(function() 
  {
    
    App.PreloadImages($('.teasers [data-src], .all-games [data-src], .crosspromo [data-src]'))
    
    
    App.VideoInModal()
    
    //App.ImageInModal();
    
    //$("[rel=colorbox]").colorbox({slideshow:true});
      
    $(window).smartresize(function() {
      App.ReverseContentColumns()
      App.LoadSocialWidgets()
      App.ToggleFacebookCommnet()
    })
    
    App.LoadSocialWidgets()
    App.ReverseContentColumns()
    App.LoadFacebookSdk()
    App.ToggleFacebookCommnet()
    
    
    $('[data-pretty-file], input[type=file]').prettifyUpload({'text': 'Select a file'});
    $('.show').show()
    $('.dont-show').hide()
    
    $('a[data-toggle="tab"]').on('shown', function (e) {
      
      var active = $(e.target); // activated tab
      //console.log(active)
      if (active.data('carousel') === '.carousel-videos') {
        $('.games-filter').parents('.dropdown').hide()
        App.PlayVideo($('#videos .selected-carousel-item').data('code'), function(resp) {
          $('#simple-carousel-details-videos .active').html(resp)
        })
      } else {
        $('.games-filter').parents('.dropdown').show()
      }
      
      //$('.carousel-images, .carousel-videos').toggle()
      
      $('.carousel').hide()
      $(active.data('carousel')).show()
      
      $(active.attr('href')).find('.es-carousel li').show()
      
      $(active.attr('href')).find('.es-carousel-wrapper').elastislide({
          imageW  : 110,
          border: 1,
          minItems	: 5,
          onClick: function(e) { $.trackevent().track($(e).find('a')); }
      });  
      
      App.Filter($('.games-filter .active a'), $('#hidden-es-carousel-images .es-carousel li'));    
    });    
    
    $('body').on('click', '.games-filter a', function(e) {
      
      if ($('#hidden-es-carousel-images').length) {
        
        App.Filter($(this), $('#hidden-es-carousel-images .es-carousel li'));
      }
      
      if ($('.all-games').length) {
        App.SimpleFilter($(this), $('.all-games li'))
      }
      
      e.preventDefault()
    })    
    
    App.LoadGame()
    
    App.Carousel()
    
    App.SelectContact()
    
    App.SendContactMail()
    
    App.Tooltip()
    
    App.Loader()
    
    App.disableFormButton()
    
    App.Subscribe()
    
    $.subnav();
    
    $('.emails').button()
    
		$(".game img").fadeIn(500);
		
		$('#simple-carousel').carousel('cycle');
    
    $('#simple-carousel-details-images').carousel('pause')
    $('#simple-carousel-details-videos').carousel('pause')
    
    /*$('#images-fotorama, #videos-fotorama').fotorama({
      click: false,
      onClick: function(data) {
        //console.log($(data.img));
        
      },
      onShowImg: function(data) {
        //console.log(data)
      }
    })*/
    
    $('.carousel').on('slid', function(e) {
      //console.log($(this).find('.active'))
      var elem = $(this).find('.item.active')
      //console.log(elem.index())
      
      $.trackevent().track(elem.find('a'))
      
      $('.tab-pane.active .selected-carousel-item').removeClass('selected-carousel-item')
      $('.tab-pane.active').find('li:eq('+elem.index()+')').find('a').addClass('selected-carousel-item')
      
      if ($(this).is('.carousel-videos')) {
        App.PlayVideo($('#videos .selected-carousel-item').data('code'), function(resp) {
          $('#simple-carousel-details-videos .active').html(resp)
        })
      }
      
    }).on('slide', function(e) {
    })
    
    $('body').delegate('a[href=#]', 'click', function() {
      return false;
    });

    
    if($('#image-carousel').length) {
      $('#image-carousel').elastislide({
          imageW  : 110,
          border: 1,
          minItems	: 5,
          onClick: function(e) { $.trackevent().track($(e).find('a')); return true;}
      });     
      
    } else {
      if($('#video-carousel').length)
        $('#video-carousel').elastislide({
            imageW  : 110,
            border: 1,
            minItems	: 5,
            onClick: function(e) { $.trackevent().track($(e).find('a'));}
        });      
    }  

    App.HandleSmallCarousel()
    
    
    var isBig = 0;
    $('.bigger-font').on('click', function() {
      var normal = '13px', big = '16px', self = $(this);
      
      $('#container p').css('font-size', (isBig ? normal : big));
      
      if (!isBig) self.find('span').removeClass('icon-zoom-in').addClass('icon-zoom-out')
      else self.find('span').removeClass('icon-zoom-out').addClass('icon-zoom-in')
      
      isBig = 1-isBig;
      return false;
    });
    
    //$(".scrollable").scrollable();    
    
    $('body').delegate('#apply-for-the-job', 'click', function() {
      
      $('#job-application-form').toggle();
      
      return false;
    });
  });
  
} (jQuery);

