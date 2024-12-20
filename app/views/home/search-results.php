<?php require_once '../app/views/templates/user-header.php'; ?>

<div class="container mt-5">
    <h2 class="text-primary mb-5">Search Results</h2>

    <?php if (empty($results)): ?>
        <p>No results found for your search criteria.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($results as $result): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($result['student_name']) ?></h5>
                            <p class="card-text">Competition: <?= htmlspecialchars($result['competition_name']) ?></p>
                            <p class="card-text">Achievement: <?= htmlspecialchars($result['achievement']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/templates/user-footer.php'; ?>
