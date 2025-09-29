<?php
echo "hey";

// Dummy image data array
$slider_images = [
    ['src' => 'https://via.placeholder.com/1200x500?text=Slide+1', 'alt' => 'Slide 1'],
    ['src' => 'https://via.placeholder.com/1200x500?text=Slide+2', 'alt' => 'Slide 2'],
    ['src' => 'https://via.placeholder.com/1200x500?text=Slide+3', 'alt' => 'Slide 3'],
];
?>

<!-- Bootstrap Carousel -->
<div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($slider_images as $index => $image): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="<?= $image['src'] ?>" class="d-block w-100" alt="<?= $image['alt'] ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>