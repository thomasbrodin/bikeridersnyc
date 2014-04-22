<?php  

/*
Template Name: Home Page
*/

global $bk;
get_header(); ?>    

        <div id="feature">
                <?php 
                function bt_get_attachments() {
                    global $post, $attachments;
                    $args = array(
                        'post_type' => 'attachment',
                        'numberposts' => -1,
                        'post_status' => null,
                        'post_parent' => $post->ID,
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                        );
                    $attachments = get_posts($args);

                    return $attachments;
                }
                function bt_get_image_attachments() {
                $attachments = bt_get_attachments();
                $results = array();
                    foreach ($attachments as $attachment) {
                        if (!preg_match('@^image/@', $attachment->post_mime_type)) continue;
                        $sizes = get_intermediate_image_sizes();
                        $image['title'] = $attachment->post_excerpt;
                        $image['url'] = get_post_meta($attachment->ID,'_wp_attachment_image_alt', true);
                        foreach ($sizes as $size) {
                        list($src, $w, $h) = wp_get_attachment_image_src($attachment->ID, 'full');
                        $image[$size] = compact('src', 'w', 'h');
                        }
                    $results[] = $image;
                    }
                return $results;
                }
            $images = bt_get_image_attachments(); ?>

            <div class="flexslider<?php if ($images) {} else { echo ' no-image'; } ?>">
              <ul class="slides">
                <?php                    
                    if ($images) { ?>             
                        <?php foreach ($images as $image) : ?>
                           <li class="slide">
                            <a href="<?php echo $image['url']; ?>">
                                <img src="<?php echo $image['large']['src']; ?>"/>
                                <span class="container caption"><?php echo $image['title']; ?></span>
                            </a>
                           </li>
                        <?php endforeach; 
                    } else { ?><img src="<?php bloginfo('template_directory'); ?>/images/image-needed.png" alt="Image Needed" />
                    <?php }  ?>
              </ul>
            
            </div><!--/ .flexslider -->
            
            <div id="controls" class="container">
                 
            </div><!--/ #controls -->

        </div><!--/ #feature -->
   
     
    <div class="container">
        
        <div class="sixteen columns">     
            <div class="title">
                <?php if(isset($bk['topheader_smalltext']) && $bk['topheader_smalltext']) { ?>
                    <h1 class="small"><?php echo $bk['topheader_smalltext'];?></h1>
                <?php } ?>
                <div class="intro-line"></div>
                <?php if(isset($bk['topheader_smallertext']) && $bk['topheader_smallertext']) { ?>
                    <p><?php echo $bk['topheader_smallertext'];?><div class="buttonbook"><a class="appointment" href="appointment">BOOK NOW<span class="arrow">→</span></a></div></p>
                <?php } ?>
             </div> <!-- end title -->
         </div><!-- end columns -->
   
       <div class="sixteen columns featurepost">                  
            <?php global $post;
                $myposts = query_posts('orderby=menu_order&post_type=post&showposts=12&category=3');
                foreach($myposts as $post) : setup_postdata($post); ?>
                <article <?php post_class('m_item eight columns'); ?>>
                     <?php 
                    $special_title = get_post_meta($post->ID, 'special_title', true); 
                    $link_shop = get_post_meta($post->ID, 'link_shop', true); ?>

                    <div class="m_item_inner" onclick="window.location='<?php if ($link_shop) { echo $link_shop; } else { the_permalink(); } ?>'">
                        <div class="m_overlay <?php if ($special_title) : echo 'specials'; endif;?>">
                            <?php                           
                            if ($special_title) {
                                echo '<div class="ribbon-wrapper-home"><div class="ribbon-home">SPECIAL</div></div><h3>' .$special_title.'</h3>';
                                } else {
                                    the_title( '<h2>', '</h2>' );
                                } ?>    
                        </div>

                            <?php 
                                    if(has_post_thumbnail()) { 
                                        $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );
                                        echo '<img src="' . $image_src[0] . '" class="scale-with-grid"/>'; 
                                        } 
                                ?>
                            
                    </div>
                </article>
                <?php endforeach; ?>
        </div><!-- end columns -->


    </div><!-- end container -->

<?php get_footer();?>