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
    },
    
    switchValue: function(el) 
    {
      var data = {}
      
      data[el.attr('name')] = el.is(':checked') ? el.val() : 0
      console.log(el)
      this.save('crosspromo/switch_value/'+el.data('crosspromo-id'), data, function() {})
    },
    
    saveDescription: function(el) 
    {
      var current = this.editModalTriggerElement
      
      if (current.data('crosspromo-id')) {
        this.save('crosspromo/save_description_to_item/'+this.editModalTriggerElement.data('crosspromo-id'), el.serialize(), function() {
          
          current.parents('.item').find('.description').html(el.find('textarea').val())
          
          $('#edit-description-modal').modal('hide')
          
          el.find('button').attr('disabled', false)
        })
      }
    },
    
    editModal: function(el) 
    {
      var modal = $('#edit-description-modal')
      
      modal.on('shown', function() { modal.find('textarea').focus() })
      
      modal.modal()
      
      modal.find('textarea').val(el.parents('.item').find('.description').html())
      
      this.editModalTriggerElement = el
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