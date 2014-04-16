<?php 

get_header();

global $bk;

the_post(); 

$options = get_post_meta($post->ID, 'vp_ptemplate_settings', true);

?>

 <div class="bg" style="text-align: left">

    <div class="container">

        <div class="sixteen columns">

            <h2><span class="lines"> <?php single_tag_title(); ?> </span></h2>

            <?php

            global $query_string;

            $paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

            query_posts($query_string . '&posts_per_page=5&paged=' . $paged);

            $i = 1;

            if(have_posts()) : while(have_posts()) : the_post(); ?>

                <div <?php post_class('article'); ?>>

                    <h3 style="margin-bottom: 5px"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

                    <p class="line2nd meta">

                        <?php _e('Posted on', 'bk');?> <?php the_time("d M Y");?> 

                        in <?php the_category(', ') ?> | 

                        <?php comments_popup_link(esc_html__('0 comments','Tharsis'), esc_html__('1 comment','Tharsis'), '% '.esc_html__('comments','Tharsis')); ?>

                    </p>

                    <?php the_excerpt(); ?>

                    <a href="<?php the_permalink();?>"><div class="button1">Read More</div></a>

                </div>

            <?php endwhile; 

            get_template_part('includes/pagination');

            endif; wp_reset_query();?>

        </div> <!-- end sixteen columns -->

    </div>

    <div class="sixteen columns">
        <div class="copyright">
            <p>&copy; <?php the_time("Y");?> <?php _e('All Rights Reserved', 'bk');?>, <?php _e('designed by ', 'bk');?> <a href="http://teothemes.com">TeoThemes</a></p>
        </div>
    </div>

</div>

<?php get_footer();?>