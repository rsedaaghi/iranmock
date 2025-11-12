<?php get_header(); ?>

<?php
$term = get_queried_object();
$image = get_field('image', $term);
$description = term_description($term->term_id, 'exam_category');

$exam_profiles = get_posts([
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

$jalali_years = [];

if (!empty($exam_profiles)) {
    foreach ($exam_profiles as $post) {
        $fields = get_fields($post->ID);
        $year = $fields['year'] ?? null;

        if ($year && !in_array($year, $jalali_years)) {
            $jalali_years[] = $year;
        }
    }
    rsort($jalali_years);
}

$exam_profiles_by_year_month = [];

foreach ($exam_profiles as $post) {
    $post_id = $post->ID;
    $fields = get_fields($post_id);
    $card_settings = $fields["card_settings"] ?? [];
    $year = $fields['year'] ?? null;
    $month = $fields['month'] ?? null;

    if ($year && $month) {
        if (!isset($exam_profiles_by_year_month[$year])) {
            $exam_profiles_by_year_month[$year] = [];
        }
        if (!isset($exam_profiles_by_year_month[$year][$month])) {
            $exam_profiles_by_year_month[$year][$month] = [];
        }

        $exam_profiles_by_year_month[$year][$month][] = [
            'post_id'           => $post_id,
            'label'             => $fields['label'] ?? get_the_title(),
            'year'              => $fields['year'] ?? '',
            'month'             => $fields['month'] ?? '',
            'description_label' => $card_settings['description_label'] ?? '',
            'description_text'  => $card_settings['description_text'] ?? '',
            'image'             => $card_settings['image'] ?? get_the_post_thumbnail_url($post_id, 'medium'),
            'participants' => round(rand(10000, 50000) / 1000),
            'rating'            => number_format(rand(30, 50) / 10, 1),
        ];
    }
}
ksort($exam_profiles_by_year_month);

$default_year = $jalali_years[0] ?? null;

$jalali_months = [
    '01' => 'فروردین',
    '02' => 'اردیبهشت',
    '03' => 'خرداد',
    '04' => 'تیر',
    '05' => 'مرداد',
    '06' => 'شهریور',
    '07' => 'مهر',
    '08' => 'آبان',
    '09' => 'آذر',
    '10' => 'دی',
    '11' => 'بهمن',
    '12' => 'اسفند'
];

?>

<div class="exam-profile-page">
    <!-- Featured Image Section -->
    <?php if (!empty($image)) : ?>
        <div class="container-xxl no-gutter-sm img-wrapper">
            <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($term->name) ?>" class="featured-img" />
        </div>
    <?php endif; ?>

    <!-- Label Section -->
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-lg-10">
            <h1 class="exam-label text-center"><?= esc_html($term->name) ?></h1>
        </div>
    </div>

    <!-- Description Section -->
    <div class="exam-profile-description mx-auto py-5 px-3">
        <div class="exam-profile-quarter-circle"></div>
        <div class="col-12 col-lg-10 mx-auto px-5 text-justify">
            <?php if (!empty($description)) : ?>
                <p class="description-text"><?= wpautop($description) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container my-5">
        <div class="row mb-4" style="min-height: 150px;">
            <div class="col-2">
                <!-- Empty column -->
            </div>

            <div class="col text-center">
                <h2 class="section-title mb-4 mt-5">آرشیو آزمون‌ها</h2>
                <hr class="suggested-exams-hr">
            </div>

            <div class="col-2 d-flex flex-column justify-content-end">
                <div>
                    <span class="sort-label mb-2 d-block">مرتب‌سازی بر اساس سال:</span>
                    <?php if (!empty($jalali_years)) : ?>
                        <select id="jalali-year" class="form-select select-year w-100">
                            <?php foreach ($jalali_years as $year) : ?>
                                <option value="year-<?= esc_attr($year) ?>" <?= $year === $default_year ? 'selected' : '' ?>>
                                    <?= esc_html($year) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Exam Cards by Year -->
        <?php foreach ($exam_profiles_by_year_month as $year => $months): ?>
            <?php if (empty($months) || !is_array($months)) continue; ?>
            <div class="exam-year-section" id="year-<?= esc_attr($year) ?>" style="display: none;">
                <div class="row d-none d-md-flex gx-4">
                    <?php ksort($months); ?>
                    <?php foreach ($months as $profiles): ?>
                        <?php foreach ($profiles as $exam): ?>
                            <?php $permalink = get_permalink($exam['post_id']); ?>
                            <div class="col-md-3 mb-4 px-0">
                                <a href="<?= esc_url($permalink) ?>" class="text-decoration-none">
                                    <div class="card custom-exam-profile-card">
                                        <div class="card-img-wrapper">
                                            <img src="<?= esc_url($exam['image']) ?>" class="card-img-top"
                                                alt="<?= esc_attr($exam['label']) ?>">
                                        </div>
                                        <div class="card-body">
                                            <p class="exam-tabs-label make-block"><?= esc_html($exam['label']) ?></p>
                                            <p class="exam-tabs-month-year make-block">
                                                <?= esc_html("{$exam['month']}/{$exam['year']}") ?></p>
                                            <p class="exam-tabs-description-label make-block">
                                                <?= esc_html($exam['description_label']) ?></p>
                                            <p class="exam-tabs-description-text">
                                                <?= esc_html($exam['description_text']) ?></p>
                                            <div class="mt-3 d-flex justify-content-between">
                                                <span class="participants exam-tabs-footer-text">
                                                    (<?= esc_html(iranmock_translate('participants') . ' ' . $exam['participants'] . 'k') ?>)
                                                </span>
                                                <div>
                                                    <span class="dashicons dashicons-star-empty"></span>
                                                    <span
                                                        class="rating exam-tabs-footer-text"><?= esc_html($exam['rating']) ?>/5</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('jalali-year');
            const sections = document.querySelectorAll('.exam-year-section');

            function showSelectedYear(id) {
                sections.forEach(section => {
                    section.style.display = section.id === id ? 'block' : 'none';
                });
            }

            // Show default year section
            showSelectedYear(dropdown.value);

            // Toggle on change
            dropdown.addEventListener('change', function() {
                showSelectedYear(this.value);
            });
        });
    </script>
</div>

<?php get_footer(); ?>