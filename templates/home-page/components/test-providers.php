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
    <div class="large-container test-provider my-5 bg-white rounded d-none d-sm-block">
        <div class="scroll-wrapper">
            <div class="scroll-track d-flex align-items-center">
                <?php while ($test_providers->have_posts()): $test_providers->the_post(); ?>
                    <?php if (get_the_title()): ?>
                        <div class="test-provider-image-container mx-5 flex-shrink-0">
                            <img src="<?= esc_url(get_the_post_thumbnail_url(null, 'thumbnail')) ?>"
                                alt="<?= esc_attr(get_the_title()) ?>" class="test-provider-logo">
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const track = document.querySelector(".scroll-track");
        const wrapper = document.querySelector(".scroll-wrapper");

        if (track.scrollWidth <= wrapper.clientWidth) {
            track.style.animation = "none";
        }
    });
</script>