jQuery(document).ready(function($) {
        var root = $('html, body');
        $('a.smoothy').click(function() {
           var href = $.attr(this, 'href');
           root.stop().animate({
               scrollTop: $(href).offset().top
           }, 500, function () {
               window.location.hash = href;
           });
           return false;
        });
          $('.featurepost .m_item_inner').bind('mouseenter',function() {
          var height = $(this).children('img').height();
          var width = $(this).children('img').width();
          $(this).children('.m_overlay').css({'height':height, 'width':width});
          $(this).children('.m_overlay').animate({'opacity':'1'},'fast');
        }).bind('mouseleave',function() {
          $(this).children('.m_overlay').animate({'opacity':'0'},'slow');
        }); 
        // var isInIFrame = (window.location != window.parent.location) ? true : false;
        //   if(isInIFrame) {
        //     $('body').addClass('iframe');
        //   }
        //   $("nav li.icon").click(function(e){
        //     e.preventDefault();
        //     $("#sciframe").slideToggle('3000', "swing");
        //   });
        //header nav slider
          var nav_index;
           $("#primary-nav li.menu-item").hover(function(){
             $("#primary-nav .indicator").addClass("on");
              nav_index == $('#primary-js-slider').attr('class');
              var slider_class = $(this).attr("data-index");
              $("#primary-js-slider").removeClass().addClass(slider_class);
            }, function(){
              $('#primary-js-slider').removeClass().addClass(nav_index);
               $("#primary-nav .indicator").removeClass("on");
            });
            $("#primary-nav li.menu-item").click(function(){
              nav_index = $("#primary-js-slider").attr("class");
            });
          
            //subnav slider
          var subnav_index;
            $("#secondary-nav li.menu-item").hover(function(){
              subnav_index = $("#js-slider").attr("class");
              var index = $(this).attr("data-index");
              $("#js-slider").removeClass().addClass(index);
            }, function(){
              $("#js-slider").removeClass().addClass(subnav_index);
            });

            $("#secondary-nav li.menu-item").click(function(){
              subnav_index = $("#js-slider").attr("class");
            });
        
          // nth-child selectors (fallback for browsers that don't support CSS3 nth-child
          $('.columns article:nth-child(2n+1)').addClass('alpha');
          $('.columns article:nth-child(2n+2)').addClass('omega');     
         
          var jPM = $.jPanelMenu({
              menu: '#mobile',
              trigger: '#mobile-open',
              animated: false,
              openPosition: '200px',
            });
          
          var $window = $(window);
          var jPMisOn=false;
          var Tagtostrip = $("body");
          var togglejPM =function (){
              if($window.innerWidth() < 568 && !jPMisOn) {
                 jPM.on(),
                 Tagtostrip.attr("data-menu-position");
                 jPMisOn=true;
              } else if ($window.innerWidth() > 568 && jPMisOn) {
                jPM.off(),
                Tagtostrip.removeAttr("data-menu-position");
                jPMisOn=false;
              }
          }
          window.resizeFunction = function(){
              clearTimeout(timer);
              var timer = window.setTimeout(togglejPM, 500);
          }
          
          $window.on('resize', resizeFunction);
          if($window.innerWidth() < 568 && !jPMisOn) togglejPM();
         
         jQuery('.flexslider').flexslider({
            controlsContainer: "#controls",
            animation: "fade",
            slideshow: false,
            slideshowSpeed: 7000,
            animationSpeed: 1000
          });
          if(($(window).width()) < 767) { // Do nothing
            } else {
               jQuery('.appointment').fancybox({
                  padding   : 0,
                  fitToView : true,
                  maxWidth  : '1000px',
                  minHeight : '700px',
                  width   : '100%', 
                  autoSize  : false,
                  autoCenter  : true,
                  openEffect  : 'none',
                  closeEffect : 'none',
                  tpl     : {
                    closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;">CLOSE</a>',
                  }
                });
            }
});