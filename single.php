<?php get_header(); ?>

<?php
global $post;

// Get featured image
$image = get_the_post_thumbnail_url($post->ID, 'full');

// Get post title and content
$title = get_the_title($post);
$content = apply_filters('the_content', get_the_content());

// Check if post is in 'news' category and get news_lead
$news_lead = '';
if (has_category('news', $post)) {
	$news_lead = get_field('news_lead', $post->ID);
}
?>

<div class="exam-profile-page">
	<!-- Featured Image Section -->
	<?php if (!empty($image)) : ?>
		<div class="container-xxl no-gutter-sm">
			<div class="header-img-wrapper">
				<img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>" />
			</div>
		</div>
	<?php endif; ?>

	<!-- Label Section -->
	<div class="row justify-content-center mb-3">
		<div class="col-12 col-lg-10">
			<h1 class="exam-label text-center"><?= esc_html($title) ?></h1>
		</div>
	</div>

	<!-- Description Section -->
	<div class="exam-profile-description mx-auto py-5 px-3">
		<div class="exam-profile-quarter-circle"></div>
		<div class="col-12 col-lg-10 mx-auto px-5 text-justify">
			<?php if (!empty($news_lead)) : ?>
				<div class="description-text news-lead"><?= wp_kses_post($news_lead) ?><br></div>
			<?php endif; ?>
			<div class="description-text"><?= $content ?></div>
		</div>
	</div>
</div>

<?php get_footer(); ?>