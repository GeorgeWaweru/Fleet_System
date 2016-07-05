lexusMagazineOnLoad = function(){};
lexusMagazineReady  = function(){};

MagazineNaviStatus  = function(){};
MagazineNaviOpen    = function(){};
MagazineNaviClose   = function(){};
MagazineNaviHidden  = function(){};
MagazineNaviView    = function(){};

(function (window, $) {
    var $window = $(window),
        $document = $(document);

    // https://github.com/ftlabs/fastclick
    $(window).on('load', function() {
       new FastClick(document.body);
    }, false);

    var isJp = location.href.indexOf('/jp/') != -1;

    $document.ready(function(){
        var mod = window.Modernizr,
            modCSSAnimations  = mod && mod.cssanimations,
            modCSSTransforms  = mod && mod.csstransforms,
            modCSSTransitions = mod && mod.csstransitions,
            modTouch          = mod && mod.touch,
            modAnim           = modCSSAnimations && modCSSTransitions;

        // jQuery imagesLoaded
        // https://github.com/desandro/imagesloaded

        var isCache             = cacheCheck(),
            $loadingWrapper     = $('#loading-wrap'),
            $loading            = $('<div id="loading"></div>').appendTo($loadingWrapper),
            atHome              = $loadingWrapper.hasClass('at-home');

        function imgLoad(){
            var imgLoader           = imagesLoaded("body"),
                imgTotal            = imgLoader.images.length,

                progress1           = 0,
                progress2           = 0,
                percent1            = 0,
                percent2            = 0,

                imgLoaded           = 0,
                animLoaded          = 0,
                spriteFrameSize     = atHome? 170: 100,
                spriteFrameCount    = atHome? 51: 42;

            imgLoader.on("progress",function(instance,image){
                var result = image.isLoaded ? 'loaded' : 'broken';
                imgLoaded++;
                progress1   = (imgLoaded/imgTotal)*100;
                progress2   = (imgLoaded/imgTotal)*spriteFrameCount;
                //image load complete
                if(progress1 == 100){
                    // lexusMagazineOnLoad();
                    // dfdAnimationComplete();
                }
            });

            var progressTimer = setInterval(function(){
                percent1 += (progress1-percent1)*0.1;
                percent2 += (progress2-percent2)*0.1;

                $loading.html(parseInt(percent1));
                $loading.css({backgroundPosition: '0 ' + (-parseInt(percent2)*spriteFrameSize) + 'px'});

                if(percent1 >= 100){
                    //image Load complete
                    clearInterval(progressTimer);
                    setTimeout(function(){
                        lexusMagazineOnLoad();
                        imgLoadComplete();
                    },50);
                    return
                }
                if(percent1 >= 99.9){
                    percent1 = 100;
                    percent2 = spriteFrameCount;
                }

            },1000/60);
        }


        function imgLoadComplete() {
            $loading.stop().fadeOut(600,"easeOutQuint");

            if(!isCache){
                $operate.find('p').each(function(i){
                    $(this).delay(i*200).fadeIn(800,"easeInOutQuint");
                });

                $("#operate").hover(
                    function(){$("#operate-line").stop().animate({top:"25px"},300,"easeOutExpo");},
                    function(){$("#operate-line").stop().animate({top:"18px"},400,"easeOutExpo");}
                );

                setTimeout(function(){
                    $(document).on('mousewheel',function(){
                        if(isCache != "start"){
                            isCache = "start";
                            startMotion();
                        }
                    });

                    $(window).keydown(function(e){
                        if(isCache != "start"){
                            if(e.keyCode == 38 || e.keyCode == 40){
                                isCache = "start";
                                startMotion();
                            }
                        }
                    });

                    if(modTouch){
                        $(document).on("touchend", function(){
                             if(isCache != "start"){
                                isCache = "start";
                                startMotion();
                            }
                        });
                    }

                    $("#operate").on("click",function(){
                        if(isCache != "start"){
                            isCache = "start";
                            startMotion();
                        }
                    });
                },1000);

                function startMotion(){
                    $("#operate").fadeOut(500,"easeInOutQuint");
                    setTimeout(function(){start()},500);
                }

            }else{
                start();
            }


            function start(){
                if(modAnim){
                    $loadingWrapper
                    .addClass('done')
                    .on('transitionend webkitTransitionEnd', function (event) {
                        $('.anim-stage').addClass('anim-ready');
                        lexusMagazineReady();
                        $loadingWrapper.remove();
                        $loadingWrapper = null;
                    });
                }else{
                    $loadingWrapper.animate({ opacity: 0 }, 500, function(){
                        $('.anim-stage').addClass('anim-ready');
                        lexusMagazineReady();
                        $loadingWrapper.remove();
                        $loadingWrapper = null;
                    });
                }

                setTimeout(function(){
                    alarmScrollSet();
                },1000);
            }
            
        }

        var $operate;
        if(!isCache){
            // localStorage.clear();
            // console.log("append");
            $loadingWrapper.append('<div id="operate"></div>');
            $operate = $loadingWrapper.find('#operate')//.css({display:"none"});
            $operate.append(
                //'<div>'+
                   // '<p>PLEASE KEEP SCROLLING TO<br>READ THE CONTENT</p>'+
                    //'<p id="operate-summary">'+
                    //'<span id="operate-keyboard"><img src="/magazine/issue1/common/img/operate-key-mouse.png" alt="keyboard or mouse"></span>'+
                   // '</p>'+
                   // '<p id="operate-btn">'+
                       // 'START'+
                      //  '<span id="operate-line"><img src="/magazine/issue1/common/img/operate-start-line.png"></span>'+
                    //'</p>'+
              //  '</div>'
            )
        }

         /* livesmart navigation bar setting*/
		 
        function magazinNavibSetting(){

            var dataURL = '/magazine/common/data/contents'+(isJp?'-jp' : '') +'.json';
            var navi_data,
                navi_open   = false;
                issue_total = 0,
                issue_current = 0,
                issue_changing = false;

            var path = window.location.pathname;
                urlIssueNumber = path.indexOf('issue')>-1?path.match(/issue[0-9]+/)[0].replace("issue","")-1:1;


                if(isJp)urlIssueNumber=0;


            dataLoad();

            function dataLoad(){
                $.ajax({
                    url:dataURL,
                    success : function(data){
                        navi_data = data;
                        for(var i in data){
                           
                            issue_total++; 
                        }
                        init();//console.log(data);
                    },
                    error : function(data){
                        console.log("json load error");
                    } 
                });
            }

            function init(){
                layoutInit();
            }

            var $magazine_nav,
                    $mnav_tap,
                        $mnav_tap_bg,
                            $mnav_tap_icon,
                            $mnav_tap_text,
                    $mnav_wrap,
                        $mnav_body,
                            $mnav_bg,
                            $mnav_top,
                                $mnav_top_bg,
                                $mnav_issue_current_wrap,
                                    $mnav_issue_current_inner,
                                        $mnav_issue_currents,
                                $mnav_issue_navi,
                            $mnav_middle;

            var thumb_wraps = [],
                thumbs      = [];
            function layoutInit(){

                $magazine_nav = $("#magazine-nav");
                if(typeof $magazine_nav[0] == "undefined")return;

                $mnav_tap               = $('<div id="mnav-tab"></div>').appendTo($magazine_nav);
                $mnav_tap_bg            = $('<div id="mnav-tab-bg"></div>').appendTo($mnav_tap);
                $mnav_tap_icon          = $('<img src="/magazine/common/images/magazine-navi-tab-icon-32x32.png" id="mnav-tab-icon" width="14" height="14">').appendTo($mnav_tap);
                $mnav_tap_text          = $('<span id="mnav-tab-text">contents</span>').appendTo($mnav_tap);
                $mnav_wrap              = $('<div id="mnav-wrap"></div>').appendTo($magazine_nav);
                $mnav_body              = $('<div id="mnav-body"></div>').appendTo($mnav_wrap);
                $mnav_bg                = $('<div id="mnav-bg"></div>').appendTo($mnav_body);
                $mnav_top               = $('<div id="mnav-top"></div>').appendTo($mnav_body);
                $mnav_top_bg            = $('<div id="mnav-top-bg"></div>').appendTo($mnav_top);
                $mnav_issue_current_wrap    = $('<div id="mnav-issue-current-wrap"></div>').appendTo($mnav_top);
                $mnav_issue_current_inner   = $('<div id="mnav-issue-current-wrap-inner"></div>').appendTo($mnav_issue_current_wrap);
                $mnav_issue_currents        = $('<div id="mnav-issue-currents"></div>').appendTo($mnav_issue_current_inner);
                $mnav_issue_navi            = $('<div id="mnav-issue-navi-wrap"></div>').appendTo($mnav_top);
                $mnav_middle                = $('<div id="mnav-middle" class="clearfix"></div>').appendTo($mnav_body);
                $mnav_close                 = $('<div id="manv-close"><img src="/magazine/common/images/icon-x-24x24.png" width="12" height="12"></div>').appendTo($mnav_middle);

                $("#globalfooter").appendTo($mnav_wrap);
                $('<div class="mnav-issue-current"></div>').appendTo($mnav_issue_currents);
                for(var i=0; i<issue_total; i++){
                    var menu = $('<div class="mnav-issue-navi"><img src="/magazine/common/images/number-100x100-0'+(i+1)+'.png" width="50" height="50"></div>').appendTo($mnav_issue_navi);
                    if(i==issue_total-1)$('<span id="mnav-issue-navi-title">ISSUE</span>').appendTo($mnav_issue_navi);
                    var current = $('<div class="mnav-issue-current"><img src="/magazine/common/images/number-120x160-0'+(i+1)+'.png" width="60" height="80"></div>').appendTo($mnav_issue_currents);
                    current.css({left:(-i*100)+"%"});
                }

                // wrap create
                for(var k=0; k<15; k++){
                    var thumb_wrap  = $('<div class="mnav-thumb-wrap"></div>').appendTo($mnav_middle), 
                        thumb_outer = $('<div class="mnav-thumb-wrap-outer"></div>').appendTo(thumb_wrap),
                        thumb_inner = $('<div class="mnav-thumb-wrap-inner"></div>').appendTo(thumb_outer),
                        thumb       = $('<div class="mnav-thumbs"></div>').appendTo(thumb_inner);
                    // thumb_wrap.css(css3DSet(500,'50%','50%'));
                    if(k==0){
                        $('<h2 id="mnva-title">CONTENTS</h2>').appendTo(thumb);
                    }
                    thumb_wraps[k] = {outer:thumb_outer,inner:thumb_inner,thumb:thumb};
                }

                // thumb create in wrap
                for(var i=0; i<=issue_total; i++){
                    var data = navi_data['issue'+i];
                    thumbs[i] = [];
                    for(var j=0; j<14; j++){
                        var thumb   = $('<div class="mnav-thumb"></div>').appendTo(thumb_wraps[j+1].thumb);

                        if(i > 0){
                            var img = $('<div class="mnav-thumb-img"><img src="' + data[j].image + '" alt="" width="180" height="115"></div>').appendTo(thumb);
                            if(data[j].overlayText != ""){
                                $('<span class="mnav-thum-non-active">'+data[j].overlayText+'</span>').appendTo(img);
                            }else{
                                thumb.wrap('<a href="'+data[j].url+'"></a>');
                            }
                            $('<p class="mnav-thumb-title">'+data[j].title+'</p>').appendTo(thumb);
                            $('<p class="mnav-thumb-summary">'+data[j].description+'</p>').appendTo(thumb);
                        }else{
                            $('<div class="mnav-thumb-img"></div>').appendTo(thumb);
                        }
                        thumb.css({left:(i*200)+"px"});
                    }
                    if(i==issue_total){
                        // maviLoad();
                    }
                }

                if(modCSSTransitions){
                    $loadingWrapper.css(css3_XYZ2(0,0,1001));
                    $magazine_nav.css(css3_XYZ2(0,0,1000));
                    $mnav_body.css(css3_XYZ2(0,50,500));   
                    $("#globalheader").css(css3_XYZ2(0,0,1002)); 
                }
                
                // $mnav_wrap.css({display:'none'});
                addEvent();
            }

            function maviLoad(){
                var mnvLoader   = imagesLoaded("#magazine-nav"),
                    mnvTotal    = mnvLoader.images.length,
                    mnvLoadCnt  = 0;
                mnvLoader.on("progress",function(instance,image){
                    var result = image.isLoaded ? 'loaded' : 'broken';
                    mnvLoadCnt++;
                    if(mnvLoadCnt == mnvTotal){
                        addEvent();
                    }
                });
            }
            function addEvent(){
                if(!modCSSTransitions){
                    $mnav_tap
                    .on('mouseover',function(){
                        // $(this).stop().animate({top:'-30px'},300,"easeOutQuint");
                    })
                    .on('mouseout',function(){
                        // $(this).stop().animate({top:'-30px'},300,"easeOutQuint");
                    }) 
                }

                $(".mnav-issue-navi").each(function(i){
                    $(this)
                    .on('click',function(){
                        if(issue_changing)return;
                        if(issue_current != i+1){
                            issueChange(i+1);
                        }
                    })
                    .on('mouseover',function(){
                        issueNaviActive(i+1);
                    })
                    .on('mouseout',function(){
                        issueNaviActive(issue_current);
                    });
                });

                $('.mnav-thumb-wrap').each(function(i){
                    if(i > 0){
                        $(this).on('mouseover',function(){
                            thumbActive(i);
                        });

                        $(this).on('mouseout',function(){
                            thumbActive(0);
                        });
                    }
                })

                $mnav_close
                .on('mouseover',function(){
                    // $mnav_close.css({background:'rgba(0,0,0,1)'});
                    $mnav_close.find('img').css(css3_ROTATE_Z(300,0,0,180));
                })
                .on('mouseout',function(){
                    // $mnav_close.css({background:'rgba(0,0,0,0.7)'});
                    $mnav_close.find('img').css(css3_ROTATE_Z(0,0,0,0));
                })
                .on('click',function(){
                    magazine_navi_open(false);
                });

                $mnav_bg.on('click',function(){
                    magazine_navi_open(false);
                });

                $mnav_top_bg.on('click',function(){
                    magazine_navi_open(false);
                });

                // navi tab
                $mnav_tap.css({cursor: "pointer"})
                $mnav_tap.on('click',function(){
                    if(navi_open)return;
                    magazine_navi_open(true);
                });

                // issueNaviActive(0)
                // issueChange(0);
            }

            var body_css_overflow = $('body').css('overflow');
            function magazine_navi_open(flag){
                if(flag){
                    $mnav_wrap.scrollTop(0);
                    change_delay = 20;
                    setTimeout(function(){
                        $('body').css({overflow:'hidden'});
                        $(".mnav-issue-navi").eq(urlIssueNumber).trigger('click');
                        $(".mnav-issue-navi").eq(urlIssueNumber).trigger('mouseover');
                        navi_open = true;
                    },600)
                }else{
                    
                    change_delay = 0;
                    issueNaviActive(0);
                    issueChange(0);
                    
                    setTimeout(function(){
                        navi_open = false;
                    },1100)
                    $('body').css({overflow:body_css_overflow});
                }

                setTimeout(function(){
                    if(modCSSTransforms && modCSSTransitions){
                        if(flag){
                            $magazine_nav.css(css3_XYZ2(0,-100,1000));
                            $mnav_body.css(css3_XYZ2(0,0,0));
                            $mnav_wrap.css({opacity:1});
                            $mnav_tap.addClass('mnav-tab-click');
                        }else{
                            $magazine_nav.css(css3_XYZ2(0,0,1000));
                            $mnav_body.css(css3_XYZ2(0,100,500));
                            $mnav_wrap.css({opacity:0});
                            $mnav_tap.removeClass('mnav-tab-click');
                        }
                    }else{
                        if(flag){
                            $magazine_nav.stop().animate({top:0},1000,"easeInOutExpo");
                        }else{
                            $magazine_nav.stop().animate({top:'100%'},1000,"easeInOutExpo");
                        }
                    }
                },10);
            }

            //global function add
            MagazineNaviOpen = function(){
                if(navi_open)return;
                magazine_navi_open(true);
            }
            MagazineNaviClose = function(){
                if(!navi_open)return;
                magazine_navi_open(false);
            }

            MagazineNaviHidden = function(){
                $magazine_nav.css({display:'none'});
            }

            MagazineNaviView = function(){
                $magazine_nav.css({display:'block'});   
            }

            MagazineNaviStatus = function(){
                return navi_open;
            }

            function thumbActive(id){
                if(issue_changing || !navi_open)return;
                for(var o in thumb_wraps){
                    if(o > 0){
                        var thumb   = thumb_wraps[o].inner;
                            opacity = 1,
                            css3 = {tx:0,ty:0,tz:0};
                        var scale = 1;
                        if(o == id){
                            opacity = 1;
                            css3.tz = 100;
                            scale = 1.1;
                        }else if(id == 0){
                            opacity = 1;
                        }else{
                            opacity = .5;
                            css3.tz = -200;
                            scale = 0.9;
                        }

                        if(modCSSTransforms && modCSSTransitions){
                            thumb.css({opacity:opacity});
                            if(UA.isIE){
                                thumb.css(css3_scale(scale));
                            }else{
                                thumb.css(css3_XYZ(css3.tx,css3.ty,css3.tz));    
                            }
                        }else{
                            thumb.stop().animate({opacity:opacity},600,'easeOutQuint');
                        }
                    }
                }
            }

            function issueNaviActive(id){
                $(".mnav-issue-navi").each(function(i){
                    var navi = $(this).find('img'),
                        css  = {opacity:1},
                        css3 = {tx:0,ty:0,tz:0};

                    if(id-1 == i){
                        css3.tz = 300;
                    }else{
                        css.opacity = 0.3;
                    }


                    if(modCSSTransforms && modCSSTransitions){
                        navi.css(css3_XYZ(css3.tx,css3.ty,css3.tz));
                        navi.css(css);
                    }else{
                        navi.stop().animate(css,600,'easeOutQuint');
                    }
                });
            }

            function issueChange(id){
                // if(issue_changing || issue_current == id)return;
                var class_name  = id<issue_current?'filp-l':'filp-r';
                issue_current   = id;
                issue_changing  = true;

                for(var o in thumb_wraps){
                    var outer = thumb_wraps[o].outer,
                        thumb = thumb_wraps[o].thumb;
                    if(o != 0){
                        anim_thumb_flip(outer,o,class_name);
                        anim_thumb_move(thumb,o,-issue_current*200);
                    }
                }

                if(modCSSTransforms && modCSSTransitions){
                    $mnav_issue_currents.css(css3_XYZ(80*(id-1),0,0));
                    anim_thumb_flip($mnav_issue_current_inner,0,'filp');
                }else{
                    $mnav_issue_currents.stop().animate({left:80*(id-1)});
                    // anim_thumb_flip($mnav_issue_current_inner,0,'filp');
                }
            }

            var change_delay = 35;
            function anim_thumb_flip(element,id,className){
                var delay;
                if(modCSSTransforms && modCSSTransitions)delay = id*change_delay;
                else delay = 0;
                setTimeout(function(){
                    element.addClass(className);
                    setTimeout(function(){element.removeClass(className)},1600);
                },delay);

            }
            function anim_thumb_move(element,id,posX){
                var delay;
                if(modCSSTransforms && modCSSTransitions)delay = id*change_delay;
                else delay = 0;
                setTimeout(function(){
                    var returnDelay = 1600
                    if(modCSSTransforms && modCSSTransitions){
                        element.css(css3_XYZ(posX,0,0));
                    }else{
                        returnDelay = 1000;
                        element.stop().animate({left:posX+"px"},700,"easeInOutExpo");
                    }
                    
                    if(id==14){
                        setTimeout(function(){
                            issue_changing = false;
                        },returnDelay)
                    }
                },delay);
            }
            function issueChangeEnd(element){
                element.removeClass('issueChange');
            }
        };

        /* ************************************************************
            alarmScroll Setting
        ************************************************************ */
        function alarmScrollSet(){
            if(typeof $("#alarm-scroll")[0] != 'undefined'){
                var alarm       = $("#alarm-scroll"),
                    direct      = alarm.data("scroll-direct"),
                    delay       = alarm.data("scroll-delay"),
                    div         = '',
                    browser3D   = Modernizr.csstransforms3d?1:0,
                    timer       = null,
                    isView      = false;

                if(delay<1000){
                    delay = "1000";
                }
                if(direct == "down"){
                    alarm.addClass("alarm-direct-down");
                    div =   '<div id="alarm-scroll-wrap">'+
                                '<img src="images/scroll-bg.png" width="40" height="40">'+
                                '<img src="images/scroll-arrow-down.png" class="scroll-arr-shape" width="17" height="12">'+
                            '</div>'

                }else if(direct == "up"){
                    alarm.addClass("alarm-direct-up");
                    div =   '<div id="alarm-scroll-wrap">'+
                                '<img src="images/scroll-bg.png" width="40" height="40">'+
                                '<img src="images/scroll-arrow-up.png" class="scroll-arr-shape" width="17" height="12">'+
                            '<div>'
                }


                alarm.append(div);
                var alarm_wrap = $("#alarm-scroll-wrap").css({display:"none"}),
                    alarm_arr1  = alarm_wrap.find(".scroll-arr-shape").css({top:"30%",opacity:0}),
                    css3        = {z:1.5};

                if(browser3D){
                    // alarm.css(css3DSet(1000,'50%','50%'));
                    alarm_wrap.css(css3_scale(css3.z));
                }

                setTimeout(function(){addEvent()},500);

                /* function */

                function addEvent(){
                    $(document).on('mousewheel',function(){
                        alarmCheck();
                    })

                    $(window).keydown(function(e){
                        if(e.keyCode == 38 || e.keyCode == 40){
                            alarmCheck();
                        }
                    });

                    if(modTouch){
                        $(document).on("touchend", function(){
                            alarmCheck();
                        });
                    }
                }

                function alarmCheck(){
                    if(isView){
                        hidden();
                    }
                    // if(atHome)return;
                    if(timer)clearTimeout(timer);
                    timer = setTimeout(function(){
                        view();
                        clearInterval(timer);
                    },delay);    
                }

                function view(){
                    isView = true;
                    alarm_wrap.stop().fadeIn(1000,"easeOutQuint",function(){
                        if(UA.isIE8)alarm_arr1.stop().fadeIn(0);
                        if(direct == "down")animation1(alarm_arr1);
                        else animation2(alarm_arr1);
                    });

                    if(browser3D){
                        $(css3).stop(true).delay(100).animate( {z:1}, { 
                            step : function(now,fx){
                                alarm_wrap.css(css3_scale(fx.elem.z));
                            },
                            duration : 1300, 
                            easing : "easeInOutBack"
                        });
                    };
                }

                function hidden(){
                    isView = false;
                    alarm_wrap.stop().fadeOut(1000,"easeOutExpo",function(){
                        alarm_arr1.stop(true).css({opacity:0});
                    });
                    if(UA.isIE8)alarm_arr1.stop().fadeOut(0);
                    
                    if(browser3D){
                        $(css3).stop(true).animate( {z:1.5}, { 
                            step : function(now,fx){
                                alarm_wrap.css(css3_scale(fx.elem.z));
                            },
                            duration : 1000, 
                            easing : "easeInOutBackAlarm"
                        });
                    }
                }

                function animation1(arr){
                    arr.stop().delay(400).css({top:"30%",opacity:0}).animate({top:"50%",opacity:1},300,"swing").animate({top:"70%",opacity:0},800,"easeInOutBack",function(){
                        animation1(arr);
                    });
                }

                function animation2(arr){
                    arr.stop().delay(400).css({top:"70%",opacity:0}).animate({top:"50%",opacity:1},300,"swing").animate({top:"30%",opacity:0},800,"easeInOutBack",function(){
                        animation2(arr);
                    });
                }
                // alarm.css({})
                view();
            }
        }

        jQuery.extend( jQuery.easing,{
            easeInOutBackAlarm: function (x, t, b, c, d, s) {
                if (s == undefined) s = 1.90158;
                return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
            }
        });

        /* ************************************************************
            local storage 
        ************************************************************ */
        // var localData = {
        //     get     : function(key){return localStorage.getItem(key)},
        //     set     : function(key,value){localStorage.setItem(key, value)},
        //     clear   : function(){localStorage.clear()}
        // }

        function cacheCheck(){
            var location    = "magazine/",//+Math.random(),//window.location.pathname,
                t           = new Date(),
                date        = t.getFullYear()+""+t.getMonth()+""+t.getDate(),
                cache       = true;
            if(localStorage.getItem(location) == null){
                localStorage.setItem(location,date);
                cache = false;
            }else{
                if(localStorage.getItem(location) != date){
                    cache = false;
                    localStorage.setItem(location,date);
                }
            }

            // localStorage.clear();
            return cache;
        }

        magazinNavibSetting();
        imgLoad();    
    });


})(this, jQuery);


