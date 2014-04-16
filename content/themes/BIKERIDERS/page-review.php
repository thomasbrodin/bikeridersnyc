<?php 
/*
Template Name: Review Page
*/
get_header(); 
the_post(); 
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

                <div id="review-banner">
                     <div class="container">
                        <div class="three columns">
                            <img class="scale-with-grid" src="<?php bloginfo('template_directory'); ?>/images/stamp-review.png">
                        </div>
                         <div class="ten columns offset-by-two ">
                            <p><span class="highlight">These reviews are from verified customers</span><br>
                                <span>Take a few minutes and use our survey below to give us your feedback.<br>
                                <a href="#survey" class="smoothy">Take our survey<span class="arrow">→</span></a></span></p>
                        </div>
                    </div>
                </div>
           </div>

            <div class="single">
                      <?php the_content();?>
                      
            </div>
        </div>
    </div>

    <div class="separator2">
            <div class="bg bg3"></div>
    </div>

    <div id="survey">
        <div class="container">
            <div class="sixteen columns">
                <h2><span class="logo"></span>
                            POST YOUR REVIEW              
                </h2>
            </div>
            <div class="sixteen columns">
                <?php echo do_shortcode( '[contact-form-7 id="899" title="Survey"]' ); ?>
            </div>
        </div> <!-- end container -->      
    </div> <!-- end survey -->

    
<?php get_footer();?>