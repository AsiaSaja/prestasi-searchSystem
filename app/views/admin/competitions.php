<?php require_once '../app/views/templates/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Manage Competitions</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCompetitionModal">Add Competition</button>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kompetisi</th>
                <th>Tahun</th>
                <th>Details</th>
                <th>Bidang</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['competitions'] as $competition): ?>
                <tr>
                    <td><?= htmlspecialchars($competition['id']); ?></td>
                    <td><?= htmlspecialchars($competition['name']); ?></td>
                    <td><?= htmlspecialchars($competition['year']); ?></td>
                    <td><?= htmlspecialchars($competition['details']); ?></td>
                    <td><?= htmlspecialchars($competition['category']); ?></td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCompetitionModal"
                                data-id="<?= htmlspecialchars($competition['id']); ?>"
                                data-name="<?= htmlspecialchars($competition['name']); ?>"
                                data-year="<?= htmlspecialchars($competition['year']); ?>"
                                data-details="<?= htmlspecialchars($competition['details']); ?>"
                                data-category="<?= htmlspecialchars($competition['category']); ?>">Edit</button>
                        <button class="btn btn-danger" onclick="deleteCompetition(<?= htmlspecialchars($competition['id']); ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Competition Modal -->
<div class="modal fade" id="addCompetitionModal" tabindex="-1" aria-labelledby="addCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= BASEURL; ?>/admin/createCompetition" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompetitionModalLabel">Add Competition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kompetisi</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="year" name="year" required>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">Details</label>
                        <textarea class="form-control" id="details" name="details" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Bidang</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Competition</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Competition Modal -->
<div class="modal fade" id="editCompetitionModal" tabindex="-1" aria-labelledby="editCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= BASEURL; ?>/admin/editCompetition/<?= $competition['id']; ?>" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompetitionModalLabel">Edit Kompetisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editYear" class="form-label">Year</label>
                        <input type="number" class="form-control" id="editYear" name="year" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDetails" class="form-label">Details</label>
                        <textarea class="form-control" id="editDetails" name="details" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Bidang</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update Competition</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Populate edit modal with data
    document.getElementById('editCompetitionModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('editId').value = button.getAttribute('data-id');
        document.getElementById('editName').value = button.getAttribute('data-name');
        document.getElementById('editYear').value = button.getAttribute('data-year');
        document.getElementById('editDetails').value = button.getAttribute('data-details');
        document.getElementById('editCategory').value = button.getAttribute('data-category');
    });

    // Delete competition
    function deleteCompetition(id) {
        if (confirm('Are you sure you want to delete this competition?')) {
            window.location.href = '<?= BASEURL; ?>/admin/deleteCompetition/' + id;
        }
    }
</script>

<?php require_once '../app/views/templates/admin-footer.php'; ?>
