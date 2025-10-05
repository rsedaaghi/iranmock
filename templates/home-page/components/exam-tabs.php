<?php
$exam_categories = get_terms([
    'taxonomy'   => 'exam_category',
    'hide_empty' => false
]);

$exam_profiles_by_category = [];

if (!empty($exam_categories)) {
    foreach ($exam_categories as $term) {
        $query = new WP_Query([
            'post_type'      => 'exam_profile',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => [
                [
                    'taxonomy' => 'exam_category',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id
                ]
            ]
        ]);

        $exam_profiles_by_category[$term->slug] = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $fields = get_fields($post_id);

                $exam_profiles_by_category[$term->slug][] = [
                    'title'             => $fields['title'] ?? get_the_title(),
                    'year'              => $fields['year'] ?? '',
                    'month'             => $fields['month'] ?? '',
                    'description_title' => $fields['description_title'] ?? '',
                    'description_text'  => $fields['description_text'] ?? '',
                    'image'             => get_the_post_thumbnail_url($post_id, 'medium'),
                    'participants'      => rand(50, 500),
                    'likes'             => rand(10, 100)
                ];
            }
            wp_reset_postdata();
        }
    }
}
?>

<?php if (!empty($exam_categories)): ?>
    <div class="container my-5">
        <h2 class="text-start">Upcoming Exams</h2>
        <p class="text-start">Choose your category to explore mock exams</p>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="examTabs" role="tablist">
            <?php foreach ($exam_categories as $index => $cat): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" data-bs-toggle="tab"
                        data-bs-target="#<?= esc_attr($cat->slug) ?>" type="button" role="tab">
                        <?= esc_html($cat->name) ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4">
            <?php foreach ($exam_categories as $index => $cat): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= esc_attr($cat->slug) ?>"
                    role="tabpanel">
                    <div class="row">
                        <?php foreach ($exam_profiles_by_category[$cat->slug] as $exam): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <img src="<?= esc_url($exam['image']) ?>" class="card-img-top"
                                        alt="<?= esc_attr($exam['title']) ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc_html($exam['title']) ?></h5>
                                        <p class="text-muted"><?= esc_html("{$exam['month']}/{$exam['year']}") ?></p>
                                        <h6><?= esc_html($exam['description_title']) ?></h6>
                                        <p class="card-text"><?= esc_html($exam['description_text']) ?></p>
                                        <div class="d-flex justify-content-between mt-3">
                                            <span>(<?= intval($exam['participants']) ?> participants)</span>
                                            <span><i class="bi bi-star-fill text-warning"></i> <?= intval($exam['likes']) ?>
                                                likes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-link">See All</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>