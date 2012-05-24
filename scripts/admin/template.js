!function($) 
{
  "use strict"
  
  App._templatesDir = 'scripts/templates/'
  
  var Template = {
    initPartials: function() 
    {
      Handlebars.registerPartial('filter_platforms_item', '<li><a href="#" data-platform="{{id}}">{{name}}</a></li>')
  
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