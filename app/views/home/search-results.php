<?php require_once '../app/views/templates/user-header.php'; ?>

<div class="container mt-5">
    <h2 class="text-primary mb-5">Search Results</h2>

    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <strong><?= htmlspecialchars($result['student_name']); ?></strong> 
                    achieved in <strong><?= htmlspecialchars($result['competition_name']); ?></strong> 
                    with achievement: <?= htmlspecialchars($result['achievement']); ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Pagination Links -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= url('home/search?page=' . ($page - 1) . '&keyword=' . $keyword . '&category=' . $category) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="<?= url('home/search?page=' . $i . '&keyword=' . $keyword . '&category=' . $category) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= url('home/search?page=' . ($page + 1) . '&keyword=' . $keyword . '&category=' . $category) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php else: ?>
        <p>No results found for your search.</p>
    <?php endif; ?>
</div>

<?php require_once '../app/views/templates/user-footer.php'; ?>
