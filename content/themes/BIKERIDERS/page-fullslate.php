
<?php 
/*
Template Name: Full Slate
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

                    <?php the_content();?>
                    
                    <div id="fs-embed-vvw2IIvtaz">
                     
                    </div>
                    <?php $special_title = get_post_meta($post->ID, 'special_title', true);
                     if ($special_title) : echo '<h6 class="special">'.$special_title.'</h6>'; endif; ?>

                    <p class="agreement">BIKERIDERS Customer Service will confirm your appointment via email within 24 hours. All BIKERIDERS Appointments must be confirmed by email prior to the scheduled appointment time.
                      If you do not receive an email, please contact us at <?php if(isset($bk['email']) && $bk['email'] != '') { ?><a href="mailto:<?php echo $bk['email'];?>"><?php echo encEmail($bk['email']);?></a><?php } ?> 
                      or call at <?php if(isset($bk['phone']) && $bk['phone'] != '') { ?><a href="tel:<?php echo $bk['phone'];?>"><?php echo $bk['phone'];?></a><?php } ?>
                    </p>

               </div>
               <div class="wrap-back">
                  <a id="back-to-top" href="#top" title="Back to top">
                      <i class="angle-up"></i>
                      <span>Back to top</span>
                  </a>
                </div>
          </div>
    </div>
  </div>
  <div class="separator2">
    <div class="bg bg3"></div>
  </div>


<script type="text/javascript">
(function() {
  (window.$fs || (window.$fs = [])).push([ "embed", {"root":"fs-embed-vvw2IIvtaz","host":"bikeridersnyc.fullslate.com"} ]);
  if (!window.$fs._isFullSlate) { 
    var fsscr = document.createElement("script"); 
    fsscr.type = "text/javascript";fsscr.async = true; 
    fsscr.src = ["http", (document.location.protocol == "https:" ? "s" : ""), "://bikeridersnyc.fullslate.com/api.js"].join("");
    var other = document.getElementsByTagName("script")[0]; 
    other.parentNode.insertBefore(fsscr, other); 
  }
})();
jQuery(document).ready(function($) {
    $('#back-to-top').click(function() {
      $('html, body').animate({scrollTop: 0}, 700);
      return false;
    });
});
</script>

<?php get_footer();?>