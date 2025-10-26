<?php get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <!-- Featured Image Section -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="img-wrapper mb-5 mx-auto">
                <?php the_post_thumbnail('full', ['class' => 'featured-img']); ?>
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
            <div class="col-12 col-lg-10 mx-auto text-justify">
                <?php if ($month_year = get_field('description_title')) : ?>
                    <h2 class="month-year"><?php echo esc_html($month_year); ?></h2>
                <?php endif; ?>

                <?php if ($desc_title = get_field('description_title')) : ?>
                    <h2 class="description-title"><?php echo esc_html($desc_title); ?></h2>
                <?php endif; ?>

                <?php if ($desc_text = get_field('description_text')) : ?>
                    <p class="description-text"><?php echo wpautop($desc_text); ?></p>
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
        </div>


        <!-- Download Section -->
        <?php
        // Example condition: check if a download field exists
        $has_downloads = get_field('download_description_text'); // Replace with actual field
        if ($has_downloads) :
        ?>
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-lg-10 text-justify">
                    <h2 class="download-label">دانلود فایل های مرتبط</h2>
                    <p class="download-description"><?php echo wpautop($has_downloads); ?></p>

                    <div class="download-box p-4 mt-3">
                        <!-- Add download links or content here -->
                        <p class="mb-0">📎 فایل‌ها در این بخش قرار می‌گیرند.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

<?php endwhile;
endif; ?>

<?php get_footer(); ?>