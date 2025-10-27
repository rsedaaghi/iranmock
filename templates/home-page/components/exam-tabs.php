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
            'posts_per_page' => 4, // Limit to 4
            'post_status'    => 'publish',
            'orderby'        => 'date', // Order by publish date
            'order'          => 'DESC',
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
                $card_settings = $fields["card_settings"];

                $exam_profiles_by_category[$term->slug][] = [
                    'post_id'           => $post_id,
                    'label'             => $fields['label'] ?? get_the_title(),
                    'year'              => $fields['year'] ?? '',
                    'month'             => $fields['month'] ?? '',
                    'description_label' => $card_settings['description_label'] ?? '',
                    'description_text'  => $card_settings['description_text'] ?? '',
                    'image'             => $card_settings['image'] ? $card_settings['image'] : get_the_post_thumbnail_url($post_id, 'medium'),
                    'participants'      => rand(50, 500),
                    'likes'             => rand(10, 100)
                ];
            }
            wp_reset_postdata();
        }
    }
}

$page_id = get_option('page_on_front');
$fields = get_fields($page_id);

$the_fields = $fields["exam_tabs"];
$label = $the_fields["label"];
$description = $the_fields["description"];
?>

<?php if (!empty($exam_categories)): ?>
    <div class="container my-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h2 class="text-start mb-1"><?= esc_html($label) ?></h2>
                <p class="text-start mb-0"><?= esc_html($description) ?></p>
            </div>
            <div class="quarter-circle"></div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs custom-navs" id="examTabs" role="tablist">
            <?php foreach ($exam_categories as $index => $cat): ?>
                <li class="nav-item custom-nav-item" role="presentation">
                    <button class="nav-link custom-nav-link <?= $index === 0 ? 'active' : '' ?>" data-bs-toggle="tab"
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
                            <?php $permalink = get_permalink($exam['post_id']); ?>
                            <div class="col-md-3 mb-4">
                                <a href="<?= esc_url($permalink) ?>" class="text-decoration-none">
                                    <div class="card custom-exam-profile-card h-100">
                                        <div class="card-img-wrapper">
                                            <img src="<?= esc_url($exam['image']) ?>" class="card-img-top"
                                                alt="<?= esc_attr($exam['label']) ?>">
                                        </div>
                                        <div class="card-body">
                                            <p class="exam-tabs-label"><?= esc_html($exam['label']) ?></p>
                                            <p class="exam-tabs-month-year"><?= esc_html("{$exam['month']}/{$exam['year']}") ?></p>
                                            <p class="exam-tabs-description-label"><?= esc_html($exam['description_label']) ?></p>
                                            <p class="exam-tabs-description-text"><?= esc_html($exam['description_text']) ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-link see-all-btn">
                            <?= esc_html(iranmock_translate('see_all')); ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>