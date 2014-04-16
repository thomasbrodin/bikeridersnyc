<?php
/* 
Template name: Full width page template
*/
get_header();
the_post(); 
?>
   <div class="bg">
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
                    
                    <?php edit_post_link(); ?>
               </div>
          </div>
      </div>
  </div>
  <div class="separator2">
      <div class="bg bg3"></div>
  </div>
  
<?php get_footer();?>