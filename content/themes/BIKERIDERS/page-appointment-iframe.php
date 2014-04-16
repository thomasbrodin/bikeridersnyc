
<?php 
/*
Template Name: Book Mechanical Service
*/
global $bk;
the_post();
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

	<head>
       <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
         <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/base.css"  media="screen" />
         <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/skeleton.css"  media="screen" />
         <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.css"  media="screen" />
         <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/forms.css"  media="screen" />
	</head>

    <body <?php body_class();?>>
        <div id="mobile">
            <div id="mobile-nav">
                    <a href="<?php echo home_url(); ?>" target="_parent"><span class="logo-w"></span></a>
                        <?php wp_nav_menu( array(
                                            'theme_location' => 'mobile-menu',
                                             ) ); ?>
            </div>
        </div>
        <header>
            <div class="container overlay">
                <a href="#menu" id="mobile-open">Open Menu</a>
                <h1 id="title" class="four columns"><a href="<?php echo home_url(); ?>" target="_parent">BIKERIDERS</a></h1> 
            </div>
            <div class="container overlay">
                     <div id ="tagline" class="sixteen columns">   
                            <p> <?php echo get_bloginfo( 'description' ); ?></p>
                    </div>
            </div>
        </header>
        <div class="ribbon-wrapper-scheduling">
          <div class="ribbon-scheduling">
            <p><span>FREE DELIVERY</span>
              Add these quality products to your order!</p>
          </div>
        </div>
         <div id="slideshow-wrap">
            <a href="#" id="prev">Prev</a>
            
            <div class="slideshow vertical" 
                        data-cycle-fx=carousel
                        data-cycle-timeout=2000
                        data-cycle-next="#next"
                        data-cycle-prev="#prev" 
                        data-cycle-carousel-visible=6
                        data-cycle-carousel-fluid=true 
                        data-cycle-slides="> a"
                        data-cycle-carousel-vertical=true>
                <a href="//bikeridersnyc.com/shop/brand/3t" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/3T.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/bikeriders" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/bikeriders.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/bont" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/bont.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/cinelli" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/cinelli.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/cobb" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/cobb.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/craft" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/craft.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/defeet" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/defeet.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/shimano" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/duraace.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/fizik" target="_parent"<img src="//bikeridersnyc.com/wp-content/uploads/2013/12/fizik.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/gore" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/gore.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/lazer" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/lazer.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/lizard-skins" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/lizardskins.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/ritte" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/ritte.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/selle-italia" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/selleitalia.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/skratch" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/skratch.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/sportique" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/Sportique-Logo.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/x-lab" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/xlab.jpg"></a>
                <a href="//bikeridersnyc.com/shop/brand/zipp" target="_parent"><img src="//bikeridersnyc.com/wp-content/uploads/2013/12/zipp.jpg"></a>
            </div>

            <a href="#" id="next">Next</a>  
         </div>
         <div class="container overlay">

            <div class="eight columns">
                  <h2 class='pickup'>  
                    <span class="logo"></span> 
                    <?php the_title();?>             
                  </h2>
                  <span class="highlight headings">
                    <?php $temp = get_post_meta($post->ID, 'vp_settings', true);?>
                    <?php if(isset($temp['slogan']) && $temp['slogan'] != '') echo $temp['slogan'];?>
                  </span>
                          
                  <?php the_content();?>

                  <p class="location"><span class="homefee">&nbsp;Any of the above services as a home visit or at an alternate location will add a fee of $100.</span><br>
                    <strong>*</strong>&nbsp;Our studio is located at <?php if(isset($bk['address']) && $bk['address'] != '') { ?><?php echo $bk['address'];?><?php } ?>
                    &nbsp;→&nbsp;<?php if(isset($bk['contact_map']) && $bk['contact_map'] != '') { ?><a href="<?php echo esc_attr($bk['contact_map']);?>" target="_blank">MAP IT</a><?php } ?><br>
               Having trouble with the form? Please contact us at <?php if(isset($bk['email']) && $bk['email'] != '') { ?><a href="mailto:<?php echo $bk['email'];?>"><?php echo encEmail($bk['email']);?></a><?php } ?> 
                      or call at <?php if(isset($bk['phone']) && $bk['phone'] != '') { ?><a href="tel:<?php echo $bk['phone'];?>"><?php echo $bk['phone'];?></a><?php } ?>
            </p>
            </div>

            <div class="eight columns">
                <script type="text/javascript">
                    var app_path = "/scheduler";
                    var schedule_form = "service_form";
                    var schedule_form_id = "service_form";
                    </script>
                    <script type="text/javascript" src="/scheduler/scheduler.js"></script>

                    <div id="service_form">[scheduling form will load here]</div>
             </div>
             
        </div>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle2.min.js"></script>
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle2.carousel.min.js"></script>
      <script>$.fn.cycle.defaults.autoSelector = '.slideshow';</script>
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.jpanelmenu.min.js"></script>
      <script type="text/javascript">
        jQuery(document).ready(function($) {
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
        });
      </script>
</body>
</html>