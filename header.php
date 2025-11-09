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

	<div id="wrapper">
		<header class="container-xxl no-gutter-sm my-2 mt-sm-5 mb-sm-1">
			<nav id="header"
				class="navbar justify-content-center <?php echo esc_attr($navbar_scheme); ?> container-fluid">

				<!-- Mobile Header -->
				<div class="row w-100 align-items-center d-flex d-md-none px-3">
					<!-- Brand -->
					<div class="col">
						<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>">
							<?php
							$header_logo = get_theme_mod('header_logo');
							echo !empty($header_logo)
								? '<img src="' . esc_url($header_logo) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />'
								: esc_attr(get_bloginfo('name', 'display'));
							?>
						</a>
					</div>

					<!-- Register Button -->
					<div class="col-auto">
						<a href="<?php echo esc_url(wp_registration_url()); ?>"
							class="btn btn-success text-nowrap w-100">
							<?php esc_html_e(esc_html(iranmock_translate('panel_login')), 'iranmock-bootstrap'); ?>
						</a>
					</div>
				</div>

				<!-- Desktop Header -->
				<div class="row w-100 align-items-center d-none d-md-flex">
					<!-- Brand -->
					<div class="col-auto">
						<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>">
							<?php
							$header_logo = get_theme_mod('header_logo');
							echo !empty($header_logo)
								? '<img src="' . esc_url($header_logo) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />'
								: esc_attr(get_bloginfo('name', 'display'));
							?>
						</a>
					</div>

					<!-- Menu -->
					<div class="col-auto">
						<?php
						wp_nav_menu([
							'menu_class'     => 'navbar-nav flex-row',
							'container'      => '',
							'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
							'walker'         => new WP_Bootstrap_Navwalker(),
							'theme_location' => 'main-menu',
						]);
						?>
					</div>

					<!-- Search -->
					<?php if ('1' === $search_enabled) : ?>
						<div class="col">
							<form class="search-form d-flex align-items-center justify-content-start" role="search"
								method="get" action="<?php echo esc_url(home_url('/')); ?>">
								<div class="input-group justify-content-end">
									<input type="text" name="s" class="form-control"
										placeholder="<?php esc_attr_e(esc_html(iranmock_translate('search')), 'iranmock-bootstrap'); ?>"
										title="<?php esc_attr_e(esc_html(iranmock_translate('search')), 'iranmock-bootstrap'); ?>" />
								</div>
							</form>
						</div>
					<?php endif; ?>

					<!-- Register Button -->
					<div class="col-auto">
						<a href="<?php echo esc_url(wp_registration_url()); ?>"
							class="btn btn-success w-100 text-nowrap">
							<?php esc_html_e(esc_html(iranmock_translate('panel_login')), 'iranmock-bootstrap'); ?>
						</a>
					</div>
				</div>
			</nav>
		</header>

		<main id="main" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
						elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
						endif; ?>>