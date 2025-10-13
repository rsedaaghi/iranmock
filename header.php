<!DOCTYPE html>
<!-- <html <?php
			// language_attributes();
			?>> -->
<html dir='rtl'>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<!-- <body <?php
			// body_class();
			?>> -->

<body>
	<?php wp_body_open(); ?>

	<a href="#main"
		class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'iranmock-bootstrap'); ?></a>

	<div id="wrapper">
		<header class="container-md mt-5">
			<nav id="header" class="navbar navbar-expand-md <?php echo esc_attr($navbar_scheme);
															if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' fixed-top';
															elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' fixed-bottom';
															endif;
															if (is_home() || is_front_page()) : echo ' home';
															endif; ?>">
				<div class="container w-100">
					<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>"
						title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<?php
						$header_logo = get_theme_mod('header_logo'); // Get custom meta-value.

						if (! empty($header_logo)) :
						?>
							<img src="<?php echo esc_url($header_logo); ?>"
								alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
						<?php
						else :
							echo esc_attr(get_bloginfo('name', 'display'));
						endif;
						?>
					</a>

					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
						aria-controls="navbar" aria-expanded="false"
						aria-label="<?php esc_attr_e('Toggle navigation', 'iranmock-bootstrap'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div id="navbar" class="collapse navbar-collapse justify-content-between">
						<?php
						// Loading WordPress Custom Menu (theme_location).
						wp_nav_menu(
							array(
								'menu_class'     => 'navbar-nav',
								'container'      => '',
								'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
								'walker'         => new WP_Bootstrap_Navwalker(),
								'theme_location' => 'main-menu',
							)
						);

						if ('1' === $search_enabled) :
						?>
							<form class="search-form my-2 my-lg-0 d-flex align-items-center" role="search" method="get"
								action="<?php echo esc_url(home_url('/')); ?>">
								<div class="input-group">
									<input type="text" name="s" class="form-control mx-4"
										placeholder="<?php esc_attr_e(esc_html(iranmock_translate('search')), 'iranmock-bootstrap'); ?>"
										title="<?php esc_attr_e(esc_html(iranmock_translate('search')), 'iranmock-bootstrap'); ?>" />
								</div>
								<a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn-success">
									<?php esc_html_e(esc_html(iranmock_translate('register')), 'iranmock-bootstrap'); ?>
								</a>
							</form>
						<?php
						endif;
						?>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container -->
			</nav><!-- /#header -->
		</header>

		<main id="main" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
						elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
						endif; ?>>
			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page).
			if (is_single() || is_archive()) :
			?>
				<div class="row">
					<div class="col-md-8 col-sm-12">
					<?php
				endif;
					?>