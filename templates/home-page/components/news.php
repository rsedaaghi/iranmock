<div class="container my-5">
    <h2 class="text-center mb-4">Relating News</h2>
    <div class="row justify-content-center">
        <?php for ($k = 1; $k <= 3; $k++): ?>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="https://via.placeholder.com/300x200?text=News+<?= $k ?>" class="card-img-top"
                        alt="News <?= $k ?>">
                    <div class="card-body">
                        <h5 class="card-title">News Title <?= $k ?></h5>
                        <p class="card-text">Brief description of the news item goes here.</p>
                        <a href="#" class="btn btn-success">View</a>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>