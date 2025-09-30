<?php
$slides = get_field('slides', $main_page_id);

if (!empty($slides) && is_array($slides)) :
?>
    <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($slides as $index => $slide):
                // Handle both repeater and gallery formats
                $image = isset($slide['image']) ? $slide['image'] : $slide;
                $src = isset($image['url']) ? esc_url($image['url']) : '';
                $alt = isset($image['alt']) ? esc_attr($image['alt']) : 'Slide ' . ($index + 1);
            ?>
                <?php if ($src): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= $src ?>" class="d-block w-100" alt="<?= $alt ?>" loading="lazy">
                    </div>
                <?php endif; ?>
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