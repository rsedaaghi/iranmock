<?php

/**
 * Include Theme Customizer.
 *
 * @since v1.0
 */
$theme_customizer = __DIR__ . '/inc/customizer.php';
if (is_readable($theme_customizer)) {
	require_once $theme_customizer;
}

if (! function_exists('iranmock_bootstrap_setup_theme')) {
	/**
	 * General Theme Settings.
	 *
	 * @since v1.0
	 *
	 * @return void
	 */
	function iranmock_bootstrap_setup_theme()
	{
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
		load_theme_textdomain('iranmock-bootstrap', __DIR__ . '/languages');

		/**
		 * Set the content width based on the theme's design and stylesheet.
		 *
		 * @since v1.0
		 */
		global $content_width;
		if (! isset($content_width)) {
			$content_width = 800;
		}

		// Theme Support.
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Add support for Block Styles.
		add_theme_support('wp-block-styles');
		// Add support for full and wide alignment.
		add_theme_support('align-wide');
		// Add support for Editor Styles.
		add_theme_support('editor-styles');
		// Enqueue Editor Styles.
		add_editor_style('style-editor.css');

		// Default attachment display settings.
		update_option('image_default_align', 'none');
		update_option('image_default_link_type', 'none');
		update_option('image_default_size', 'large');

		// Custom CSS styles of WorPress gallery.
		add_filter('use_default_gallery_style', '__return_false');
	}
	add_action('after_setup_theme', 'iranmock_bootstrap_setup_theme');

	/**
	 * Enqueue editor stylesheet (for iframed Post Editor):
	 * https://make.wordpress.org/core/2023/07/18/miscellaneous-editor-changes-in-wordpress-6-3/#post-editor-iframed
	 *
	 * @since v3.5.1
	 *
	 * @return void
	 */
	function iranmock_bootstrap_load_editor_styles()
	{
		if (is_admin()) {
			wp_enqueue_style('editor-style', get_theme_file_uri('style-editor.css'));
		}
	}
	add_action('enqueue_block_assets', 'iranmock_bootstrap_load_editor_styles');

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
	remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');
}

if (! function_exists('wp_body_open')) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since v2.2
	 *
	 * @return void
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}

if (! function_exists('iranmock_bootstrap_add_user_fields')) {
	/**
	 * Add new User fields to Userprofile:
	 * get_user_meta( $user->ID, 'facebook_profile', true );
	 *
	 * @since v1.0
	 *
	 * @param array $fields User fields.
	 *
	 * @return array
	 */
	function iranmock_bootstrap_add_user_fields($fields)
	{
		// Add new fields.
		$fields['facebook_profile'] = 'Facebook URL';
		$fields['twitter_profile']  = 'Twitter URL';
		$fields['linkedin_profile'] = 'LinkedIn URL';
		$fields['xing_profile']     = 'Xing URL';
		$fields['github_profile']   = 'GitHub URL';

		return $fields;
	}
	add_filter('user_contactmethods', 'iranmock_bootstrap_add_user_fields');
}

/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 *
 * @global WP_Post $post Global post object.
 *
 * @return bool
 */
function is_blog()
{
	global $post;
	$posttype = get_post_type($post);

	return ((is_archive() || is_author() || is_category() || is_home() || is_single() || (is_tag() && ('post' === $posttype))) ? true : false);
}

/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 *
 * @param bool $open    Comments open/closed.
 * @param int  $post_id Post ID.
 *
 * @return bool
 */
function iranmock_bootstrap_filter_media_comment_status($open, $post_id = null)
{
	$media_post = get_post($post_id);

	if ('attachment' === $media_post->post_type) {
		return false;
	}

	return $open;
}
add_filter('comments_open', 'iranmock_bootstrap_filter_media_comment_status', 10, 2);

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Post Edit Link.
 *
 * @return string
 */
function iranmock_bootstrap_custom_edit_post_link($link)
{
	return str_replace('class="post-edit-link"', 'class="post-edit-link badge bg-secondary"', $link);
}
add_filter('edit_post_link', 'iranmock_bootstrap_custom_edit_post_link');

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Comment Edit Link.
 */
function iranmock_bootstrap_custom_edit_comment_link($link)
{
	return str_replace('class="comment-edit-link"', 'class="comment-edit-link badge bg-secondary"', $link);
}
add_filter('edit_comment_link', 'iranmock_bootstrap_custom_edit_comment_link');

/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 *
 * @param string $html Inner HTML.
 *
 * @return string
 */
