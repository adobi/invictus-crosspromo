!function($) 
{
  var Utils = {
    bindEvents: function() 
    {
      var self = this
      
      $('body').on('click', '.toggle', function(e) { self.toggle($(this)); e.preventDefault() })
      
      $('body').on('click', '.editable', function(e) { self.editable($(this)); e.preventDefault() })
      
      $('body').on('click', '.save-new-item', function(e) { self.saveItem($(this)); e.preventDefault() })
    },
    
    toggle: function(el) 
    {
       el.parents(el.data('parent')).find(el.data('target')).toggle()
    },
    
    editable: function(el) 
    {
      var self = el,
          elem = self.parents(self.data('parent')).find(self.data('target')),
          val = elem.text(),
          input = $('<input class="span2" type="text" name="name" value="'+val+'" /> <a href="#" class="btn btn-primary button-save"><i class="icon-white icon-ok"></i></a>"')
      
      elem.html(input)
      
      elem.find('.button-save').on('click', function(e) {
        
        elem.html(elem.find('input').val())
        
        e.preventDefault()
      })
    },
    
    saveItem: function(el) 
    {
      var self = el
      
      var tmpl = Handlebars.compile('{{>crosspromo_type_item}}'),
          data = {name: self.prev().val()}
      
      $(self.data('parent')).append(tmpl(data))
      
      $('.new-form').hide()      
    },
  }
  
  $(function() {
    Utils.bindEvents()
  })
  
  App.Utils = {
    
  }
   
}(jQuery);