/* ************************************************************
    CSS3 
************************************************************ */
function css3_scale(scale){
    var css3 = "scale("+scale+")";
    return{
        "-webkit-transform" : css3,
        "-moz-transform"    : css3,
        "-o-transform"      : css3,
        "-ms-transform"     : css3,
        "transform"         : css3
    };
}

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

function css3_XYZ2(tx,ty,tz){
    var css3 = "translateZ("+tz+"px) translateX("+tx+"px) translateY("+ty+"%)"
    return{
        "-webkit-transform" : css3,
        "-moz-transform"    : css3,
        "-o-transform"      : css3,
        "-ms-transform"     : css3,
        "transform"         : css3
    };
}

function css3_ROTATE_Z(tz,rx,ry,rz){
    var css3 = "translateZ("+tz+"px) rotateX("+rx+"deg) rotateY("+ry+"deg) rotateZ("+rz+"deg)"
    return{
        "-webkit-transform" : css3,
        "-moz-transform"    : css3,
        "-o-transform"      : css3,
        "-ms-transform"     : css3,
        "transform"         : css3
    };
}

function css3DSet(perspective,originX,originY){
    var perspective = perspective+"px",
        style       = "preserve-3d",
        orign       = originX+" "+originY;
        css         = { "-webkit-perspective"   : perspective,
                        "-moz-perspective"      : perspective,
                        "-o-perspective"        : perspective,
                        "-ms-perspective"       : perspective,
                        "perspective"           : perspective,

                        // "-webkit-transform-style"   : style,
                        // "-moz-transform-style"      : style,
                        // "-o-transform-style"        : style,
                        // "-ms-transform-style"       : style,
                        // "transform-style"           : style,

                        "-webkit-perspective-origin"    : orign,
                        "-moz-perspective-origin"       : orign,
                        "-o-perspective-origin"         : orign,
                        "-ms-perspective-origin"        : orign,
                        "-transform-perspective-origin" : orign
                        }
    return css
}


