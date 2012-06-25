!function($) 
{
  "use strict"  
  
  var Crosspromo = function(el) 
  {
    this.el = el
  }
  
  Crosspromo.WarningModal = $('#overwrite-warning')
  
  Crosspromo.BaseGameId = 0
  
  Crosspromo.UpdateOrder = function(order, type) 
  {
      var data = {},
          name = $('.csrf-form').find('[type=hidden]').attr('name'),
          value = $('.csrf-form').find('[type=hidden]').attr('value')
      
      data[name] = value
      data['order'] = order
      
      if (!type) type="";
      
      var uri = App.URL+'crosspromo'+type+'/update_order/'
      
      $.post(uri, data, function() {})
  }  

  Crosspromo.DragAndDropGames  = function() 
  {
    $('body').on('mouseenter', '.all-games li', function() {
      var self = $(this)
      
      if (!self.is(':data(draggable)'))
        self.draggable({
          appendTo: ".dnd-helper",
          //helper: "clone",
          helper: function() {
            var selected = $('.all-games .selected-game'),
                container = $('<div />').attr('id', 'games-draggable-container')
                
            if (!selected.length) selected = $(this)
            
            container.append(selected.clone())
            
            return container
          },
          start: function (event, ui) {
            
            ui.helper.find('.caption').show()
          }
        })
    })
    
    $('body').on('mouseenter', '.accordion-inner .thumbnails li', function() {
      var self = $(this)
      //console.log(self.is(':data(droppable)'))
      //if (!self.is(':data(droppable)'))
        self.droppable({
          //activeClass: "",
          hoverClass: "dnd-li-active",
          accept: ":not(.ui-sortable-helper, .type-item)",
          drop: function( event, ui ) {
            var that = $(this)
            $.each(ui.helper.children(), function(i, v) {
              //var clone = ui.draggable.clone(),
              var clone = $(v).clone(),
                  dropTo = that
              
              clone.find('.caption').show()
              
              if (!dropTo.parents('.thumbnails').find("li>.item[data-id="+clone.find('.item').data('id')+"]").length) {
               
                //if (!$.trim(dropTo.html()).length) {
                if(dropTo.is('.placeholder')) {
                  //dropTo.html(clone.html())
                  Crosspromo.Copy(clone, dropTo)
                } else {
                
                  Crosspromo.WarningModal.find('#old-item').html(dropTo.attr('data-original-title'))
                  Crosspromo.WarningModal.find('#new-item').html(clone.attr('data-original-title'))
                
                  Crosspromo.WarningModal.modal()
                  
                  Crosspromo.DropToElement = dropTo
                  Crosspromo.DraggedElement = clone
                }
              } else {
              
                $('#already-in-use-error').modal().find('#item-to-use').html(clone.attr('data-original-title'))
              
              //App.showNotification('<p>'+clone.attr('data-original-title')+' is already in the list, select something else!</p>')
              }
            })
            
            $('.all-games .selected-game').removeClass('selected-game')
          }
        })     
    })
  }
  
  Crosspromo.Copy = function (src, dest) 
  {
    
    var template = Handlebars.compile('{{>crosspromo_list_item}}'),
        data = {
          logo: src.data('logo'),
          platform_name: src.data('platform-name'),
          name: src.find('h6').data('original-title'),
          id: src.find('.item').data('id'),
          promo_game_id:src.find('.item').data('id'),
        }
    //console.log(data)
    dest.data('old-id', dest.attr('id'))
    
    dest.before(template(data))
    //dest.html(src.html())
    dest.attr('id', dest.find('.item').data('id'))
    dest.find('.caption').show()
    dest.attr('rel', src.find('h6').attr('rel')).attr('data-original-title', src.find('h6').attr('data-original-title'))
    Crosspromo.Add(dest, src)
  }
  
  Crosspromo.ResetPlaceholder = function() 
  {
    $('#crosspromo-lists .placeholder').attr('rel', '')
    $('#crosspromo-lists .placeholder').attr('data-original-title', '')
  }
  
  Crosspromo.Add = function(el, src)
  {
    var item = $('#crosspromo_base_game').val(),//item = el.data('old-id'),
        promoGame = src.find('.item').data('id'),
        type = el.parents('.crosspromo-type').data('list-id')
    //console.log(type)    
    if (item && promoGame) {
      //console.log(el)
      Crosspromo.Save(el, item, promoGame, type)
    }
  }
  
  Crosspromo.Remove = function(id, callback)
  {
    $.get(App.URL+'crosspromo/delete/'+id, function() {
      
      App.Tooltip('hide')
      
      callback && callback()
      Crosspromo.TriggerLoadAllGames()
    })
  }
  
  Crosspromo.Save = function(el, item, game, type) 
  { 
    var name = $('.csrf-form').find('[type=hidden]').attr('name'),
        value = $('.csrf-form').find('[type=hidden]').attr('value'),
        data = {}
        
    data[name] = value;
    data['promo_game_id'] = game
    data['base_game_id'] = item
    data['list_id'] = type
    
    //console.log(data)
    $.post(App.URL+'crosspromo/edit/', data, function(resp) {
      
      App.Tooltip('hide')
      el.prev().attr('id', resp)
      //Crosspromo.UpdateOrder(el.parents('.thumbnails:first').sortable('toArray'))
      //Crosspromo.TriggerLoadAllGames()
      
      Crosspromo.ResetPlaceholder()
    })
    
  }
  
  Crosspromo.sortable = function(el, callback) 
  {
      var type = el.data('type'),
          settings = {
            stop: function(event, ui) {
              //console.log($(ui.item).parent().sortable('toArray'))
              callback && callback($(ui.item).parent().sortable('toArray'), type)
            }
          }
      
      if (!type) settings.placeholder = "dnd-li-active"

      el.sortable(settings);
      el.disableSelection();       
  }
  
  Crosspromo.prototype = 
  {
    sortable: function(callback, type) 
    {
      var that = this,  
          settings = {
            stop: function(event, ui) {
              
              //console.log($(ui.item).parents('ul:first').sortable('toArray'))
              
              callback && callback($(ui.item).parents('ul:first').sortable('toArray'), type)
            }
          }
      if (!type) settings.placeholder = "dnd-li-active"

      that.el.sortable(settings);
      this.el.disableSelection();       
    }  
  }

  Crosspromo.LoadAllGames = function() 
  {
    
    /*
    $('#crosspromo-all-games').load(App.URL+"crosspromo/load_all_games", function() {
      $('#crosspromo-all-games').find('[data-id='+Crosspromo.Selected+']').addClass('selected')
    })
    */
    
    //$.getJSON(App.URL+"crosspromo/load_all_games")
  }
  
  Crosspromo.TriggerLoadAllGames = function() {
    $('body').trigger('crosspromo-laod-games')
  }
  
  Crosspromo.LoadForGame = function(id) 
  {
    Crosspromo.BaseGameId = id
    
    $.getJSON(App.URL+'crosspromo/for_game/'+id, function(json) {
      App.Template.load('crosspromo/list.html', $('.accordion-inner'), json, function() { 
        
        //console.log(json) 
        
        //!(new Crosspromo($('.accordion-inner .thumbnails'))).sortable(Crosspromo.UpdateOrder)
        
        //!(new Crosspromo($('.crosspromo-types'))).sortable(Crosspromo.UpdateOrder, 'list')
        
        Crosspromo.sortable($('.crosspromo-list-items'), Crosspromo.UpdateOrder)
        Crosspromo.sortable($('#crosspromo-lists'), Crosspromo.UpdateOrder)
        
        Crosspromo.DragAndDropGames()
        
        App.Tooltip()   
        
        $('[data-toggle="switch"]').switchbtn()     

        $('.all-games').find('li.hide').removeClass('hide')
        $('.all-games').find('[data-id='+id+']').parents('li').addClass('hide')
        App.Tooltip('hide')

      })
    })
  };
  
  Crosspromo.Empty = function (targetId)
  {
    if (targetId) {
      $.get(App.URL+"crosspromo/empty_promo_game/"+targetId, function(resp) {
      
      })
    }
  }
  
  Crosspromo.CopyListModal = function(el) 
  {
    $('#copy-list-modal').modal()
    
    $('#copy-list-form').attr('action', $('#copy-list-form').data('action') + el.data('list-id'))
    
    $('#copy-list-modal').on('hide', function() {
      $(this).find('button').attr('disabled', false)
      
      $(this).find('select').val('').trigger("liszt:updated");
    })
  }
  
  Crosspromo.CopyList = function(el) 
  {
    App.Utils.save(el.attr('action'), el.serialize(), function(response) {
      
      if(response.error) {
        
        el.find('.alert-error').html(response.error).show()
        
        el.find('.button').attr('disabled', false)
      }
      
      if (response.success) {
        $('#copy-list-modal').modal('hide')
      }
      
    }, function() {
      
    })
  }
  
  $(function() {
    
    //$('body').on('crosspromo-laod-games', Crosspromo.LoadAllGames);
    
    Crosspromo.TriggerLoadAllGames()

    $('body').on('click', '.copy-list-modal', function(e) {
      e.preventDefault()
      Crosspromo.CopyListModal($(this))
    })
    
    $('body').on('submit', '#copy-list-form', function(e) {
      e.preventDefault()
      Crosspromo.CopyList($(this))
    })
    
    $('body').on('change', '#crosspromo_base_game', function(e) {
      Crosspromo.LoadForGame($(this).val())
      $('#crosspromo-games>.thumbnails').hide()
      
      window.location.hash = $(this).val()
      
      e.preventDefault()
    })
      
    $('body').on('click', '.crosspromo-selected-game', function(e) {
      
      //Crosspromo.LoadForGame($(this).val())
      
      var self = $(this);
      
      self.parents('ul:first').find('.selected').removeClass('selected')
      self.parents('.item:first').addClass('selected')
      
      Crosspromo.Selected = $(this).data('id')
      
      Crosspromo.LoadForGame($(this).data('id'))
      
      e.preventDefault()
    })
    
    $('body').off('click', '.layout-remove');
    $("body").on('click', '.layout-remove', function(e) {
      
      var self = $(this)
      
      Crosspromo.Remove(self.parents('li:first').attr('id'), function() {
        var li = self.parents('li:first')
        
        li.removeAttr('data-original-title').removeAttr('rel').empty()
      })
      
      e.preventDefault()
    })
    
    $('body').off('click', '#overwrite-yes');
    $('body').on('click', '#overwrite-yes', function(e) {
      //console.log(Crosspromo.DropToElement)
      Crosspromo.Empty(Crosspromo.DropToElement.attr('id'))
      
      Crosspromo.Copy(Crosspromo.DraggedElement, Crosspromo.DropToElement)
      
      $('#overwrite-warning').modal('hide')
      
      e.preventDefault()
    });
    
    Crosspromo.WarningModal.on('hide', function () {
      Crosspromo.DropToElement = null
      Crosspromo.DraggedElement = null
    })
  })
  App.Crosspromo = Crosspromo

  
} (jQuery);