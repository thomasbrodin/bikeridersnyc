<?php
/* 
Template name: Blog page template
*/

get_header();
global $bk;
the_post(); 
$options = get_post_meta($post->ID, 'vp_ptemplate_settings', true);
$fullwidth = isset($options['fullwidth']) ? $options['fullwidth'] : '1';
?>
 <div class="bg" style="text-align: left">
    <div class="container">
        <div class="sixteen columns">
            <div class="headline">
                    <h2><span class="logo"></span>
                        <?php $top_title = get_post_meta($post->ID, 'top_title', true); if($top_title != '') echo $top_title; else the_title();?></h2>
            </div>
        </div>
        <!-- start sixteen columns -->
        <div class="<?php if($fullwidth == 0) echo 'eleven'; else echo 'sixteen';?> columns">
            <?php
            $args['posts_per_page'] = $options['blog_posts'];
            if($options['categories'] != '')
                 $args['category__in'] = $options['categories'];
            $paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
            $args['paged'] = $paged;
            query_posts($args);
            $i = 1;
            if(have_posts()) : while(have_posts()) : the_post(); ?>
                <div <?php post_class('article'); ?>>
                    <h3 style="margin-bottom: 5px"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                    <p class="line2nd meta">
                        <?php _e('Posted on', 'bk');?> <?php the_time("d M Y");?> 
                    </p>
                    
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink();?>"><div class="button1">Read More</div></a>
                </div>
            <?php endwhile; 
            get_template_part('includes/pagination');
            endif; wp_reset_query();?>
        </div> <!-- end sixteen columns -->

        <!-- start sidebar -->
        <div class="five columns sidebar">
            <?php 
            if($fullwidth == 0) 
                dynamic_sidebar("Right sidebar");
            ?>
        </div>
        <!-- end sidebar -->

    </div>
</div>
<?php get_footer();?>