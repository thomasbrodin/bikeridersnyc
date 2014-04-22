
<?php 
/*
Template Name: Appointment Page
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

<?php get_footer();?>