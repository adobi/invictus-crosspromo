!function($) 
{
  
  "use strict"
  
  var Nav = function(el, container)
  {
    if (el) {
    
      this.el = $(el)
      this.href = this.el.attr('href')
      
      this.type = this.el.data('type')
    }
    
    this.container = container || $('.sidebar-navigation-wrapper-right .well')
    //console.log(App.CurrentHref)
  }
  
  Nav.reloadContetPanel = function() 
  {
    App.Tooltip('hide')
    //console.log('reload content')
    //$('.left-side-nav .active').trigger('click')  
    $('.content-wrapper').load($('.left-side-nav .active a').attr('href'), function() {
      Nav.initContentPanel()
    });
  }
  
  Nav.CloseRightPanel = function() 
  {
    (new Nav()).closeRightPanel()
  }
  
  Nav.reloadRightPanel = function() 
  {
    //$('[rel=tooltip]').tooltip('hide')
    
    //console.log(App.CurrentHref)
    App.Tooltip('hide')  
    $('.sidebar-navigation-wrapper-right .well').load(App.CurrentHref, Nav.initRightPanel)
  }
  
  Nav.initRightPanel = function() 
  {
    //App.TriggerDatepicker()
    App.Datepicker()
    //App.PrettifyUpload()
    if ($('.fileupload').length) {
      $('.fileupload').each(function () {
          var that = $(this)
          //console.log(App.CurrentPlatform)
          //console.log(that)
          $(this).fileupload({
              dropZone: $(this),
          }).bind('fileuploadstop',  function() {
            
            App.CurrentPlatform = that.data('platform-id')
            $('.item.selected').find('.icon-picture').parent().trigger('click')
          });
      });      
    } else App.PrettifyUpload()
    
    App.Tooltip('hide')      
    App.Tooltip() 
    App.AutoHeight()
    App.enhanceChosen()  
    $('.sidebar-navigation-wrapper-right .controls:first').children(':first').focus()
    //console.log($('.items[data-platform-id='+App.CurrentPlatform+']'))
    $('.items[data-platform-id='+App.CurrentPlatform+']').prevAll('legend:first').find('.toggle-platform-images').trigger('click')
    
    if ($('.game-platforms').length) {
      
      //App.Games.loadPlatforms()
    }
  }
  
  Nav.initContentPanel = function() 
  {
    App.Tooltip('hide')
    
    //if ($(".contact-type-items" ).length) App.Contacts.sortable()     
  }

  Nav.buildRightPanelTemplate = function() 
  {
    $.getJSON(App.URL+'game/all', function(json) {
      
      App.Template.load('games/all.html', $('.right-side-scroll'), json, function() { App.Crosspromo && App.Crosspromo.DragAndDropGames(); App.Tooltip()  })
      
      App.Template.load('platforms/filter.html', $('.platforms-filter-bar'), json)
    })

  }
  
  Nav.prototype = {
    loadIntoRightPanel: function() 
    {
      $('[rel=tooltip]').tooltip('hide');      
      var that = this
      
      if ($('#list-of-all-games .btn-group').length) {
        $('#list-of-all-games .btn-group').find('.active').removeClass('active')
        that.el.addClass('active')
      }
      
      $.ajax({
        url: that.href, 
        type: that.type || 'GET',
        success: function(response) {
          
          //callback()
          
          if(that.el && that.el.data('trigger') === 'reload') {
            if (that.el.data('location') === 'r') {
              Nav.reloadRightPanel();
            }
          } else {
            that.container.html(response)
            Nav.initRightPanel()
          }
        }
      })
    },
    
    setHref: function(href) 
    {
      this.href = href
      
      return this
    },
        
    closeRightPanel: function() 
    {
      this.container.empty();
    },
    
    submitForm: function() 
    {
      var form = this.el,
          button = form.find('button')

      button.attr('disabled', true)
      
      $.post(form.attr('action'), form.serialize(), function(resp) {
        
        if (form.data('trigger') === 'back') {
          
          $('.prev-right-panel').trigger('click');
          
        } else if (button.data('trigger') === 'reload') {

          if (button.data('location') === 'r') {
            
            Nav.reloadRightPanel();
          }
          if (button.data('location') === 'b') {

            Nav.reloadContetPanel();
    
            Nav.reloadRightPanel();
          }
          if (button.data('location') === 'l') {

            Nav.reloadContetPanel();
          }

        } else {
          if (!button.data('noaction')) {
            
            Nav.reloadContetPanel();
    
            Nav.reloadRightPanel();
          }
        }
        
        if (resp !== 'Saved') {
          resp = $.parseJSON(resp)
          
          App.Message = resp.message
          
          if (resp.success) Nav.reloadRightPanel()
        } else {
          
          App.Message = resp;
          
        }
        button.attr('disabled', false)
      })
    },
    

  }
  
  $(function() 
  {
    //Nav.InitPartials()
    
    Nav.buildRightPanelTemplate()
    
    $('body').on('reload.content', Nav.reloadContetPanel)
    
    $('body').delegate('.left-side-nav a', 'click', function(e) {
      
      //window.loaction.href = $(this).attr('href')
      
      //(new Nav(this, $('.content-wrapper'))).loadIntoPanel();
      
      //e.preventDefault()
    })
        
    $('body').delegate('[data-ajax-link]', 'click', function(e) {
      
      (new Nav(this)).loadIntoRightPanel();
      
      App.CurrentHref = $(this).attr('href')
      
      e.preventDefault()
    })
    
    $('body').delegate('[data-contet-ajax-link]', 'click', function(e) {
      
      $.get($(this).attr('href'), function() {
        Nav.reloadContetPanel()
      })
      
      e.preventDefault()
    })
    
    $('body').delegate('[data-close-right]', 'click', function(e) {
      
      (new Nav(this)).closeRightPanel();
      
      e.preventDefault()
    })    

    $('body').delegate('[data-ajax-form]', 'submit', function(e) {
      (new Nav(this)).submitForm()
      
      //$('.left-side-nav .active').trigger('click')
      
      e.preventDefault()
    })
    
    App.Nav = Nav
  })
  
} (jQuery);