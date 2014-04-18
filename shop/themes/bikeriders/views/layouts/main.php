<!DOCTYPE html>
<html lang="<?= Yii::app()->language ?>">
	<!-- <head> section -->
	<?php echo $this->renderPartial("/site/_head",null,true,false); ?>

	<body>
		<div id="wrapper">

			<?php echo $this->sharingHeader; ?>
			<!-- template header -->
			<?php echo $this->renderPartial("/site/_header",null,true,false); ?>

			<div id="container" class="container">

				<!-- Require the navigation -->
				<?php echo $this->renderPartial("/site/_navigation",null,true,false); ?>

				<!-- content (viewport) -->
				<?php echo $content; ?>

			</div>

		</div>

		<!-- footer -->
		<?php echo $this->renderPartial("/site/_footer",null,true,false); ?>
		<?php echo $this->sharingFooter; ?>

		<?php echo $this->loginDialog; ?>

    <script type='text/javascript' src='https://bikeridersnyc.com/wp-content/themes/BIKERIDERS/js/jquery.fancybox.js'></script>
		<script type='text/javascript' src='https://bikeridersnyc.com/wp-content/themes/BIKERIDERS/js/jquery.jpanelmenu.min.js'></script>
		<script type='text/javascript'>
    jQuery(document).ready(function($) {
        // var isInIFrame = (window.location != window.parent.location) ? true : false;
        //   if(isInIFrame) {
        //     $('body').addClass('iframe');
        //   }
        //   $("nav li.icon").click(function(e){
        //     e.preventDefault();
        //     $("#sciframe").slideToggle('3000', "swing");
        //   })
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
          if(($(window).width()) < 767) { // Do nothing
            } else {
               $('.appointment').fancybox({
                  padding   : 0,
                  fitToView : true,
                  maxWidth  : '900px',
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
            $('#menuside').affix({
                    offset: {
                      top: 85,
                      bottom: 312
                    }
             });
		});
		</script>

    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39529740-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>
</html>