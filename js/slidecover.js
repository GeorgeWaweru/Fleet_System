(function (window, $) {
    // $(document).ready(function(){});
    var keyboard_avail  = false;
    lexusMagazineReady = function () {
        var mod = window.Modernizr,
            modCSSAnimations  = mod && mod.cssanimations,
            modCSSTransforms  = mod && mod.csstransforms,
            modCSSTransitions = mod && mod.csstransitions,
            modTouch          = mod && mod.touch,
            modAnim           = modCSSAnimations && modCSSTransitions;

        keyboard_avail = true;
        var $splitWrapper   = $('#split-wrapper'),
            $splitLeft      = $('#split-left'),
            $splitRight     = $('#split-right'),
            $window         = $(window),
            w               = $window.width(),
            h               = $window.height(),
            pos             = (w + h / Math.tan(Math.PI / 180 * 57.5)) / 2 / w * 100 + 50 + '%';

        $splitLeft.css({ 
            "-webkit-transform"   : "skewX(0deg) translateX(-100%)",
            "-ms-transform"       : "skewX(0deg) translateX(-100%)",
            "-moz-transform"      : "skewX(0deg) translateX(-100%)",
            "-o-transform"        : "skewX(0deg) translateX(-100%)",
            "transform"           : "skewX(0deg) translateX(-100%)"
        });
        $splitRight.css({ 
            "-webkit-transform"   : "skewX(0deg) translateX(100%)",
            "-ms-transform"       : "skewX(0deg) translateX(100%)",
            "-moz-transform"      : "skewX(0deg) translateX(100%)",
            "-o-transform"        : "skewX(0deg) translateX(100%)",
            "transform"           : "skewX(0deg) translateX(100%)"
        });
        $splitWrapper.on('transitionend webkitTransitionEnd', function (event) {
            $splitWrapper.remove();
        });

        function slideshow () {
			$("#preloading_div").fadeOut();
            var $slides     = $('#cover-slides'),
                interval    = 16000;
            function slide () {
                var $last = $slides.children().last();
                if (window.Modernizr && Modernizr.cssanimations) {
                    $last
                        .addClass('img-sliding')
                        .on('transitionend webkitTransitionEnd', function (event) {
                            $(this).prependTo($slides).removeClass('img-sliding');
                        });
                } else {
                    $last.animate({ top: '100%' }, 1500, 'easeInOutQuint', function () {
                        $(this).prependTo($slides).css({ top: 0 });
                    })
                }
				
            }
            setInterval(slide, interval);
        }

        function setEvent(){
            $("#cover").on('mousewheel', function (event, delta) {
                    if (delta < 0) {
                        MagazineNaviOpen();
                    }
                })
                .on('touchstart touchmove touchend', function (event) {
                    var touch = event.originalEvent.touches[0];
                    event.preventDefault();
                    switch (event.type) {
                        case 'touchstart':
                            touchStartY = touch.pageY;
                            break;
                        case 'touchmove':
                            touchMoveY = touch.pageY - touchStartY;
                            break;
                        case 'touchend':
                            if (touchMoveY < -100) {
                                MagazineNaviOpen();
                            }
                            break;
                        default:
                            break;
                    }
                });


            
            function keydownHandler(e){
                if(e.keyCode == 38){
                    // lexusMagazineNaviClose();
                }else if(e.keyCode == 40){
                    MagazineNaviOpen();
                    // $(window).unbind("keydown",keydownHandler);
                }
            }

            $(window).keydown(keydownHandler);
        }

        setTimeout(slideshow, 500);
        setTimeout(setEvent,1000);
    }
})(this, jQuery);


$(window).on('load', function () {
    $('#cover-slides').find('img').fullscreenImage();
});

$.fn.fullscreenImage = function () {
    this.each(function () {
        var $image = $(this),
            imageAspectRatio = $image.attr('width') / $image.attr('height'),
            $screen = $image.offsetParent();
        $(window).on('resize', resizeImage).trigger('resize');
        function resizeImage () {
            var screenWidth = $screen.width(),
                screenHeight = $screen.height(),
                style;
            if (imageAspectRatio > screenWidth / screenHeight) {
                style = {
                    //width: 'auto',
                    height: '100%',
                    top: 0,
                    left: -(screenHeight * imageAspectRatio - screenWidth) / 2
                };
            } else {
                style = {
                    width: '100%',
                    height: '100%',
                    top: -(screenWidth / imageAspectRatio - screenHeight) / 2,
                    left: 0
                };
            }
            $image.css(style);
        }
    });
    return this;
};

$('.ke').click(function(){
   if($('.country_div').width()<=0){
     $(this).animate({'width':'300' + 'px'});
    }else{
      $(this).animate({'width':'0' + 'px'});
      }
   
});

function css3_XYZ(tx,ty,tz){
    var css3 = "translateX("+tx+"px) translateY("+ty+"px) translateZ("+tz+"px)"
    return{
        "-webkit-transform" : css3,
        "-moz-transform"    : css3,
        "-o-transform"      : css3,
        "-ms-transform"     : css3,
        "transform"         : css3
    };
}
