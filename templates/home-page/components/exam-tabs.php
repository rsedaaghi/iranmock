<div class="container my-5">
    <h2 class="text-start">Upcoming Exams</h2>
    <p class="text-start">Choose your category to explore mock exams</p>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="examTabs" role="tablist">
        <?php $categories = ['IELTS', 'TOEFL'];
        foreach ($categories as $index => $cat): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" data-bs-toggle="tab"
                    data-bs-target="#<?= strtolower($cat) ?>">
                    <?= $cat ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-4">
        <?php foreach ($categories as $index => $cat): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= strtolower($cat) ?>">
                <div class="row">
                    <?php for ($j = 1; $j <= 4; $j++): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/300x200?text=Exam+<?= $j ?>" class="card-img-top"
                                    alt="Exam <?= $j ?>">
                                <div class="card-body">
                                    <h5 class="card-title">October Exam <?= $j ?></h5>
                                    <p class="text-muted">October 2025</p>
                                    <h6>Description</h6>
                                    <p class="card-text">This is a mock exam for <?= $cat ?> preparation.</p>
                                    <div class="d-flex justify-content-between mt-3">
                                        <span>(<?= rand(50, 500) ?> participants)</span>
                                        <span><i class="bi bi-star-fill text-warning"></i> <?= rand(10, 100) ?> likes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="text-center">
                    <button class="btn btn-link">See All</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>