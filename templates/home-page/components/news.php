<?php
$news_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'category_name'  => 'news' // Use the category slug here
]);
?>

<div class="large-container bg-white my-5 py-3">
    <h2 class="text-center mb-4">
        <?= esc_html(iranmock_translate('related_news')); ?>
    </h2>
    <div class="row justify-content-center">
        <?php if ($news_query->have_posts()): ?>
            <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
                <div class="col-auto mb-4">
                    <div class="card text-center h-100 custom-news-card">
                        <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) ?>" class="card-img-top"
                            alt="<?= esc_attr(get_the_title()) ?>">
                        <div class="card-body">
                            <p class="news-title mb-3"><?= esc_html(get_the_title()) ?></p>
                            <p class="news-description my-3"><?= esc_html(get_the_excerpt()) ?></p>
                            <a href="<?= esc_url(get_permalink()) ?>" class="btn btn-success my-3">
                                <?= esc_html(iranmock_translate('view')); ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        <?php else: ?>
            <p class="text-center">No news found in this category.</p>
        <?php endif; ?>
    </div>
</div>