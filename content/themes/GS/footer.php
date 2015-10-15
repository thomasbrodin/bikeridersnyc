 <?php global $bk; ?>

</div><!-- end WRAPPER-->

 <footer class="dark-bg">
				<div class="container">
					<div class="row">

						<div class="five columns">
							<h4 class="footer">Gruppo Stelvio Update</h3>
								 <!-- Begin MailChimp Signup Form -->
									<div id="signup">
										<form action="http://bikeridersnyc.us3.list-manage.com/subscribe/post?u=9dfa7266bb43e2f4dac1ace05&amp;id=9d86a6955b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

												<input type="email" placeholder="Email Address" name="EMAIL" class="required email" id="mce-EMAIL">

												<input type="text" placeholder="Zip Code" name="MMERGE4" class="required" id="mce-MMERGE4">

												<input type="submit" value="JOIN&nbsp;→" name="subscribe" id="mc-embedded-subscribe" class="button">

												<div id="mce-responses" class="clear">
													<div class="response" id="mce-error-response" style="display:none"></div>
													<div class="response" id="mce-success-response" style="display:none"></div>
												</div>
												<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
												<div style="position: absolute; left: -5000px;"><input type="text" name="b_9dfa7266bb43e2f4dac1ace05_9d86a6955b" value=""></div>

											</form>
										<p>Sign up to get the latest on sales, new releases and more …</p>
								</div>
							<!--End mc_embed_signup-->
						</div> <!-- end five columns -->

						<div class="three columns">
							 <h4 class="footer">Address</h4>
								<?php if(isset($bk['address']) && $bk['address'] != '') { ?><p><?php echo $bk['address'];?><?php } ?>
								<?php if(isset($bk['city']) && $bk['city'] != '') { ?><br><?php echo $bk['city'];?></p><?php } ?>
								<?php if(isset($bk['contact_map']) && $bk['contact_map'] != '') { ?> <p><a href="<?php echo esc_attr($bk['contact_map']);?>" target="_blank">Map it</a></p><?php } ?>

						</div> <!-- end menu footer -->

						<div class="two columns none">
									 <h4 class="footer">More Info</h4>
								 <?php wp_nav_menu( array(
																				'theme_location' => 'footer-menu',
																				)
																	) ?>
						</div> <!-- end menu footer -->

						<div class="two columns social">
								<h4 class="footer"> Find Us</h4>
								<ul>
										<?php if(isset($bk['twitter_username'])  && $bk['twitter_username'] != '') { ?><li><a href="http://twitter.com/<?php echo $bk['twitter_username'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-twitter2.png" alt="Twitter icon" /></a></li><?php } ?>
										<?php if(isset($bk['facebook_url'])  && $bk['facebook_url'] != '') { ?><li><a href="<?php echo $bk['facebook_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-facebook2.png" alt="Facebook icon" /></a></li><?php } ?>
								</ul>
								<ul>
										<?php if(isset($bk['tumblr_url']) && $bk['tumblr_url'] != '') { ?><li><a href="<?php echo $bk['tumblr_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-tumblr.png" alt="Tumblr icon" /></a></li><?php } ?>
										<?php if(isset($bk['instagram_url']) && $bk['instagram_url'] != '') { ?><li><a href="<?php echo $bk['instagram_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-instagram.png" alt="instagram icon" /></a></li><?php } ?>
								</ul>
						</div> <!-- end social -->

					</div><!-- end row -->

					<div class="row copyright">

						<div class="five columns">
								<span><p>&copy; <?php the_time("Y");?> <?php _e('All Rights Reserved - Gruppo Stelvio', 'bk');?></p></span>
						</div>

						<div class="three columns">
							<?php if(isset($bk['phone']) && $bk['phone'] != '') { ?><p><a href="tel:<?php echo $bk['phone'];?>"><?php echo $bk['phone'];?></a></p><?php } ?>
						</div>
						<div class="two columns">
							<?php if(isset($bk['email']) && $bk['email'] != '') { ?><p><a href="mailto:<?php echo $bk['email'];?>"><?php echo encEmail($bk['email']);?></a></p><?php } ?>
						</div>
						<div class="two columns">
							<p><a class="none" href="http://hexcreativenetwork.com" target="_blank">Site by HEX</a></p>
						</div>

					</div><!-- end row -->
				</div> <!-- end container -->

		</footer> <!-- end footer -->



<?php global $bk;
if(isset($bk['integration_footer'])) echo $bk['integration_footer'] . PHP_EOL; ?>

 <?php wp_footer(); ?>

</body>
</html>
