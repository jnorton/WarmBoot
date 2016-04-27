	<header class="navbar navbar-default">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="navbar-header">
							<?php if ( is_front_page() && $_SERVER['REQUEST_URI'] == "/" ) : ?>
							<div class="navbar-brand">
								<div class="logo"></div>
								<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>
							</div>
							<?php else: ?>
							<a href="<?php echo site_url(); ?>" class="navbar-brand">
								<div class="logo"></div>
								<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>
							</a>
							<?php endif; ?>
						</div>

						<div class="nav-toggle">
							<button class="navbar-toggle" data-target="#navbar" data-toggle="collapse" type="button">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
						</div>

				</div>
				<div class="col-md-8">
					<div id="navbar" class="collapse navbar-collapse">
						<?php
							wp_nav_menu( array(
							    'theme_location' => 'primary-menu', //note you need to create this
							    'menu_class' => 'nav navbar-nav',
							    'items_wrap' => '%3$s',
							    'container' => 'ul',
							    )
							);
						?>
						<div class="navbar-right search">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /container -->
	</header>