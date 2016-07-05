// HTML5 placeholder plugin version 0.3
// Enables cross-browser* html5 placeholder for inputs, by first testing
// for a native implementation before building one.
//
// USAGE: 
//$('input[placeholder]').placeholder();

(function($){
  
  $.fn.placeholder = function(options) {
    return this.each(function() {
      if ( !("placeholder"  in document.createElement(this.tagName.toLowerCase()))) {
        var $this = $(this);
        var placeholder = $this.attr('placeholder');
        $this.val(placeholder);
        $this
          .focus(function(){ if ($.trim($this.val())==placeholder){ $this.val(''); }; })
          .blur(function(){ if (!$.trim($this.val())){ $this.val(placeholder); }; });
      }
    });
  };
})(jQuery);

// perform JavaScript after the document is scriptable.
$(document).ready(function() {
    $("ul.tabs").tabs("div.panes > section");
    $(".accordion").tabs(".accordion section", {tabs: 'header', effect: 'slide', initialIndex: null});

    $('.pricing-table article').hover(function() {
        $('.pricing-table article').removeClass('selected');
    });
    
    $('input[placeholder]').placeholder();

    $("input[type=date]").each(function() {
        $(this).dateinput();
    });

    $(".widget.collapsible header").prepend('<span class="widget-collapse"></span>')
        .find('.widget-collapse')
        .click(function(){
            if ($(this).hasClass('widget-collapse')) {
                $(this).parents('.widget').find('section').slideUp('fast', function(){$(this).parents('.widget').addClass('collapsed');});
                $(this).removeClass('widget-collapse').addClass('widget-expand');
            } else {
                $(this).parents('.widget').removeClass('collapsed').find('section').slideDown();
                $(this).removeClass('widget-expand').addClass('widget-collapse');
            }
        });

    $(".message.closeable").prepend('<span class="message-close"></span>')
        .find('.message-close')
        .click(function(){
            $(this).parent().fadeOut(function(){$(this).remove();});
        });
    //if (PIE) $.each($('.message-close'), function(){PIE.attach();});

    $(".column").sortable({
        connectWith: '.column',
        handle: 'header',
        cursor: 'move',
        revert: 500,
        opacity: 0.7,
        appendTo: 'body',
        placeholder: 'widget-placeholder',
        forcePlaceholderSize: true,
        start: function(event, ui) {
        },
        stop: function(event, ui) {
        },
        update: function(event, ui) {
            // This will trigger after a sort is completed
            var ordering = "";
            var $columns = $(".column");
            $columns.each(function() {
                ordering += this.id + "=" + $columns.index(this) + ";";
            });
            //$.cookie("ordering", ordering);
        }
    });
});
