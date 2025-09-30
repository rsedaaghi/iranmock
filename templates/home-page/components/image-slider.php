<?php
$slides = [
    ['label' => 'Slide 1'],
    ['label' => 'Slide 2'],
    ['label' => 'Slide 3'],
];
?>

<div id="landingCarousel" class="carousel slide w-100 rounded-3 overflow-hidden" data-bs-ride="carousel"
    style="height: 344px;">
    <div class="carousel-inner h-100">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> h-100">
                <svg class="d-block w-100 h-100" xmlns="http://www.w3.org/2000/svg" role="img"
                    aria-label="<?= esc_attr($slide['label']) ?>" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#777" />
                    <text x="50%" y="50%" fill="#fff" dy=".3em" font-size="40"
                        text-anchor="middle"><?= esc_html($slide['label']) ?></text>
                </svg>
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