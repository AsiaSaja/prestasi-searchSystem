<?php require_once '../app/views/templates/admin-header.php'; 

// extract($data); 
?>



<!-- <pre><?php print_r($data); ?></pre> -->
<!-- <pre><?php print_r($achievements); ?></pre> -->
<!-- <pre><?php print_r($data['achievements']); ?></pre> -->


<div class="container mt-4">
    <h2>Manage Achievements</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAchievementModal">Add Achievement</button>

    

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Competition Name</th>
                <th>Achievement</th>
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
                            <a href="<?= BASEURL; ?>/admin/editAchievement/<?= $achievement['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="<?= BASEURL; ?>/admin/deleteAchievement/<?= $achievement['id']; ?>" class="btn btn-danger">Delete</a>
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
                    <h5 class="modal-title" id="addAchievementModalLabel">Add Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student</label>
                        <select class="form-control" id="student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            <?php foreach ($data['students'] as $student): ?>
                                <option value="<?= $student['id']; ?>"><?= $student['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="competition_id" class="form-label">Competition</label>
                        <select class="form-control" id="competition_id" name="competition_id" required>
                            <option value="">Select Competition</option>
                            <?php foreach ($data['competitions'] as $competition): ?>
                                <option value="<?= $competition['id']; ?>"><?= $competition['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="achievement" class="form-label">Achievement</label>
                        <input type="text" class="form-control" id="achievement" name="achievement" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Achievement</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal for Editing Achievement -->
<div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= BASEURL; ?>/admin/editAchievement" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAchievementModalLabel">Edit Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editStudent_id" class="form-label">Student</label>
                        <select class="form-control" id="editStudent_id" name="student_id" required>
                            <option value="">Select Student</option>
                            <?php foreach ($data['students'] as $student): ?>
                                <option value="<?= $student['id']; ?>" <?= ($student['id'] == $data['achievement']['student_id']) ? 'selected' : ''; ?>>
                                    <?= $student['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCompetition_id" class="form-label">Competition</label>
                        <select class="form-control" id="editCompetition_id" name="competition_id" required>
                            <option value="">Select Competition</option>
                            <?php foreach ($data['competitions'] as $competition): ?>
                                <option value="<?= $competition['id']; ?>" <?= ($competition['id'] == $data['achievement']['competition_id']) ? 'selected' : ''; ?>>
                                    <?= $competition['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editAchievement" class="form-label">Achievement</label>
                        <input type="text" class="form-control" id="editAchievement" name="achievement" value="<?= $data['achievement']['achievement']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update Achievement</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    // Populate the edit modal with the data
    const editAchievementModal = document.getElementById('editAchievementModal');
    editAchievementModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const achievementId = button.getAttribute('data-id');
        const studentId = button.getAttribute('data-student-id');
        const competitionId = button.getAttribute('data-competition-id');
        const achievement = button.getAttribute('data-achievement');

        // Populate the form fields
        document.getElementById('editId').value = achievementId;
        document.getElementById('editStudent_id').value = studentId;
        document.getElementById('editCompetition_id').value = competitionId;
        document.getElementById('editAchievement').value = achievement;
    });


    // Delete achievement
    function deleteAchievement(id) {
        if (confirm('Are you sure you want to delete this achievement?')) {
            window.location.href = '<?= BASEURL; ?>/admin/deleteAchievement/' + id;
        }
    }
</script>

<?php require_once '../app/views/templates/admin-footer.php'; ?>
