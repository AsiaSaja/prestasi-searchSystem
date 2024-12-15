<?php require_once '../app/views/templates/admin-header.php'; ?>

<div class="container mt-4">
    <h1>Welcome to the Admin Dashboard</h1>
    <p>Manage your content efficiently from here.</p>

    <!-- Dashboard Summary -->
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Students</h5>
                    <p class="card-text">Total: <?= $data['studentCount'] ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Competitions</h5>
                    <p class="card-text">Total: <?= $data['competitionCount'] ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Achievements</h5>
                    <p class="card-text">Total: <?= $data['achievementCount'] ?? 0; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Logs -->
    <div class="row">
        <div class="col-12">
            <h3>Recent Logs</h3>
            <?php if (!empty($data['recentLogs'])): ?>
                <ul class="list-group">
                    <?php foreach ($data['recentLogs'] as $log): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($log['message']); ?> - <small><?= htmlspecialchars($log['timestamp']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No recent logs available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/templates/admin-footer.php'; ?>
