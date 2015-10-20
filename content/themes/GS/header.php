<?php global $bk; ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html style="margin-top: 0 !important" class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html style="margin-top: 0 !important" class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html style="margin-top: 0 !important" class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <!--<![endif]-->
<html style="margin-top: 0 !important" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title> <?php if ( is_single() ) { bloginfo('name'); print ' - '; single_post_title(); }
				elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' - '; bloginfo('description'); }
				elseif ( is_page() ) {  bloginfo('name'); print ' - '; single_post_title(''); }
				elseif ( is_search() ) { bloginfo('name'); print ' - Search results for ' . wp_specialchars($s); }
				elseif ( is_404() ) { bloginfo('name'); print ' - Not Found'; }
				else { bloginfo('name'); wp_title('-'); } ?></title>
		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--[if lt IE 9]>
				<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="https://use.typekit.net/tto3xtd.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>

		<?php global $bk;
		if(isset($bk['integration_header'])) echo $bk['integration_header'] . PHP_EOL;
		wp_head(); ?>

</head>

<body <?php body_class();?>>
		<div id="wrapper">
				 <?php $special_ribbon = get_post_meta($post->ID, 'special_ribbon', true);
				if ($special_ribbon) : echo '<div class="ribbon-wrapper-appointment"><div class="ribbon-appointment"><h3>'.$special_ribbon.'</h3></div></div>'; endif; ?>
				<!-- mobile nav-->

						<div id="mobile">
								<div id="mobile-nav">
										 <a href="<?php echo home_url(); ?>"><span class="logo-w"></span></a>
												<?php wp_nav_menu( array(
																						'theme_location' => 'mobile-menu',
																						 ) ); ?>
								</div>
						</div>

				<header>
						<div class="container">

							<a href="#menu" id="mobile-open">
									<i class="hamburger"></i>
							</a>

							<div class="row">
								<?php
									$completeName = get_bloginfo('name');
									$nameParts = explode(" ", $completeName);
								?>
								<h1 id="title" class="four columns"><a href="<?php echo home_url(); ?>"><?php echo '<span>'.$nameParts[0].'</span> '.$nameParts[1]; ?></a></h1>

								 <nav id='primary-nav' class="eight columns">
									 <?php wp_nav_menu( array(
																						'theme_location' => 'main-menu',
																						'container' => '',
																						'walker' => new primary_walker(),
																						'depth' => 1 ) ); ?>
									<div class="indicator">
											<div id="primary-js-slider"></div>
									</div>
								</nav><!-- primary nav-->

							</div>
							<div class="row">
								<div id ="tagline" class="four columns">
									<?php
									$desc = get_bloginfo( 'description' );
									$tagline = get_post_meta($post->ID, 'tagline', true);
									 if ($tagline != '') {
										 echo '<p>'.$tagline.'</p>';
									 } else {
										 echo '<p>'.$desc.'</p>';
									 } ?>
								</div>
								<nav id='secondary-nav' class="eight columns">
									<?php
										if ( is_page_template('page-service.php') ) {
												wp_nav_menu( array(
																'theme_location' => 'service-menu',
																'container' => '',
																'walker' => new secondary_walker(),
																'depth' => 1 ) );

											} elseif ( is_page_template('page-team.php') ) {
												wp_nav_menu( array(
																'theme_location' => 'team-menu',
																'container' => '',
																'walker' => new secondary_walker(),
																'depth' => 1 ) );
											} elseif ( is_page_template('page-about.php') ) {
											 wp_nav_menu( array(
																'theme_location' => 'about-menu',
																'container' => '',
																'walker' => new secondary_walker(),
																'depth' => 1 ) );
											} else { } ?>
										<div class="indicator">
												<div id="js-slider"></div>
										</div>
									</nav>
								</div>
							</div><!-- container -->
				</header>	<!-- header -->
