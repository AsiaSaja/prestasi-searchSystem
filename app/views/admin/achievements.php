<?php require_once '../app/views/templates/admin-header.php'; ?>

<div class="container mt-4">
    <h2>Manage Achievements</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAchievementModal">Tambah Prestasi</button>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Mahasiswa</th>
                <th>Nama Kompetisi</th>
                <th>Prestasi</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($data['achievements']) && !empty($data['achievements'])): ?>
                <?php foreach ($data['achievements'] as $achievement): ?>
                    <tr>
                        <td><?= htmlspecialchars($achievement['id']); ?></td>
                        <td><?= htmlspecialchars($achievement['student_name']); ?></td>
                        <td><?= htmlspecialchars($achievement['competition_name']); ?></td>
                        <td><?= htmlspecialchars($achievement['achievement']); ?></td>
                        <td>
                            <!-- Edit Button (Trigger the modal) -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAchievementModal"
                                    data-id="<?= $achievement['id']; ?>"
                                    data-student-id="<?= $achievement['student_id']; ?>"
                                    data-competition-id="<?= $achievement['competition_id']; ?>"
                                    data-achievement="<?= htmlspecialchars($achievement['achievement']); ?>">
                                Edit
                            </button>
                            <!-- Delete Button (Trigger the delete action) -->
                            <button class="btn btn-danger" onclick="deleteAchievement(<?= $achievement['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No achievements found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Adding Achievement -->
<div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= BASEURL; ?>/admin/createAchievement" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAchievementModalLabel">Tambah Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Mahasiswa</label>
                        <select class="form-control" id="student_id" name="student_id" required>
                            <option value="">Pilih Mahasiswa</option>
                            <?php foreach ($data['students'] as $student): ?>
                                <option value="<?= $student['id']; ?>"><?= $student['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="competition_id" class="form-label">Kompetisi</label>
                        <select class="form-control" id="competition_id" name="competition_id" required>
                            <option value="">Pilih Kompetisi</option>
                            <?php foreach ($data['competitions'] as $competition): ?>
                                <option value="<?= $competition['id']; ?>"><?= $competition['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="achievement" class="form-label">Prestasi</label>
                        <input type="text" class="form-control" id="achievement" name="achievement" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Prestasi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Editing Achievement -->
<div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAchievementForm" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAchievementModalLabel">Edit Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editStudent" class="form-label">Mahasiswa</label>
                        <select class="form-control" id="editStudent" name="student_id" required>
                            <?php foreach ($data['students'] as $student): ?>
                                <option value="<?= $student['id'] ?>"><?= $student['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCompetition" class="form-label">Kompetisi</label>
                        <select class="form-control" id="editCompetition" name="competition_id" required>
                            <?php foreach ($data['competitions'] as $competition): ?>
                                <option value="<?= $competition['id'] ?>"><?= $competition['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editAchievement" class="form-label">Prestasi</label>
                        <input type="text" class="form-control" id="editAchievement" name="achievement" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update Prestasi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Populate the edit modal with the data
    document.getElementById('editAchievementModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const achievementId = button.getAttribute('data-id');
        const studentId = button.getAttribute('data-student-id');
        const competitionId = button.getAttribute('data-competition-id');
        const achievement = button.getAttribute('data-achievement');

        document.getElementById('editId').value = achievementId;
        document.getElementById('editStudent').value = studentId;
        document.getElementById('editCompetition').value = competitionId;
        document.getElementById('editAchievement').value = achievement;

        // Update the form action dynamically based on the ID
        const formAction = "<?= BASEURL; ?>/admin/editAchievement/" + achievementId;
        document.getElementById('editAchievementForm').action = formAction;
    });

    // Delete achievement
    function deleteAchievement(id) {
        if (confirm('Are you sure you want to delete this achievement?')) {
            window.location.href = '<?= BASEURL; ?>/admin/deleteAchievement/' + id;
        }
    }
</script>

<?php require_once '../app/views/templates/admin-footer.php'; ?>
