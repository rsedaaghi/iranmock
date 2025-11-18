<?php
$page_id = get_option('page_on_front');
$about_us_content = get_field('about_us', $page_id);
$svg_path = get_template_directory_uri() . '/assets/svg/quotation.svg';
?>

<?php if (!empty($about_us_content)): ?>
    <div id="about-us" class="container my-5 pt-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex gap-3 about-us-wrapper">
                <img src="<?= esc_url($svg_path); ?>" alt="Quote" class="about-us-img">
                <img src="<?= esc_url($svg_path); ?>" alt="Quote" class="about-us-img">
            </div>
            <div class="quarter-circle-lg"></div>
        </div>

        <h2 class="about-us-title"><?= esc_html(iranmock_translate('about_us')); ?></h2>

        <div class="about-us-content"><?= wp_kses_post($about_us_content); ?></div>
    </div>
<?php endif; ?>