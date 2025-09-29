<div class="container my-5">
    <h2 class="text-center mb-4">Our Partners</h2>
    <div class="d-flex overflow-auto">
        <?php for ($i = 1; $i <= 10; $i++): ?>
        <div class="mx-3">
            <img src="https://via.placeholder.com/100x50?text=Logo+<?= $i ?>" alt="Partner <?= $i ?>"
                class="img-fluid rounded-circle">
        </div>
        <?php endfor; ?>
    </div>
</div>