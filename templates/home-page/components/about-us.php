<?php
$main_page_id = get_option('page_on_front');
$about_us_content = get_field('about_us', $main_page_id);
?>

<?php if (!empty($about_us_content)): ?>
    <div class="container my-5">
        <?= wp_kses_post($about_us_content); ?>
    </div>
<?php endif; ?>