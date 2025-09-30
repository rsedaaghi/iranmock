<?php
$slides = [];

$slider_query = new WP_Query([
    'post_type'      => 'homepage_slider',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS'
        ]
    ]
]);

if ($slider_query->have_posts()) {
    while ($slider_query->have_posts()) {
        $slider_query->the_post();
        $slides[] = [
            'label' => get_the_title(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'full')
        ];
    }
}
wp_reset_postdata();
?>

<?php if (!empty($slides)): ?>
    <div id="landingCarousel" class="carousel slide w-100 rounded-3 overflow-hidden" data-bs-ride="carousel"
        style="height: 344px;">
        <div class="carousel-inner h-100">
            <?php foreach ($slides as $index => $slide): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> h-100">
                    <img src="<?= esc_url($slide['image']) ?>" class="d-block w-100 h-100 object-fit-cover"
                        alt="<?= esc_attr($slide['label']) ?>" style="object-fit: cover;">
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<?php endif; ?>