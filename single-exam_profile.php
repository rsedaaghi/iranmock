<?php get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="exam-profile-page">
            <!-- Featured Image Section -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="container-xxl no-gutter-sm">
                    <div class="header-img-wrapper">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Label Section -->
            <?php if ($label = get_field('label')) : ?>
                <div class="row justify-content-center mb-3">
                    <div class="col-12 col-lg-10">
                        <h1 class="exam-label text-center"><?php echo esc_html($label); ?></h1>
                    </div>
                </div>
            <?php endif; ?>

            <div class="exam-profile-description mx-auto py-5 px-3">
                <div class="exam-profile-quarter-circle"></div>
                <div class="col-12 col-lg-10 mx-auto px-5 text-justify">
                    <?php
                    $month = get_field('month');
                    $year = get_field('year');
                    if ($month && $year):
                        $month_year = "{$month}/{$year}";
                    ?>
                        <p class="month-year"><?php echo esc_html($month_year); ?></p>
                    <?php endif; ?>

                    <?php
                    $single_page_settings = get_field('single_page_settings');
                    if (!empty($single_page_settings['description_text'])) :
                    ?>
                        <p class="description-text"><?php echo wpautop($single_page_settings['description_text']); ?></p>
                    <?php endif; ?>

                    <?php
                    $exam_category_id = get_field('exam_category');
                    if ($exam_category_id) {
                        $args = [
                            'post_type' => 'member_plan',
                            'posts_per_page' => 1,
                            'meta_query' => [
                                [
                                    'key' => 'is_active',
                                    'value' => true,
                                    'compare' => '='
                                ]
                            ],
                            'tax_query' => [
                                [
                                    'taxonomy' => 'exam_category',
                                    'field' => 'term_id',
                                    'terms' => $exam_category_id
                                ]
                            ]
                        ];
                        $active_plan = new WP_Query($args);
                        if ($active_plan->have_posts()) {
                            echo '<p class="text-success mt-3">✅ Active Member Plan available for this exam category.</p>';
                        } else {
                            echo '<p class="text-muted mt-3">No active Member Plan found for this exam category.</p>';
                        }
                        wp_reset_postdata();
                    }
                    ?>

                </div>
                <br>
                <div class="col-12 col-lg-10 mx-auto text-justify member-plans-section">
                    <div class="container member-plans-wrapper px-4">
                        <div class="row custom-gutter">
                            <?php
                            $plans = [
                                [
                                    'title' => 'عضویت نقره‌ای',
                                    'features' => ['دسترسی به منابع آنلاین', 'آزمون‌های شبیه‌ساز', 'نمودارهای پیشرفت'],
                                    'price' => '۲۸۰ هزار تومان',
                                    'highlight' => false
                                ],
                                [
                                    'title' => 'عضویت طلایی',
                                    'features' => ['همه امکانات نقره‌ای', 'پیشنهاد مسیر مطالعه', 'یادآوری هوشمند'],
                                    'price' => '۴۵۰ هزار تومان',
                                    'highlight' => true,
                                    'image' => 'https://img.freepik.com/premium-vector/black-white-member-member-logo-black-white-hd-png-download_24886-972.jpg'
                                ],
                                [
                                    'title' => 'عضویت الماسی',
                                    'features' => ['همه امکانات طلایی', 'مشاوره اختصاصی', 'ارتباط با داوطلبان'],
                                    'price' => '۷۰۰ هزار تومان',
                                    'highlight' => false
                                ]
                            ];

                            foreach ($plans as $plan) :
                            ?>
                                <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                                    <div class="member-card <?php echo $plan['highlight'] ? 'highlighted' : ''; ?>">
                                        <?php if (!empty($plan['image'])) : ?>
                                            <img src="<?php echo esc_url($plan['image']); ?>" alt="عضویت" class="membership-icon">
                                        <?php elseif ($plan['highlight']) : ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/membership-icon.png"
                                                alt="عضویت" class="membership-icon">
                                        <?php endif; ?>
                                        <h3 class="member-title"><?php echo $plan['title']; ?></h3>
                                        <ul class="member-features">
                                            <?php foreach ($plan['features'] as $feature) : ?>
                                                <li><?php echo $feature; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <p class="member-price"><?php echo $plan['price']; ?></p>
                                        <button class="buy-button">خرید</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Download Section -->
            <?php
            $section_title = 'دانلود فایل‌های مرتبط'; // Related Files Download
            $description_text = 'کتاب تست آزمون تمرین آیلتس 17 (CAMBRIDGE PRACTICE TESTS FOR IELTS 17) جمع آوری شده امتحانات در سال های گذشته می باشد که شامل بخش شنیداری با Listening آیلتس، بخش خواندنی با Reading آیلتس، بخش نوشتاری با Writing آیلتس و بخش مکالمه با Speaking آیلتس می باشد. این کتاب منبعی ایده آل برای داوطلبان آزمون آیلتس در ماژول های آکادمیک Academic و جنرال General می باشد و از منابع خودخوان آیلتس هم به شمار می رود.';

            // --- Download Boxes Array ---
            $download_modules = [
                // 1. General Module
                [
                    'title' => 'دانلود جنرال کتاب 17',
                    'subtitle' => 'CAMBRIDGE PRACTICE TESTS FOR IELTS General',
                    'pdf_link' => '#general-pdf-link', // Replace with actual URL
                    'audio_link' => '#general-audio-link', // Replace with actual URL
                    'id' => 'general'
                ],
                // 2. Academic Module
                [
                    'title' => 'دانلود آکادمیک کتاب 17',
                    'subtitle' => 'CAMBRIDGE PRACTICE TESTS FOR IELTS Academic',
                    'pdf_link' => '#academic-pdf-link', // Replace with actual URL
                    'audio_link' => '#academic-audio-link', // Replace with actual URL
                    'id' => 'academic'
                ],
            ];
            ?>
            <div class="container">
                <div class="row justify-content-center my-5">
                    <div class="col-12 col-lg-10">

                        <h2 class="section-title text-center mb-4"><?php echo esc_html($section_title); ?></h2>
                        <p class="section-description"><?php echo esc_html($description_text); ?></p>

                        <div class="row g-4 justify-content-center download-box p-4">
                            <?php
                            $i = 0;
                            foreach ($download_modules as $module) :
                                // Add the separator class only to the second item (index 1)
                                $separator_class = ($i === 1) ? 'download-box-separator' : '';
                            ?>
                                <div class="col-md-6">
                                    <div
                                        class="px-4 pb-4 h-100 d-flex flex-column align-items-center justify-content-center <?= $separator_class ?>">
                                        <h3 class="box-title mb-2"><?php echo esc_html($module['title']); ?></h3>
                                        <p class="box-subtitle text-muted mb-4"><?php echo esc_html($module['subtitle']); ?></p>

                                        <div class="d-flex justify-content-center gap-3">

                                            <a href="<?php echo esc_url($module['pdf_link']); ?>"
                                                class="btn btn-primary btn-lg download-btn d-flex align-items-center justify-content-center"
                                                download>
                                                <span class="ms-2">دانلود کتاب (PDF)</span>
                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                            </a>

                                            <a href="<?php echo esc_url($module['audio_link']); ?>"
                                                class="btn btn-secondary btn-lg download-btn d-flex align-items-center justify-content-center"
                                                download>
                                                <span class="ms-2">دانلود فایل صوتی</span>
                                                <i class="bi bi-download"></i>
                                                <i class="bi bi-headset"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $i++;
                            endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            $suggested_section_title = 'سایر آزمون های پیشنهادی';
            $current_post_id = get_the_ID();

            // Find the category of the current exam_profile post
            $terms = get_the_terms($current_post_id, 'exam_category');
            $suggested_exams_posts = [];

            if ($terms && !is_wp_error($terms)) {
                // Assuming the post belongs to the first term in the array for simplicity
                $main_term_id = $terms[0]->term_id;
                $main_term_slug = $terms[0]->slug;

                // Query other posts in the same category, excluding the current one
                $related_query = new WP_Query([
                    'post_type'      => 'exam_profile',
                    'posts_per_page' => 4, // Limit to 4 suggested exams
                    'post_status'    => 'publish',
                    'post__not_in'   => [$current_post_id], // Exclude the current post
                    'tax_query'      => [
                        [
                            'taxonomy' => 'exam_category',
                            'field'    => 'term_id',
                            'terms'    => $main_term_id
                        ]
                    ]
                ]);

                if ($related_query->have_posts()) {
                    while ($related_query->have_posts()) {
                        $related_query->the_post();
                        $post_id = get_the_ID();
                        $fields = get_fields($post_id);
                        $card_settings = $fields["card_settings"] ?? [];

                        $suggested_exams_posts[] = [
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
                    wp_reset_postdata();
                }
            }
            ?>
            <?php if (!empty($suggested_exams_posts)) : ?>
                <div class="container suggested-exams-section-wrapper">
                    <div class="floating-half-circle"></div>

                    <div class="row justify-content-center my-5">
                        <h2 class="section-title text-center mb-4 mt-5"><?= esc_html($suggested_section_title); ?></h2>
                        <hr class="suggested-exams-hr">

                        <div class="row d-none d-md-flex gx-4">
                            <?php foreach ($suggested_exams_posts as $exam): ?>
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
                                                    <?= esc_html("{$exam['month']}/{$exam['year']}") ?>
                                                </p>
                                                <p class="exam-tabs-description-label make-block">
                                                    <?= esc_html($exam['description_label']) ?>
                                                </p>
                                                <p class="exam-tabs-description-text">
                                                    <?= esc_html($exam['description_text']) ?></p>
                                                </p>
                                                <div class="mt-3 d-flex justify-content-between">
                                                    <span class="participants exam-tabs-footer-text">
                                                        (<?= esc_html(iranmock_translate('participants') . ' ' . rand(10, 50) . 'k') ?>)
                                                    </span>
                                                    <div>
                                                        <span class="dashicons dashicons-star-empty"></span>
                                                        <span class="rating exam-tabs-footer-text">
                                                            <?= esc_html(number_format(rand(30, 50) / 10, 1)) ?>/5
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
<?php endwhile;
endif; ?>

<?php get_footer(); ?>