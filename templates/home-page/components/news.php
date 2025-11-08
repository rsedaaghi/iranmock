<?php
$excerptMaxLength = 100;

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

    <!-- Desktop Grid -->

    <div class="row justify-content-center d-none d-md-flex">
        <?php if ($news_query->have_posts()): ?>
            <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
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
        <?php else: ?>
            <p class="text-center">No news found in this category.</p>
        <?php endif; ?>
    </div>

    <!-- Mobile Scroll -->
    <div class="news-scroll d-md-none">
        <div class="news-scroll-wrapper">
            <?php if ($news_query->have_posts()): ?>
                <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
                    <div class="news-scroll-card">
                        <div class="card text-center h-100 custom-news-card">
                            <div class="card-img-wrapper">
                                <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) ?>"
                                    class="card-img-top" alt="<?= esc_attr(get_the_title()) ?>">
                            </div>
                            <div class="card-body">
                                <p class="news-label mb-2"><?= esc_html(get_the_title()) ?></p>
                                <?php
                                $excerpt = get_the_excerpt();
                                $trimmedExcerpt = mb_strlen($excerpt) > $excerptMaxLength
                                    ? mb_substr($excerpt, 0, $excerptMaxLength) . '...'
                                    : $excerpt;
                                ?>
                                <?php
                                $excerpt = get_the_excerpt();
                                $mobileExcerptMaxLength = 60; // or 50, depending on your layout
                                $trimmedExcerptMobile = mb_strlen($excerpt) > $mobileExcerptMaxLength
                                    ? mb_substr($excerpt, 0, $mobileExcerptMaxLength) . '...'
                                    : $excerpt;
                                ?>
                                <p class="news-description my-3"><?= esc_html($trimmedExcerptMobile) ?></p> <a
                                    href="<?= esc_url(get_permalink()) ?>" class="btn btn-success">
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
</div>