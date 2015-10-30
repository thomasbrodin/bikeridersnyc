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
														 <div class="bigbg" style="background-image:url('<?php echo $image['large']['src']; ?>')"></div>
														 <div id="caption">
															 <div class="container">
																 <p class="legende"><?php echo $image['title']; ?></p>
															 </div>
														 </div>
													 </li>
												<?php endforeach;
										} else { ?><img src="<?php bloginfo('template_directory'); ?>/images/image-needed.png" alt="Image Needed" />
										<?php }  ?>
							</ul>

						</div><!--/ .flexslider -->

						<div id="controls" class="container">

						</div><!--/ #controls -->

				</div><!--/ #feature -->

		<div class="splash">
			<div class="middle">
				<div class="inner">
					<div class="container">
						<h1>
							<span class="icon-logo">
								<?php
									if(isset($bk['logo_home']) && $bk['logo_home']) {
									 echo "<img src='" .$bk['logo_home']. "'>";
									 }
								?>
							</span>
							<?php
								if(isset($bk['link_1']) && $bk['link_1']) {
								 echo "<a href='" .$bk['link_1']. "'>".$bk['title_1']. "</a>";
								 }
								if(isset($bk['link_2']) && $bk['link_2']) {
									echo "<a href='" .$bk['link_2']. "'>" .$bk['title_2']. "</a>";
								}
							?>
						</h1>
					</div>
				</div>
			</div>
		</div>

<?php get_footer();?>
