
<?php 
/*
Template Name: Full Slate Mechanical
*/
get_header();
the_post(); 
global $bk;
?>


  <div class="bg" style="text-align: left">
    <div class="container">
              <div class="sixteen columns">
                <div class="headline">
                        <h2>  <span class="logo"></span>
                                <?php $top_title = get_post_meta($post->ID, 'top_title', true); 
                                if($top_title != '') 
                                    echo $top_title; 
                                else the_title();?>                     
                        </h2>
                </div>
              <div class="single">

             <!--  <div class="ribbon-wrapper-scheduling">
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
               </div> -->
                         
                <?php the_content();?>
                <div id="fs-embed-HuTK1cCRi6"></div>

                 <?php $special_title = get_post_meta($post->ID, 'special_title', true);
                    if ($special_title) : echo '<h6 class="special">'.$special_title.'</h6>'; endif; ?>

                <p class="agreement">BIKERIDERS Customer Service will confirm your appointment via email within 24 hours. All BIKERIDERS Appointments must be confirmed by email prior to the scheduled appointment time.
                      If you do not receive an email, please contact us at <?php if(isset($bk['email']) && $bk['email'] != '') { ?><a href="mailto:<?php echo $bk['email'];?>"><?php echo encEmail($bk['email']);?></a><?php } ?> 
                      or call at <?php if(isset($bk['phone']) && $bk['phone'] != '') { ?><a href="tel:<?php echo $bk['phone'];?>"><?php echo $bk['phone'];?></a><?php } ?>
                </p>
            </div>
          </div>
    </div>
  </div>
  <div class="separator2">
    <div class="bg bg3"></div>
  </div>

<script type="text/javascript">
(function() {(window.$fs || (window.$fs = [])).push([ "embed", {"root":"fs-embed-HuTK1cCRi6","host":"bikeridersnyc.fullslate.com","category":11} ]);
  if (!window.$fs._isFullSlate) { 
    var fsscr = document.createElement("script"); 
    fsscr.type = "text/javascript";fsscr.async = true; 
    fsscr.src = ["http", (document.location.protocol == "https:" ? "s" : ""), "://bikeridersnyc.fullslate.com/api.js"].join("");
    var other = document.getElementsByTagName("script")[0];
    other.parentNode.insertBefore(fsscr, other); 
  }
})();
</script>

<?php get_footer();?>