!function($) {
  
  App.Modal = false;
  
  App.Datepicker = function() {
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      changeYear: true,
      changeMonth: true,
      showMonthAfterYear:true,
      yearRange: '1990:+5'
    });    
  };
  
  // imput append button click
  App.TriggerDatepicker = function() 
  {
    $('body').on('click', '.trigger-datepicker', function() {
       $(this).prev().datepicker('show')
    })
  };
  
  App.showNotification = function(message) 
  {
      var self = $('#loading-global');
      
      self.html(message).show();

      setTimeout(function() {
          self.hide();
          self.html('Working...');

      }, 4000)
      
  };  
  
  App.select = function(el) 
  {
    App.unselect()
    el.parents('.item').addClass('selected')
  };
  
  App.unselect = function() 
  {
    $('.items').find('.selected').removeClass('selected') 
    
  };
  
  App.disableFormButton = function() 
  {
    $('body').delegate('form', 'submit', function() {
      $(this).find('button').attr('disabled', true)
    })
  }
  
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
            
            var interval = (App.Message === undefined || App.Message === 'Working...' ? 100 : 6000 )
            //console.log(interval)
            setTimeout(function() {
                self.html('Working...');
                App.Message = "Working...";
                self.hide();
            }, interval)
        });
    
  };
  
  App.Dialog = function() 
  {
      $('body').delegate('a[rel*=dialog]', 'click', function() {
          
          $('.dialog').remove();
          
          var self = $(this);
          
          
          var elem = $('<div />', {'class': 'dialog', id: 'dialog_'+(new Date()).getTime(), title: self.attr('title')}).html('<p style = "width: 300px;text-align:center"><img src = "'+App.URL+'images/pie.gif" /></p>');
  
          elem.dialog({
              modal: false,
              width: 'auto',
              minWidth: 500,
              position:[Math.floor((window.innerWidth / 2)-150),  70],
              open: function(event, ui) {

                  elem.html($('<img />', {src:self.attr('href')}));
                  elem.dialog('option', 'position', [Math.floor(((window.innerWidth  - elem.width()) / 2)), window.pageYOffset]);
                  $('.ui-dialog').css('top',  window.pageYOffset + 70);
              }
          });
          
          return false;
      });	
      
      $('body').delegate('.close-dialog', 'click', function() {
          
          $('.ui-dialog-titlebar-close').trigger('click');
          
          return false;
      });     
  };
  
  App.enhanceChosen = function() 
  {
 
    
    $('.chosen-select-all').bind('click', function(e) {
        e.preventDefault();
        
        var select = $(this).parents('div:first').find('.chosen');
        
        select.find('option').attr('selected', true);
        
        select.trigger("liszt:updated");
    });       
    $('.chosen-cancel-all').bind('click', function(e) {
        e.preventDefault();
        
        var select = $(this).parents('div:first').find('.chosen');
        
        select.find('option').removeAttr('selected');
        
        select.trigger("liszt:updated");
    });      
  };
  
  App.Tooltip = function(option) 
  {
    //console.log('tootlip: ', option)
    $('[rel=tooltip]').tooltip(option||null);
  };
  
  App.PrettifyUpload = function() 
  {
    $('input[type=file]').prettifyUpload({'text': ''}); 
  };
  
  App.ModalElement = $('#delete-confirmation')
  
  App.ModalElement.on('hidden', function () {
    App.Modal = false
  })
  
  // removes an item from the content panel
  App.DeleteItem = function() 
  {
    
    $('body').delegate('.delete-item', 'click', function(e) 
    {
      var that = $(this),
          modal = App.ModalElement
      if (!App.Modal) {
        App.Modal = true;
        
        $('#delete-yes').attr('href', $(this).attr('href'));
        $('#the-item').html(that.data('modal-header'))
        
        //if (that.data('reload') === 'right') {
        //  $('#delete-yes').data('reload', 'right')
        //}
        
        $('#delete-yes').data('trigger', that.data('trigger'))
        $('#delete-yes').data('location', that.data('location'))
        
        //console.log($('#delete-yes').data('reload'))
        
        modal.modal();
        
      } else {
        
        //console.log(that)
        
        $.get(that.attr('href'), function() {
          
          if (that.data('trigger') === 'reload') {
            
            if (that.data('location') === 'r') App.Nav.reloadRightPanel()
            
            if (that.data('location') === 'l') App.Nav.reloadContetPanel()
            
            if (that.data('location') === 'b') {
              App.Nav.reloadRightPanel()
              App.Nav.reloadContetPanel()
            }
            
          } else {
  
            if (that.data('location') === 'r') App.Nav.CloseRightPanel()
            
            App.Nav.reloadContetPanel()
            
          }
          
          modal.modal('hide')
        })
      }
      
      e.preventDefault()
    })    
  };
  
  App.SwitchItem = function() 
  {
    $('body').delegate('.switch-item', 'click', function(e) 
    {
      
      var that = $(this)
      $.get(that.attr('href'), function() {
        
        App.Nav.reloadRightPanel()
      })
            
      e.preventDefault()
    })    
  }
  
  App.AutoHeight = function () 
  {
    //$('.right-side-scroll').css('height', $('body').height()-300)
    //console.log($('.sidebar-navigation-wrapper-right .well').height())
    $('.right-side-scroll').css('height', $('.sidebar-navigation-wrapper-right .well').height() - 200)
  }
  
  App.FilterGlobalGames = function() 
  {
    
    $('body').on('change', '#filter-games-select', function(e) {
      
      var self = $(this),
          val = self.val()
      
      if ($('#list-of-all-games').length){
        // game oldalon vagyunk
        var cont = $('#list-of-all-games')
        //cont.find('li').hide()
        cont.children().hide()
        
        cont.find('[data-id='+val+']').parents('li:first').show()
        
        window.location.hash = 'game/'+val
        
      } else {
        // barhol mashol vagyunk
        window.location = App.URL + "game/#edit/"+val
      }
      
      e.preventDefault()
    })
  };
  
  App.FilterGames = function (el) 
  {
    var filter = el.data('platform'),
        items = $('.games-list').children()
    
    el.parents('ul').find('.active').removeClass('active')
    el.parents('li:first').addClass('active')    
    
    //console.log('filter ', filter)
        
    if (filter === 'all') {
      
      items.show()
    } else {
      
      $.each(items, function (i, v) {
        
        var platforms = $(v).data('platforms')

        //console.log('platforms ', platforms)
        //console.log('in-array ', $.inArray(filter.toString(), platforms))
        
        !platforms || $.inArray(filter.toString(), platforms) === -1 ? $(v).hide() : $(v).show()
        
      })
    }
  }
  
  $.fn.serializeObject = function()
  {
      var o = {};
      var a = this.serializeArray();
      $.each(a, function() {
          if (o[this.name] !== undefined) {
              if (!o[this.name].push) {
                  o[this.name] = [o[this.name]];
              }
              o[this.name].push(this.value || '');
          } else {
              o[this.name] = this.value || '';
          }
      });
      return o;
  };  

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
  
  App.PreloadImages = function() 
  {
    var items = $('[data-src]')
    
    $.each(items, function(i, v) {
      //console.log('loading image: ', $(v).data('src'))
      
      if (!$(v).attr('src'))
        $(v).parent().spin()
      
      $(v).attr('src', $(v).data('src')).bind('load', function() {
        //console.log($(v), ' loaded')
        $(v).parent().find('.spinner').remove()

      })
      //$(v).prevAll('.spinner').remove()
    })
    //console.log('images loaded')
  }  
  
	$(function() 
	{
	  //App.SaveNewItem()
	  
	  //App.Editable()
	  
	  //App.Toggle()

    $(".chosen").chosen({
        no_results_text: "No results matched", 
    });
	  
    $('body').on('click', '.games-filter a', function(e) {
      
      App.FilterGames($(this));
      
      e.preventDefault()
    })	  
	  
	  App.PreloadImages()
	  
    $('#username').focus() 	  
	  
    App.FilterGlobalGames()
	  
    App.AutoHeight()
	  
	  App.SwitchItem()
	  
	  App.DeleteItem()
	  
    App.Tooltip()
    App.Datepicker()
    
    App.TriggerDatepicker()
    
    $('body').delegate('[data-unselect]', 'click', App.unselect)   
    
    App.disableFormButton()

	  
    App.Loader()  
    
    App.Dialog()
    
    App.enhanceChosen()
    
    //$('#fileupload').fileupload();
    
    $('i.w').parents('li').hover(
			function() { $(this).find('i.w').css('opacity', 1); }, 
			function() { $(this).find('i.w').css('opacity', 0.25); }
		)

    $("a[rel=popover]")
      .popover()
      .click(function(e) {
          e.preventDefault()
      });
    
		//prettyPrint() 
    
    $(".accordion").collapse('show')
		
		//$('.sidebar-navigation-wrapper-right .well').lionbars(); 
		
    $(window).hashchange( function(){
      if (window.location.hash.slice(1).length) {
        App.Crosspromo.LoadForGame(window.location.hash.slice(1))
        $('#crosspromo_base_game').val(window.location.hash.slice(1)).trigger('liszt:updated')
      }
    })
    
    $(window).hashchange();		
    		
  });
	
} (jQuery);