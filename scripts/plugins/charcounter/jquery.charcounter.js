;(function ( $, window, document, undefined ) {

    var pluginName = 'charcounter',
        defaults = {
            limit: 140,
            warning: 15,
            warningClass: 'badge-warning',
            exceededClass: 'badge-important',
            defaultClass: 'badge-info',
            notAllowOverflow: true,
            fontSize: '1.1em',
        };

    function Charcounter( element, options ) 
    {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Charcounter.prototype.init = function () 
    {
        var self = $(this.element),
            width = self.outerWidth(),
            that = this;
           
        if (self.data('limit')) that.options.limit = self.data('limit');
        
        if (self.data('warning')) that.options.limit = self.data('warning');

        window.a = self
        self
          .parents(self.data('parent'))
          .nextAll(self.data('prepend'))
          .prepend($('<span />', {'class': 'badge char-counter', 'html': this.options.limit}).addClass(this.options.defaultClass).css('font-size',this.options.fontSize))
        
        self.on('charcounter.recount keyup change focus blur', function(e) {
            
            if (that.options.notAllowOverflow) {
                
                if (!that.handle($(this).val())) {
                    //console.log($(this).val().substring(0, that.options.limit));
                    $(this).val($(this).val().substring(0, that.options.limit));
                }
            } else {
                that.handle($(this).val());
            }
        });
        
        that.handle(self.val());
    };
    
    Charcounter.prototype.handle = function(value)
    {
        var self = $(this.element), 
            span = self
                    .parents(self.data('parent'))
                    .nextAll(self.data('prepend')).find('.char-counter'),
            size = value.length,
            val = this.options.limit - size,
            flag;
        
        
        
        if (val <= this.options.limit) {
            span.removeClass(this.options.exceededClass).removeClass(this.options.warningClass).addClass(this.options.defaultClass);
            flag = true;
        }
        
        if (val < this.options.warning) {
            span.removeClass(this.options.defaultClass).addClass(this.options.warningClass);
            flag = true;
        }
        
        if (val <= 0) {
            span.removeClass(this.options.warningClass).addClass(this.options.exceededClass)
            
            flag = false;
            val = 0;
        }
        span.html(val);
        return flag;
    };
    
    $.fn[pluginName] = function ( options ) 
    {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Charcounter( this, options ));
            }
        });
    }
    
    $(function() 
    {
        $('[data-countable=1]').charcounter();
    });
    
})( jQuery, window, document );