<?php
$excerptMaxLength = 100;

$news_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'category_name'  => 'news' // Use the category slug here
]);
?>

<div id="news" class="large-container bg-white mt-3 mb-5 py-3">
    <h2 class="text-center mt-2 mb-4 news-section-label">
        <?= esc_html(iranmock_translate('related_news')); ?>
    </h2>

    <!-- Desktop Grid -->
    <div class="row justify-content-center d-none d-md-flex">
        <div class="col-12 news-box-wrapper">
            <!-- Card container using flexbox -->
            <div class="d-flex flex-wrap justify-content-center gap-4">
                <?php if ($news_query->have_posts()): ?>
                    <?php
                    $count = 0;
                    while ($news_query->have_posts() && $count < 6): $news_query->the_post();
                    ?>
                        <div class="custom-news-card-wrapper mb-4">
                            <div class="card text-center custom-news-card">
                                <div class="card-img-wrapper">
                                    <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) ?>"
                                        class="card-img-top" alt="<?= esc_attr(get_the_title()) ?>">
                                </div>
                                <div class="card-body">
                                    <p class="news-label mb-2 make-block"><?= esc_html(get_the_title()) ?></p>
                                    <p class="news-description mt-1 mb-3">
                                        <?= esc_html(get_the_excerpt()) ?>
                                    </p>
                                    <a href="<?= esc_url(get_permalink()) ?>" class="btn btn-success mb-3">
                                        <?= esc_html(iranmock_translate('view')) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">No news found in this category.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Second row: left-aligned button -->
            <div class="row m2-4">
                <div class="col text-start">
                    <a href="<?= esc_url(get_category_link(get_category_by_slug('news')->term_id)) ?>"
                        class="btn btn-link see-all-btn px-0">
                        <?= esc_html(iranmock_translate('see_all') . ' ' . iranmock_translate('news')) ?>
                    </a>
                </div>
            </div>
        </div>
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
        <div class="d-flex justify-content-end mt-3">
            <a href="<?= esc_url(get_category_link(get_category_by_slug('news')->term_id)) ?>"
                class="btn btn-link see-all-btn">
                <?= esc_html(iranmock_translate('see_all') . ' ' . iranmock_translate('news')); ?>
            </a>
        </div>
    </div>


</div>