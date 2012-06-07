!function($) 
{
  "use strict"
  
  App._templatesDir = 'scripts/templates/'
  
  var Template = {
    initPartials: function() 
    {
      Handlebars.registerPartial('filter_platforms_item', '<li><a href="#" data-platform="{{id}}">{{name}}</a></li>')
      
      Handlebars.registerHelper('dropdown_list', function(name, values, selected) {
        if (!values) return false
        
        var html = '<select name="'+name+'">'
        
        for (var i = 0; i < values.length; i++) {
          
          html += '<option value="'+values[i].id+'"'
          
          if (values[i].id === selected)  html += ' selected="selected"'
          
          html += '>'+values[i].name+'</option>'
        }
        html += '</select>'
        //console.log(html)
        return new Handlebars.SafeString(html)
      })
      
      Handlebars.registerHelper('is_checked', function(val) {
        if (val === '1') return 'checked="checked"' 
      })
      
      Handlebars.registerHelper('is_active', function(val) {
        if (val === '1') return 'btn-success' 
        return 'btn-danger'
      })      
      
      $.get(App._templatesDir+'games/list_item.html', function(partial) {
        Handlebars.registerPartial('game_list_item', partial)
      })
      
      $.get(App._templatesDir+'crosspromo/list_item.html', function(partial) {
        Handlebars.registerPartial('crosspromo_list_item', partial)
      })
  
      $.get(App._templatesDir+'crosspromo/type_item.html', function(partial) {
        Handlebars.registerPartial('crosspromo_type_item', partial)
      })       
    },
    
    load: function(templatePath, container, json, callback) 
    {
      
      $.get(App.URL+App._templatesDir + templatePath, function(tmpl) {
        var template = Handlebars.compile(tmpl)
        
        container.html(template(json))
        
        callback && callback()
      })      
    },
  }
  
  $(function() {
    Template.initPartials()
  })
  
  App.Template =  {
    initPartials: Template.initPartials,
    load: Template.load
  }
  
  
}(jQuery);