<?php
/*
Template Name: Review Page
*/
get_header();
the_post();
?>

		<div class="bg" style="text-align: left">
				<div class="container">

						<div class="twelve columns">
							<div class="headline">
								<span class="logo"></span>
								<h2>
										<?php $top_title = get_post_meta($post->ID, 'top_title', true);
										if($top_title != '') echo $top_title; else the_title();?>
								</h2>
							</div>

								<div id="review-banner">
										 <div class="container">
												<div class="three columns">
														<img class="scale-with-grid" src="<?php bloginfo('template_directory'); ?>/images/stamp-review.png">
												</div>
												 <div class="nine columns">
														<p><span class="highlight">These reviews are from verified customers</span><br>
																<span>Take a few minutes and give us your feedback.<br>
																<a href="http://www.yelp.com/biz/bikeriders-brooklyn" target="_blank">Post your review<span class="arrow">→</span></a></span></p>
												</div>
										</div>
								</div>
					 </div>

						<div class="page-content review">
											<div id="fs-embed-02mzIQXjyr"></div>
						</div>
						<div class="wrap-back">
								<a id="back-to-top" href="#top" title="Back to top">
										<i class="angle-up"></i>
										<span>Back to top</span>
								</a>
							</div>
				</div>
		</div>

		<div class="separator2">
						<div class="bg bg3"></div>
		</div>

<script type="text/javascript">
	(function() {(window.$fs || (window.$fs = [])).push([ "embed", {"root":"fs-embed-02mzIQXjyr","host":"bikeridersnyc.fullslate.com","reviews":"all"} ]);
			if (!window.$fs._isFullSlate) {
					var fsscr = document.createElement("script");
					fsscr.type = "text/javascript";fsscr.async = true;
					fsscr.src = ["http", (document.location.protocol == "https:" ? "s" : ""), "://bikeridersnyc.fullslate.com/api.js"].join("");
					var other = document.getElementsByTagName("script")[0];
					other.parentNode.insertBefore(fsscr, other);
			}
	})();
</script>
<?php get_footer();?>
