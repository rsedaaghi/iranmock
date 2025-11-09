<?php

/**
 * The Template for displaying Category Archive pages.
 */

get_header();

$category = get_queried_object();
$image = get_field('image', $category);
$excerptMaxLength = 100;

$category_query = new WP_Query([
	'post_type'      => 'post',
	'posts_per_page' => 12,
	'post_status'    => 'publish',
	'cat'            => $category->term_id
]);
?>



<div class="container category-page mt-3 mb-3 my-md-5 ">
	<?php if (!empty($image)) : ?>
		<div class="container-xxl no-gutter-sm img-wrapper">
			<img src="<?= esc_url($image) ?>" alt="<?= esc_attr($category->name) ?>" class="featured-img" />
		</div>
	<?php endif; ?>

	<div class="row category-header-row">
		<div class="col text-center">
			<h2 class="section-title mb-4">
				<?= esc_html(iranmock_translate($category->name)); ?>
			</h2>
			<hr class="suggested-exams-hr">
		</div>

	</div>
	<?php
	$category_description = category_description();
	if (!empty($category_description)) :
		echo '<div class="text-center mb-4 category-archive-meta">' . esc_html($category_description) . '</div>';
	endif;
	?>

	<!-- Desktop Grid -->
	<div class="row bg-white pt-5 pb-4 justify-content-center d-none d-md-flex">
		<?php if ($category_query->have_posts()) : ?>
			<?php while ($category_query->have_posts()) : $category_query->the_post(); ?>
				<div class="col-auto mb-4">
					<div class="card text-center h-100 custom-news-card">
						<div class="card-img-wrapper">
							<img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) ?>" class="card-img-top"
								alt="<?= esc_attr(get_the_title()) ?>">
						</div>
						<div class="card-body">
							<p class="news-label mb-2"><?= esc_html(get_the_title()) ?></p>
							<?php
							$excerpt = get_the_excerpt();
							$trimmedExcerpt = mb_strlen($excerpt) > $excerptMaxLength
								? mb_substr($excerpt, 0, $excerptMaxLength) . '...'
								: $excerpt;
							?>
							<p class="news-description my-3"><?= esc_html($trimmedExcerpt) ?></p>
							<a href="<?= esc_url(get_permalink()) ?>" class="btn btn-success mb-3">
								<?= esc_html(iranmock_translate('view')); ?>
							</a>
						</div>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		<?php else : ?>
			<p class="text-center">No posts found in this category.</p>
		<?php endif; ?>
	</div>

	<!-- Mobile Grid: Two Columns -->
	<div class="row bg-white pt-4 pb-2 d-md-none">
		<?php if ($category_query->have_posts()) : ?>
			<?php while ($category_query->have_posts()) : $category_query->the_post(); ?>
				<div class="col-6 mb-4">
					<div class="card text-center h-100 custom-news-card">
						<div class="card-img-wrapper">
							<img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) ?>" class="card-img-top"
								alt="<?= esc_attr(get_the_title()) ?>">
						</div>
						<div class="card-body">
							<p class="news-label mb-2"><?= esc_html(get_the_title()) ?></p>
							<?php
							$excerpt = get_the_excerpt();
							$mobileExcerptMaxLength = 60;
							$trimmedExcerptMobile = mb_strlen($excerpt) > $mobileExcerptMaxLength
								? mb_substr($excerpt, 0, $mobileExcerptMaxLength) . '...'
								: $excerpt;
							?>
							<p class="news-description my-3"><?= esc_html($trimmedExcerptMobile) ?></p>
							<a href="<?= esc_url(get_permalink()) ?>" class="btn btn-success">
								<?= esc_html(iranmock_translate('view')); ?>
							</a>
						</div>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>

</div>

<?php get_footer(); ?>