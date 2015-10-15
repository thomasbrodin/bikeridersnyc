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
				//Quote slider
				if ($('.reviews-slider').length > 0 ){
					$('#quote-slider').cycle({
						fx: 'scrollHorz',
						easing: 'easeInOutExpo',
						prev: '.quote-nav-left a',
						next: '.quote-nav-right a',
						timeout: 5000
					});
				}
				if ($('#back-to-top').length > 0 ){
					$('#back-to-top').click(function() {
						$('html, body').animate({scrollTop: 0}, 700);
						return false;
					});
				}
				//header nav slider
				 $("#primary-nav li.menu-item a").hover(function(){
					 indicatorWidth = $(this).innerWidth();
					 indicatorLeft = $(this).offset();
					 $("#primary-nav .indicator").addClass("on");
						$("#primary-js-slider").css({
							'width' : indicatorWidth,
							'margin-left': indicatorLeft.left
						});
					}, function(){
						 $("#primary-nav .indicator").removeClass("on");
					});
					//subnav slider
					$("#secondary-nav li.menu-item a").hover(function(){
						indicatorWidth = $(this).innerWidth();
						indicatorLeft = $(this).offset();
						$("#js-slider").css({
							'width' : indicatorWidth,
							'margin-left': indicatorLeft.left
						});
					});
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

				 $('.flexslider').flexslider({
						controlsContainer: "#controls",
						animation: "fade",
						slideshow: false,
						slideshowSpeed: 7000,
						animationSpeed: 1000
					});
});
