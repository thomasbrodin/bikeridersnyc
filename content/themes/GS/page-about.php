<?php

/*
Template Name: About Page
*/

global $bk;

get_header(); ?>

<?php
		if ( ( $locations = get_nav_menu_locations() ) && $locations['about-menu'] ) {
				$menu = wp_get_nav_menu_object( $locations['about-menu'] );
				$menu_items = wp_get_nav_menu_items($menu->term_id);
				$include = array();
				foreach($menu_items as $item) {
						if($item->object == 'page')
								$include[] = $item->object_id;
				}
				query_posts( array( 'post_type' => 'page', 'post__in' => $include, 'posts_per_page' => count($include), 'orderby' => 'post__in' ) );
		}

		$i = 1;
		while(have_posts() ) : the_post(); ?>
				<?php $temp = get_post_meta($post->ID, 'vp_settings', true);?>
				<div class="bg <?php if(isset($temp['variation']) && $temp['variation'] == 2) echo 'dark-bg';?>" id="<?php echo $post->post_name;?>"
						<?php if(isset($temp['variation']) && $temp['variation'] == 3) { echo 'style="';
						if(isset($temp['background_color']) && $temp['background_color'] != '') echo 'background-color: #' . $temp['background_color'];
						else if(isset($temp['background']) && $temp['background'] != '') echo 'background-image: url(\'' . $temp['background'] . '\')'; echo '"'; } ?>>
						<div class="container">
								<div class="twelve columns">
												<div class="headline">
													<span class="logo"></span>
													<h2>
															<?php $top_title = get_post_meta($post->ID, 'top_title', true);
															if($top_title != '') echo $top_title; else the_title();?>
													</h2>
												</div>
								 </div> <!-- end twelve columns -->

								 <div class="clear"></div>

								<div class="twelve columns">
										<?php global $more; $more = 0; the_content('');?>
								</div> <!-- end twelve columns -->

						</div> <!-- end container -->
				</div> <!-- end bg -->
				<div id="separator_<?php echo $i;?>" class="separator1">
						<div class="bg<?php echo ($i+1); echo ' bg';?>" style="<?php if(isset($temp['slogan_bg']) && $temp['slogan_bg'] != '') echo 'background-image: url(\'' . $temp['slogan_bg'] . '\')';?> "></div>
						<p class="separator"><?php if(isset($temp['slogan']) && $temp['slogan'] != '') echo $temp['slogan'];?></p>
				</div>
		<?php $i++; endwhile; wp_reset_query(); ?>

		<?php get_footer();?>
