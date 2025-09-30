<?php
$test_providers = new WP_Query([
    'post_type'      => 'test_provider',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS'
        ]
    ]
]);

if ($test_providers->have_posts()):
?>
    <div class="container my-5 py-4 bg-white rounded">
        <h2 class="text-center mb-4">
            <?= esc_html(iranmock_translate('test_providers')); ?>
        </h2>

        <div class="d-flex overflow-auto justify-content-center">
            <?php while ($test_providers->have_posts()): $test_providers->the_post(); ?>
                <?php if (get_the_title()): ?>
                    <div class="mx-3 flex-shrink-0">
                        <img src="<?= esc_url(get_the_post_thumbnail_url(null, 'thumbnail')) ?>"
                            alt="<?= esc_attr(get_the_title()) ?>" class="img-fluid test-provider-logo">
                    </div>
                <?php endif; ?>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>