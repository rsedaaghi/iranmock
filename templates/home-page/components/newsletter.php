<?php
$page_id = get_option('page_on_front');
$fields = get_fields($page_id);

$the_fields = $fields["newsletter"];
$label = $the_fields["label"];
$description = $the_fields["description"];
?>

<div class="large-container bg-white my-5 py-5">
    <h2 class="text-center newsletter-title"><?= esc_html($label) ?></h2>
    <p class="text-center my-4 newsletter-description"><?= esc_html($description) ?></p>

    <form class="d-flex justify-content-center">
        <div class="newsletter-wrapper d-flex w-100">
            <button class="btn newsletter-btn btn-success"> <?= esc_html(iranmock_translate('send')); ?> </button>
            <input type="email" class="form-control newsletter-input" placeholder="Enter your email">
        </div>
    </form>


</div>