function iranmock_bootstrap_oembed_filter($html)
{
	return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'iranmock_bootstrap_oembed_filter', 10);

if (! function_exists('iranmock_bootstrap_content_nav')) {
	/**
	 * Display a navigation to next/previous pages when applicable.
	 *
	 * @since v1.0
	 *
	 * @param string $nav_id Navigation ID.
	 */
	function iranmock_bootstrap_content_nav($nav_id)
	{
		global $wp_query;

		if ($wp_query->max_num_pages > 1) {
?>
			<div id="<?php echo esc_attr($nav_id); ?>" class="d-flex mb-4 justify-content-between">
				<div>
					<?php next_posts_link('<span aria-hidden="true">&larr;</span> ' . esc_html__('Older posts', 'iranmock-bootstrap')); ?>
				</div>
				<div>
					<?php previous_posts_link(esc_html__('Newer posts', 'iranmock-bootstrap') . ' <span aria-hidden="true">&rarr;</span>'); ?>
				</div>
			</div><!-- /.d-flex -->
			<?php
		} else {
			echo '<div class="clearfix"></div>';
		}
	}

	/**
	 * Add Class.
	 *
	 * @since v1.0
	 *
	 * @return string
	 */
	function posts_link_attributes()
	{
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter('next_posts_link_attributes', 'posts_link_attributes');
	add_filter('previous_posts_link_attributes', 'posts_link_attributes');
}

/**
 * Init Widget areas in Sidebar.
 *
 * @since v1.0
 *
 * @return void
 */
function iranmock_bootstrap_widgets_init()
{
	// Area 1.
	register_sidebar(
		array(
			'name'          => 'Primary Widget Area (Sidebar)',
			'id'            => 'primary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 2.
	register_sidebar(
		array(
			'name'          => 'Secondary Widget Area (Header Navigation)',
			'id'            => 'secondary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 3.
	register_sidebar(
		array(
			'name'          => 'Third Widget Area (Footer)',
			'id'            => 'third_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action('widgets_init', 'iranmock_bootstrap_widgets_init');

if (! function_exists('iranmock_bootstrap_article_posted_on')) {
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function iranmock_bootstrap_article_posted_on()
	{
		printf(
			wp_kses_post(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'iranmock-bootstrap')),
			esc_url(get_permalink()),
			esc_attr(get_the_date() . ' - ' . get_the_time()),
			esc_attr(get_the_date('c')),
			esc_html(get_the_date() . ' - ' . get_the_time()),
			esc_url(get_author_posts_url((int) get_the_author_meta('ID'))),
			sprintf(esc_attr__('View all posts by %s', 'iranmock-bootstrap'), get_the_author()),
			get_the_author()
		);
	}
}

/**
 * Template for Password protected post form.
 *
 * @since v1.0
 *
 * @global WP_Post $post Global post object.
 *
 * @return string
 */
function iranmock_bootstrap_password_form()
{
	global $post;
	$label = 'pwbox-' . (empty($post->ID) ? wp_rand() : $post->ID);

	$output                  = '<div class="row">';
	$output             .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">';
	$output             .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__('This content is password protected. To view it please enter your password below.', 'iranmock-bootstrap') . '</h4>';
	$output         .= '<div class="col-md-6">';
	$output     .= '<div class="input-group">';
	$output .= '<input type="password" name="post_password" id="' . esc_attr($label) . '" placeholder="' . esc_attr__('Password', 'iranmock-bootstrap') . '" class="form-control" />';
	$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__('Submit', 'iranmock-bootstrap') . '" /></div>';
	$output     .= '</div><!-- /.input-group -->';
	$output         .= '</div><!-- /.col -->';
	$output             .= '</form>';
	$output                 .= '</div><!-- /.row -->';

	return $output;
}
add_filter('the_password_form', 'iranmock_bootstrap_password_form');


if (! function_exists('iranmock_bootstrap_comment')) {
	/**
	 * Style Reply link.
	 *
	 * @since v1.0
	 *
	 * @param string $link Link output.
	 *
	 * @return string
	 */
	function iranmock_bootstrap_replace_reply_link_class($link)
	{
		return str_replace("class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $link);
	}
	add_filter('comment_reply_link', 'iranmock_bootstrap_replace_reply_link_class');

	/**
	 * Template for comments and pingbacks:
	 * add function to comments.php ... wp_list_comments( array( 'callback' => 'iranmock_bootstrap_comment' ) );
	 *
	 * @since v1.0
	 *
	 * @param object $comment Comment object.
	 * @param array  $args    Comment args.
	 * @param int    $depth   Comment depth.
	 */
	function iranmock_bootstrap_comment($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		switch ($comment->comment_type):
			case 'pingback':
			case 'trackback':
			?>
				<li class="post pingback">
					<p>
						<?php
						esc_html_e('Pingback:', 'iranmock-bootstrap');
						comment_author_link();
						edit_comment_link(esc_html__('Edit', 'iranmock-bootstrap'), '<span class="edit-link">', '</span>');
						?>
					</p>
				<?php
				break;
			default:
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<footer class="comment-meta">
							<div class="comment-author vcard">
								<?php
								$avatar_size = ('0' !== $comment->comment_parent ? 68 : 136);
								echo get_avatar($comment, $avatar_size);

								/* Translators: 1: Comment author, 2: Date and time */
								printf(
									wp_kses_post(__('%1$s, %2$s', 'iranmock-bootstrap')),
									sprintf('<span class="fn">%s</span>', get_comment_author_link()),
									sprintf(
										'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
										esc_url(get_comment_link($comment->comment_ID)),
										get_comment_time('c'),
										/* Translators: 1: Date, 2: Time */
										sprintf(esc_html__('%1$s ago', 'iranmock-bootstrap'), human_time_diff((int) get_comment_time('U'), current_time('timestamp')))
									)
								);

								edit_comment_link(esc_html__('Edit', 'iranmock-bootstrap'), '<span class="edit-link">', '</span>');
								?>
							</div><!-- .comment-author .vcard -->

							<?php if ('0' === $comment->comment_approved) { ?>
								<em class="comment-awaiting-moderation">
									<?php esc_html_e('Your comment is awaiting moderation.', 'iranmock-bootstrap'); ?>
								</em>
								<br />
							<?php } ?>
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'reply_text' => esc_html__('Reply', 'iranmock-bootstrap') . ' <span>&darr;</span>',
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
									)
								)
							);
							?>
						</div><!-- /.reply -->
					</article><!-- /#comment-## -->
	<?php
				break;
		endswitch;
	}

	/**
	 * Custom Comment form.
	 *
	 * @since v1.0
	 * @since v1.1: Added 'submit_button' and 'submit_field'
	 * @since v2.0.2: Added '$consent' and 'cookies'
	 *
	 * @param array $args    Form args.
	 * @param int   $post_id Post ID.
	 *
	 * @return array
	 */
	function iranmock_bootstrap_custom_commentform($args = array(), $post_id = null)
	{
		if (null === $post_id) {
			$post_id = get_the_ID();
		}

		$commenter     = wp_get_current_commenter();
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args($args);

		$req      = get_option('require_name_email');
		$aria_req = ($req ? " aria-required='true' required" : '');
		$consent  = (empty($commenter['comment_author_email']) ? '' : ' checked="checked"');
		$fields   = array(
			'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_html__('Name', 'iranmock-bootstrap') . ($req ? '*' : '') . '"' . $aria_req . ' />
							<label for="author">' . esc_html__('Name', 'iranmock-bootstrap') . ($req ? '*' : '') . '</label>
						</div>',
			'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_html__('Email', 'iranmock-bootstrap') . ($req ? '*' : '') . '"' . $aria_req . ' />
							<label for="email">' . esc_html__('Email', 'iranmock-bootstrap') . ($req ? '*' : '') . '</label>
						</div>',
			'url'     => '',
			'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__('Save my name, email, and website in this browser for the next time I comment.', 'iranmock-bootstrap') . '</label>
						</p>',
		);

		$defaults = array(
			'fields'               => apply_filters('comment_form_default_fields', $fields),
			'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__('Comment', 'iranmock-bootstrap') . ($req ? '*' : '') . '"></textarea>
											<label for="comment">' . esc_html__('Comment', 'iranmock-bootstrap') . '</label>
										</div>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf(wp_kses_post(__('You must be <a href="%s">logged in</a> to post a comment.', 'iranmock-bootstrap')), wp_login_url(esc_url(get_permalink(get_the_ID())))) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf(wp_kses_post(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'iranmock-bootstrap')), get_edit_user_link(), $user->display_name, wp_logout_url(apply_filters('the_permalink', esc_url(get_permalink(get_the_ID()))))) . '</p>',
			'comment_notes_before' => '<p class="small comment-notes">' . esc_html__('Your Email address will not be published.', 'iranmock-bootstrap') . '</p>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_submit'         => 'btn btn-primary',
			'name_submit'          => 'submit',
			'title_reply'          => '',
			'title_reply_to'       => esc_html__('Leave a Reply to %s', 'iranmock-bootstrap'),
			'cancel_reply_link'    => esc_html__('Cancel reply', 'iranmock-bootstrap'),
			'label_submit'         => esc_html__('Post Comment', 'iranmock-bootstrap'),
			'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'format'               => 'html5',
		);

		return $defaults;
	}
	add_filter('comment_form_defaults', 'iranmock_bootstrap_custom_commentform');
}

if (function_exists('register_nav_menus')) {
	/**
	 * Nav menus.
	 *
	 * @since v1.0
	 *
	 * @return void
	 */
	register_nav_menus([
		'main-menu-home'     => 'Main Navigation Menu Homepage',
		'main-menu'     => 'Main Navigation Menu',
		'footer-menu-1' => 'Footer Menu 1',
		'footer-menu-2' => 'Footer Menu 2',
	]);
}

// Custom Nav Walker: wp_bootstrap_navwalker().
$custom_walker = __DIR__ . '/inc/wp-bootstrap-navwalker.php';
if (is_readable($custom_walker)) {
	require_once $custom_walker;
}

$custom_walker_footer = __DIR__ . '/inc/wp-bootstrap-navwalker-footer.php';
if (is_readable($custom_walker_footer)) {
	require_once $custom_walker_footer;
}

/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 *
 * @return void
 */
function iranmock_bootstrap_scripts_loader()
{
	$theme_version = wp_get_theme()->get('Version');

	// 1. Styles.
	wp_enqueue_style('bootstrap-5.3.8', get_theme_file_uri('assets/bootstrap/css/bootstrap.min.css'), array(), $theme_version, 'all');
	wp_enqueue_style('glide-core', get_theme_file_uri('assets/glide/glide.core.min.css'), array(), $theme_version, 'all');
	wp_enqueue_style('glide-theme', get_theme_file_uri('assets/glide/glide.theme.min.css'), array(), $theme_version, 'all');
	wp_enqueue_style('style', get_theme_file_uri('style.css'), array(), $theme_version, 'all');

	// wp_enqueue_style('main', get_theme_file_uri('build/main.css'), array(), $theme_version, 'all'); // main.scss: Compiled Framework source + custom styles.

	if (is_rtl()) {
		wp_enqueue_style('rtl', get_theme_file_uri('build/rtl.css'), array(), $theme_version, 'all');
	}

	// 2. Scripts.
	wp_enqueue_script('bootstrap-5.3.8', get_theme_file_uri('assets/bootstrap/js/bootstrap.min.js'), array(), $theme_version, true);
	wp_enqueue_script('glide-js', get_theme_file_uri('assets/glide/glide.min.js'), array(), $theme_version, true);
	wp_enqueue_script('mainjs', get_theme_file_uri('assets/js/main.js'), array(), $theme_version, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'iranmock_bootstrap_scripts_loader');

// RSedaaghi

include_once('settings/cptAdminMenu/cptAdminMenu.php');

function iranmock_load_textdomain()
{
	load_theme_textdomain('iranmock-bootstrap', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'iranmock_load_textdomain');

function iranmock_get_dictionary()
{
	static $dictionary = null;
	if ($dictionary === null) {
		$dictionary = include get_template_directory() . '/settings/dictionary.php';
	}
	return $dictionary;
}

function iranmock_translate($key)
{
	// $locale = get_locale();
	// $lang = substr($locale, 0, 2);
	$lang = 'fa';
	$dictionary = iranmock_get_dictionary();

	return $dictionary[$lang][$key]
		?? $dictionary['en'][$key]
		?? $key;
}

// Seeder: Create News Category
// function seed_news_category()
// {
// 	if (!term_exists('news', 'category')) {
// 		wp_insert_term('News', 'category', [
// 			'slug' => 'news',
// 			'description' => 'Category for news-related posts'
// 		]);
// 	}
// }

// // Seeder: Create Default Pages
// function seed_default_pages()
// {
// 	$pages = [
// 		'About Us' => 'This is the About Us page.',
// 		'Contact' => 'This is the Contact page.',
// 		'FAQ' => 'This is the FAQ page.'
// 	];

// 	foreach ($pages as $title => $content) {
// 		if (!get_page_by_title($title)) {
// 			wp_insert_post([
// 				'post_title'   => $title,
// 				'post_content' => $content,
// 				'post_status'  => 'publish',
// 				'post_type'    => 'page'
// 			]);
// 		}
// 	}
// }

// // Seeder: Create Sample Post in News Category
// function seed_sample_news_post()
// {
// 	if (!get_posts(['name' => 'sample-news-post'])) {
// 		$news_category = get_term_by('slug', 'news', 'category');
// 		if ($news_category) {
// 			wp_insert_post([
// 				'post_title'   => 'Sample News Post',
// 				'post_name'    => 'sample-news-post',
// 				'post_content' => 'This is a sample news post.',
// 				'post_status'  => 'publish',
// 				'post_type'    => 'post',
// 				'post_category' => [$news_category->term_id]
// 			]);
// 		}
// 	}
// }

// // Create core pages
// function seed_core_pages()
// {
// 	$pages = [
// 		'Exams'      => 'This is the Exams page.',
// 		'Resources'  => 'This is the Resources page.',
// 		'Questions'  => 'This is the Questions page.',
// 		'Contact Us' => 'This is the Contact Us page.'
// 	];

// 	foreach ($pages as $title => $content) {
// 		if (!get_page_by_title($title)) {
// 			wp_insert_post([
// 				'post_title'   => $title,
// 				'post_content' => $content,
// 				'post_status'  => 'publish',
// 				'post_type'    => 'page'
// 			]);
// 		}
// 	}
// }

// // Create menu and assign pages to it
// function seed_main_menu()
// {
// 	$menu_name = 'Main Menu';
// 	$location_slug = 'main-menu'; // Matches your theme's register_nav_menus()

// 	// Check if menu exists
// 	$menu = wp_get_nav_menu_object($menu_name);

// 	if (!$menu) {
// 		$menu_id = wp_create_nav_menu($menu_name);

// 		// Add pages to menu
// 		$page_titles = ['Exams', 'Resources', 'Questions', 'Contact Us'];
// 		foreach ($page_titles as $title) {
// 			$page = get_page_by_title($title);
// 			if ($page) {
// 				wp_update_nav_menu_item($menu_id, 0, [
// 					'menu-item-title'     => $title,
// 					'menu-item-object'    => 'page',
// 					'menu-item-object-id' => $page->ID,
// 					'menu-item-type'      => 'post_type',
// 					'menu-item-status'    => 'publish'
// 				]);
// 			}
// 		}

// 		// Assign menu to theme location
// 		$locations = get_theme_mod('nav_menu_locations');
// 		$locations[$location_slug] = $menu_id;
// 		set_theme_mod('nav_menu_locations', $locations);
// 	}
// }

// function seed_exam_profile_archive_page()
// {
// 	if (!get_page_by_path('exam_profile')) {
// 		wp_insert_post([
// 			'post_title'   => 'Exam Profile Archive',
// 			'post_name'    => 'exam_profile',
// 			'post_content' => 'This page serves as the archive for Exam Profiles.',
// 			'post_status'  => 'publish',
// 			'post_type'    => 'page'
// 		]);
// 	}
// }

function run_site_seeder()
{
	// if (!get_option('site_seeder_ran')) {
	// seed_core_pages();
	// seed_main_menu();
	// seed_news_category();
	// seed_default_pages();
	// seed_sample_news_post();
	// update_option('site_seeder_ran', true);
	// }
	// seed_exam_profile_archive_page();
}
add_action('init', 'run_site_seeder');

// If you want to rerun the seeder, just reset the flag:
// delete_option('site_seeder_ran');

function make_exam_category_readonly_meta_box()
{
	remove_meta_box('exam_categorydiv', 'exam_profile', 'side');

	add_meta_box(
		'exam_category_readonly',
		__('Exam Categories'),
		'render_exam_category_readonly',
		'exam_profile',
		'side',
		'default'
	);
}
add_action('add_meta_boxes', 'make_exam_category_readonly_meta_box');

function render_exam_category_readonly($post)
{
	$terms = get_terms([
		'taxonomy' => 'exam_category',
		'hide_empty' => false,
	]);

	// Get the currently assigned term (assuming single selection)
	$selected_terms = wp_get_object_terms($post->ID, 'exam_category', ['fields' => 'ids']);
	$selected_id = !empty($selected_terms) ? $selected_terms[0] : null;

	if (!empty($terms)) {
		foreach ($terms as $term) {
			$checked = ($term->term_id == $selected_id) ? 'checked' : '';
			echo '<label style="display:block;">';
			echo '<input type="radio" name="exam_category" value="' . esc_attr($term->term_id) . '" ' . $checked . '> ';
			echo esc_html($term->name);
			echo '</label>';
		}
	}
}

function enqueue_dashicons()
{
	if (is_front_page() || is_single() || is_page()) { // Adjust conditions as necessary
		wp_enqueue_style('dashicons');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_dashicons');


	?>