/* util.js v 1.2.7 Copyright (c) 2013 SHIFTBRAIN Inc. Licensed under the MIT license. https://github.com/devjam */
(function() {
    if (this.console == null) {this.console = { log : function() {}}
    }
    if(this.UA)return;
    this.UA = function() {
        var e, t, n, r;
        r = navigator.userAgent.toLowerCase();
        t = {
            isIE : false,
            isIE6 : false,
            isIE7 : false,
            isIE8 : false,
            isIE9 : false,
            isLtIE9 : false,
            isIOS : false,
            isIPhone : false,
            isIPad : false,
            isIPhone4 : false,
            isIPad3 : false,
            isAndroid : false,
            isAndroidMobile : false,
            isChrome : false,
            isSafari : false,
            isMozilla : false,
            isWebkit : false,
            isOpera : false,
            isPC : false,
            isTablet : false,
            isSmartPhone : false,
            browser : r
        };
        if (t.isIE = /msie\s(\d+)/.test(r)) {
            n = RegExp.$1;
            n *= 1;
            t.isIE6 = n === 6;
            t.isIE7 = n === 7;
            t.isIE8 = n === 8;
            t.isIE9 = n === 9;
            t.isLtIE9 = n < 9
        }
        if (t.isIE7 && r.indexOf("trident/4.0") !== -1) {
            t.isIE7 = false;
            t.isIE8 = true
        }
        if (t.isIPhone = /i(phone|pod)/.test(r)) {
            t.isIPhone4 = window.devicePixelRatio === 2
        }
        if (t.isIPad = /ipad/.test(r)) {
            e = window.devicePixelRatio === 2
        }
        t.isIOS = t.isIPhone || t.isIPad;
        t.isAndroid = /android/.test(r);
        t.isAndroidMobile = /android(.+)?mobile/.test(r);
        t.isPC = !t.isIOS && !t.isAndroid;
        t.isTablet = t.isIPad || t.isAndroid && t.isAndroidMobile;
        t.isSmartPhone = t.isIPhone || t.isAndroidMobile;
        t.isChrome = /chrome/.test(r);
        t.isWebkit = /webkit/.test(r);
        t.isOpera = /opera/.test(r);
        t.isMozilla = r.indexOf("compatible") < 0 && /mozilla/.test(r);
        t.isSafari = !t.isChrome && t.isWebkit;
        return t
    }();
}).call(this);

