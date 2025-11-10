			</main><!-- /#main -->
			<footer id="footer" class="text-white pt-5">
				<div class="container">
					<div class="row">
						<!-- Column 1: Footer Menu 1 (Desktop only) -->
						<div class="col-md-4 mb-4 d-none d-md-block">
							<?php
							$menu_1 = wp_get_nav_menu_object(get_nav_menu_locations()['footer-menu-1'] ?? '');
							if ($menu_1) {
								echo '<h5 class="footer-menu-title">' . esc_html($menu_1->name) . '</h5>';
								wp_nav_menu([
									'theme_location' => 'footer-menu-1',
									'container'      => false,
									'menu_class'     => 'nav flex-column',
									'walker'         => new WP_Bootstrap4_Navwalker_Footer(),
									'link_before'    => '<span class="footer-menu-item">',
									'link_after'     => '</span>',
								]);
							} else {
								echo '<h5 class="footer-menu-title">&nbsp;</h5>';
							}
							?>
						</div>

						<!-- Column 2: Footer Menu 2 (Desktop only) -->
						<div class="col-md-4 mb-4 d-none d-md-block">
							<?php
							$menu_2 = wp_get_nav_menu_object(get_nav_menu_locations()['footer-menu-2'] ?? '');
							if ($menu_2) {
								echo '<h5 class="footer-menu-title">' . esc_html($menu_2->name) . '</h5>';
								wp_nav_menu([
									'theme_location' => 'footer-menu-2',
									'container'      => false,
									'menu_class'     => 'nav flex-column',
									'walker'         => new WP_Bootstrap4_Navwalker_Footer(),
									'link_before'    => '<span class="footer-menu-item">',
									'link_after'     => '</span>',
								]);
							} else {
								echo '<h5 class="footer-menu-title">&nbsp;</h5>';
							}
							?>
						</div>

						<!-- Column 3: Contact Us (Desktop only) -->
						<div id="contact-us" class="col-md-4 mb-4 d-none d-md-block">
							<h5 class="footer-menu-title">تماس با ما</h5>
							<p class="small">شما میتواند از طریق راه‌های ارتباطی زیر با ما در تماس باشد.</p>
							<div class="d-flex gap-3 mt-3 justify-content-start">
								<?php
								$social_query = new WP_Query([
									'post_type'      => 'social',
									'posts_per_page' => -1,
									'post_status'    => 'publish',
								]);

								if ($social_query->have_posts()) :
									while ($social_query->have_posts()) : $social_query->the_post();
										$settings = get_field('social_account_settings');
										$link = $settings['url'] ?? '';
										$icon = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');

										if ($link && $icon) :
								?>
											<a href="<?= esc_url($link) ?>" target="_blank" rel="noopener">
												<img src="<?= esc_url($icon) ?>" alt="<?= esc_attr(get_the_title()) ?>" class="social-icon">
											</a>
								<?php
										endif;
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
						</div>

						<!-- Mobile View: Only Contact Us Centered -->
						<div class="col-12 text-center mb-4 d-block d-md-none">
							<h5 class="footer-menu-title">تماس با ما</h5>
							<p class="small">شما میتواند از طریق راه‌های ارتباطی زیر با ما در تماس باشد.</p>
							<div class="d-flex justify-content-center gap-3 mt-3">
								<?php
								$social_query = new WP_Query([
									'post_type'      => 'social',
									'posts_per_page' => -1,
									'post_status'    => 'publish',
								]);

								if ($social_query->have_posts()) :
									while ($social_query->have_posts()) : $social_query->the_post();
										$settings = get_field('social_account_settings');
										$link = $settings['url'] ?? '';
										$icon = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');

										if ($link && $icon) :
								?>
											<a href="<?= esc_url($link) ?>" target="_blank" rel="noopener">
												<img src="<?= esc_url($icon) ?>" alt="<?= esc_attr(get_the_title()) ?>" class="social-icon">
											</a>
								<?php
										endif;
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
						</div>
					</div>

					<!-- Separator -->
					<hr class="bg-white my-4">

					<!-- Copyright -->
					<div class="row">
						<div class="col text-center">
							<p class="small mb-0">
								<?php printf(esc_html__('© %1$s %2$s. All rights reserved.', 'iranmock-bootstrap'), wp_date('Y'), get_bloginfo('name', 'display')); ?>
							</p>
						</div>
					</div>
				</div>
			</footer>
			<!-- /#footer -->
			</div><!-- /#wrapper -->
			<?php
			wp_footer();
			?>
			</body>

			</html>