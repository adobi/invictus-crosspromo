!function($) 
{
  var Utils = {
    bindEvents: function() 
    {
      var self = this
      
      $('body').on('click', '.toggle', function(e) { self.toggle($(this)); e.preventDefault() })
      
      $('body').on('click', '.editable', function(e) { self.editable($(this)); e.preventDefault() })
      
      //$('body').on('click', '.save-new-item', function(e) { self.saveItem($(this)); e.preventDefault() })
      $('body').on('submit', '.new-list-form', function(e) { self.saveItem($(this)); e.preventDefault() })
      
      $('body').on('click', '.delete-list-item', function(e) { self.deleteItem($(this)); e.preventDefault() })
      
      $('body').on('keyup', '#quick-search-by-game-name', function(e) { e.preventDefault(); self.filterByName($(this)) })
      
      $('body').on('click', '.all-games li', function(e) { e.preventDefault(); $(this).toggleClass('selected-game') })
      
      $('body').on('click', '.edit-description', function(e) { e.preventDefault(); self.editModal($(this)) })
      
      $('body').on('submit', '#edit-description-form', function(e) { e.preventDefault(); self.saveDescription($(this)) })
      
      $('body').on('change', '.switch-value', function(e) { e.preventDefault(); self.switchValue($(this)) })
      
      $('body').on('click', '.edit-list-modal', function(e) { e.preventDefault(); self.editListModal($(this)) })
      
      $('body').on('click', '.delete-image', function(e) { e.preventDefault(); self.deleteImage($(this)) })
      
      $('body').on('click', '.edit-type-modal', function(e) { e.preventDefault(); self.editTypeModal($(this)) })
      
      $('body').on('click', '.delete-type', function(e) {e.preventDefault(); self.deleteType($(this))})
      
      self.dragAndDropTypes()
      /*
      $('.badge-price').each(function(index) {
        var self = $(this)
            price = self.find('.price')
            promo = self.find('.promo-price')
            
        if (price.html().length) self.css('color', '#000')
        
        if (promo.html().length) self.css('color', '#fff')
      })*/
    },
    
    dragAndDropTypes: function() 
    {
      var _self = this
      
      $('body').on('mouseenter', '.types-list li', function() {
        var that = $(this)
        
        if (!that.is(':data(draggable)'))
          that.draggable({
            appendTo: ".dnd-helper",
            helper: "clone",
            start: function (event, ui) {
              console.log($(ui.helper))
              $(ui.helper).find('img, .caption').hide()
            }
          })
      })      
      
      $('body').on('mouseenter', '.type-drop', function() {
        var self = $(this)
        self.droppable({
          hoverClass: "dnd-li-active-small",
          accept: ".type-item",
          drop: function( event, ui ) {
            var that = $(this),
                dragged = $(ui.draggable)
            
            //console.log(that, dragged)
            
            _self.save('crosspromo/add_type/'+that.data('crosspromo-id'), {type_id: dragged.data('type-id')}, function() {
              var type = that.find('.crosspromo-type')
              type.html(dragged.find('h6').html())
              that.find('.type-drop h6').attr('data-type-id', dragged.data('type-id'))
            })
          }
        })     
      })      
    },

    editTypeModal: function(el) 
    {
      this.editModalTriggerElement = el
      
      $.get(App.URL+'crosspromotype/get/'+el.data('type-id'), function(response) {
        App.Template.load('type/edit.html', $('#dummy-container'), $.parseJSON(response), function() {
          
          var modal = $('#edit-type-modal')
          modal.modal()
          //App.Datepicker()
        })
      })
    },
    
    deleteType: function(el) 
    {
      var id = el.data('id')
        
      this.remove('crosspromotype/delete/'+id, function() {
        
        el.parents('li:first').remove()
        
        $("#crosspromo-lists").find('[data-type-id='+id+']').html('Drag type here')        
      })      
    },
    
    deleteImage: function(el) 
    {
      var id = el.data('id'),
          url = el.data('url')
      this.remove(url+id, function() {
        
        el.parent().html('<input type="file" name="image">')
        $('#'+id).find('legend').find('img').remove()
        $('#'+id).find('img').attr('src', '//placehold.it/80x80')
      })
    },
    
    switchValue: function(el) 
    {
      var data = {}
      
      data[el.attr('name')] = el.is(':checked') ? el.val() : 0
      //console.log(el)
      this.save('crosspromolist/switch_value/'+el.data('crosspromo-id'), data, function() {
        el.parent().toggleClass('btn-success').toggleClass('btn-danger')
      })
    },
    
    saveDescription: function(el) 
    {
      var current = this.editModalTriggerElement
      
      if (current.data('crosspromo-id')) {
        this.save('crosspromo/save_description_to_item/'+this.editModalTriggerElement.data('crosspromo-id'), el.serializeObject(), function() {
          var item = current.parents('.item'),
              promo = item.find('.promo-price'),
              price = item.find('.price')
          
          item.find('.badge').show()    
              
          item.find('.description').html(el.find('textarea').val())
          item.find('.crosspromo-type').html(el.find('[name=type_id] option:selected').text())
          
          if (el.find('[name=promo_price]').val().length && el.find('[name=promo_price]').val() != '0') {
            
            promo.html(el.find('[name=promo_price]').val())
            price.html('<del>'+price.html()+'</del>')
          } else {
            
            promo.html('')
            price.html(price.find('del').html())
          }

          $('#edit-description-modal').modal('hide')
          
          el.find('button').attr('disabled', false)
        })
      }
    },
    
    editModal: function(el) 
    {
      this.editModalTriggerElement = el
      
      $.get(App.URL+'crosspromo/get/'+el.data('crosspromo-id'), function(response) {
        App.Template.load('crosspromo/edit.html', $('#dummy-container'), $.parseJSON(response), function() {
          
          var modal = $('#edit-description-modal')
          modal.modal()
          App.Datepicker()
        })
      })
    },
    
    editListModal: function(el) 
    {
      
      var template = function(response) {
        
        App.Template.load('crosspromo/edit_list.html', $('#dummy-container'), response, function() {
          
          var modal = $('#edit-list-modal')
          
          modal.modal()
        })
      }
      
      this.editModalTriggerElement = el
      
      $.getJSON(App.URL+'crosspromolist/get/'+el.data('list-id'), template)
    },    
    
    filterByName: function(el) 
    {
      var val = el.val(),
          items = $('.all-games li')
      
      if (!$.trim(val).length) {
        items.show()
      } else {
        $.each(items, function(i, v) {
          var name = $(v).find('h6').attr('data-original-title')
          
          if (name.toLowerCase().indexOf(val.toLowerCase()) === -1) {
            $(v).hide()
          } else {
            if ($(v).is(':hidden')) $(v).show()
          }
        })
      }
    },
    
    toggle: function(el) 
    {
      var target = el.parents(el.data('parent')).find(el.data('target'))
      target.toggle()
      target.find('input:first, textarea:first').focus()
    },
    
    editable: function(el) 
    {
      var self = el,
          elem = self.parents(self.data('parent')).find(self.data('target')),
          val = elem.text(),
          input = $('<input class="span2" type="text" name="name" value="'+val+'" /> <a href="#" class="btn btn-primary button-save"><i class="icon-white icon-ok"></i></a>"'),
          that = this
      
      elem.html(input)
      
      elem.find('.button-save').on('click', function(e) {
        
        var post = {},
            name = $('.csrf-form').find('[type=hidden]').attr('name'),
            value = $('.csrf-form').find('[type=hidden]').attr('value'),
            input = elem.find('input')
            
        e.preventDefault()
        
        post[name] = value
        post['name'] = input.val()
                
        that.save('crosspromolist/edit/'+self.data('id'), post, function(response) {
          elem.html(input.val())
        }, function() {
          
        })
        
        
      })
    },
    
    saveItem: function(el) 
    {
      var self = el,
          tmpl = Handlebars.compile('{{>crosspromo_type_item}}'),
          //val = self.prev().val(),
          val = el.serializeObject()
          //data = {type: {name: val}},
          name = $('.csrf-form').find('[type=hidden]').attr('name'),
          value = $('.csrf-form').find('[type=hidden]').attr('value'),
          post = {}
      
      post[name] = value
      //post.name = val,
      
      $.extend(post, val)
      
      post.game_id = $('#crosspromo_base_game').val()
      
      this.save('crosspromolist/edit/', post, function (response) {
          
          $(el.data('append-to')).append(tmpl(response))
          
          $('.new-form').hide()
          $('.new-form input').val('')
          
          el.find('[type=submit]').attr('disabled', false)
          
          App.Crosspromo.sortable($('.crosspromo-list-items'), App.Crosspromo.UpdateOrder)
          App.Crosspromo.sortable($('#crosspromo-lists'), App.Crosspromo.UpdateOrder)
          
          App.Crosspromo.DragAndDropGames()
          
        }, function() {
          
        }
      )
    },
    
    deleteItem: function(el) 
    {
      var self = el,
          id = self.data('id')
          
      this.remove('crosspromolist/delete/'+id, function(response) {
        el.parents('.crosspromo-type').remove()
        
        App.Tooltip('hide')
      })
      
    },
    
    request: function(settings, successCallback, errorCallback) 
    {
      var params = {
        dataType: 'json',
      }
      
      $.extend(params, settings)
      
      var request = $.ajax(params)
      
      if (typeof successCallback === 'function') {
        request.done(successCallback)
      } 

      if (typeof errorCallback === 'function') {
        request.fail(errorCallback)
      } 
    },
    
    remove: function(url, successCallback, errorCallback) 
    {
      
      this.request({
        url: App.URL+url,
        type: 'get'
      }, successCallback, errorCallback)
    }, 
    
    save: function(url, data, successCallback, errorCallback) 
    {
      var name = $('.csrf-form').find('[type=hidden]').attr('name'),
          value = $('.csrf-form').find('[type=hidden]').attr('value')
      
      data[name] = value
      //console.log(data)
      this.request({
        url: App.URL+url,
        data: data,
        type: 'post'
      }, successCallback, errorCallback)
    }
  }
  
  $(function() {
    Utils.bindEvents()
    
  })
  
  App.Utils = {
    
  }
   
}(jQuery);