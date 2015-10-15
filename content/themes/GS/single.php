<?php

get_header();

the_post();

?>

 <div class="bg" style="text-align: left">

		<div class="container">
			<div class="row">
				<div class="headline">
					<span class="logo"></span>
					<h2>
							<?php $top_title = get_post_meta($post->ID, 'top_title', true);
							if($top_title != '') echo $top_title; else the_title();?>
					</h2>
				</div>

				<div class="twelve columns">

						<?php the_content();?>

						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Tharsis').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

						<div class="tags">

							 <?php the_tags(esc_attr('Tags: ', 'bk') . '<div class="button1">', '</div> <div class="button1">', '</div><br />'); ?>

						</div>

						<?php

						edit_post_link(); ?>

				 </div>

			</div>
		</div>

</div>

<?php get_footer();?>
