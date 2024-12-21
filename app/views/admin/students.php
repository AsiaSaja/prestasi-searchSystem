<?php require_once '../app/views/templates/admin-header.php'; ?>

<!-- Students Management Section -->
<div class="container mt-4">
    <h2>Manage Students</h2>

    <!-- Add New Student Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add New Student</button>

    <!-- Students Table -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Prodi</th>
                <th>Angkatan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['students'] as $student): ?>
                <tr>
                    <td><?= $student['id']; ?></td>
                    <td><?= $student['nim']; ?></td>
                    <td><?= $student['name']; ?></td>
                    <td><?= $student['email']; ?></td>
                    <td><?= $student['program']; ?></td>
                    <td><?= $student['year']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal"
                            data-id="<?= $student['id']; ?>" 
                            data-nim="<?= $student['nim']; ?>" 
                            data-name="<?= $student['name']; ?>" 
                            data-email="<?= $student['email']; ?>" 
                            data-program="<?= $student['program']; ?>" 
                            data-year="<?= $student['year']; ?>">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <button class="btn btn-danger" onclick="deleteStudent(<?= $student['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Adding Student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL; ?>/admin/createStudent" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="program" class="form-label">Prodi</label>
                        <input type="text" class="form-control" id="program" name="program" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Angkatan</label>
                        <input type="number" class="form-control" id="year" name="year" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Mahasiswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Student -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" method="POST">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editNim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="editNim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProgram" class="form-label">Prodi</label>
                        <input type="text" class="form-control" id="editProgram" name="program" required>
                    </div>
                    <div class="mb-3">
                        <label for="editYear" class="form-label">Angkatan</label>
                        <input type="number" class="form-control" id="editYear" name="year" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Update Mahasiswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the edit form with data when modal is shown
    const editStudentModal = document.getElementById('editStudentModal');
    editStudentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Extract data from the button
        const studentId = button.getAttribute('data-id');
        const form = document.getElementById('editStudentForm');
        
        // Set the action attribute of the form
        form.action = '<?= BASEURL; ?>/admin/editStudent/' + studentId;

        // Populate the form fields
        document.getElementById('editId').value = studentId;
        document.getElementById('editNim').value = button.getAttribute('data-nim');
        document.getElementById('editName').value = button.getAttribute('data-name');
        document.getElementById('editEmail').value = button.getAttribute('data-email');
        document.getElementById('editProgram').value = button.getAttribute('data-program');
        document.getElementById('editYear').value = button.getAttribute('data-year');
    });
</script>

<?php require_once '../app/views/templates/admin-footer.php'; ?>
