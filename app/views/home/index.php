<!-- <?php
// Debug section
$available_vars = get_defined_vars();
error_log("=== View Variables ===");
error_log(print_r($available_vars, true));

echo "<div style='background: #f8f9fa; padding: 10px; margin: 10px; border: 1px solid #ddd;'>";
echo "<h4>Debug Information:</h4>";
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "POST Data: <pre>" . print_r($_POST, true) . "</pre>";
echo "Keyword variable exists: " . (isset($keyword) ? 'Yes - Value: ' . htmlspecialchars($keyword) : 'No') . "<br>";
echo "SearchResults variable exists: " . (isset($searchResults) ? 'Yes - Count: ' . count($searchResults) : 'No') . "<br>";

if (isset($searchResults) && is_array($searchResults)) {
    echo "First result: <pre>";
    print_r(reset($searchResults));
    echo "</pre>";
}
echo "</div>";
?> -->

<!-- Your existing HTML below -->


<?php require_once '../app/views/templates/user-header.php'; 

// if (isset($searchResults)) {
//     echo "<pre>";
//     print_r($searchResults);
//     echo "</pre>";
// }
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-6 align-self-center">
            <h2 class="text-primary mb-5">Welcome to PIP Polindra</h2>
            <p>
                PIP Polindra hadir sebagai pusat informasi bagi mahasiswa<br> 
                untuk memperoleh informasi tentang prestasi yang diraih<br>
                dan kompetisi yang diikuti Politeknik Negeri Indramayu.
            </p>
        </div>
        <div class="col-sm-6 align-self-center">
            <img src="<?= img('GSC_Polindra.jpeg'); ?>" alt="GSC" class="shadow border rounded" style="width: 100%">
        </div>
    </div>

    <div class="container mt-4">
    <div class="row">
        <div class="col">
            <form action="<?= BASEURL; ?>/home/search" method="post">
                <div class="input-group mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        placeholder="Cari prestasi, nama mahasiswa, atau kompetisi..." 
                        name="keyword" 
                        id="keyword" 
                        autocomplete="off"
                        value="<?= isset($keyword) ? htmlspecialchars($keyword) : ''; ?>"
                        required
                        minlength="2"
                    >
                    <button class="btn btn-primary" type="submit" id="tombolCari">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Search Results Section -->
<?php if (isset($searchResults)): ?>
    <?php error_log("Search Results: " . print_r($searchResults, true)); ?>
    <?php if (!empty($keyword)): ?>
        <div class="alert alert-info">
            Menampilkan hasil pencarian untuk: "<?= htmlspecialchars($keyword) ?>"
        </div>
    <?php endif; ?>

    <?php if (!empty($searchResults)): ?>
        <div class="container mt-4">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Competition</th>
                                <th>Achievement</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($searchResults as $result): ?>
                                <tr>
                                    <td><?= htmlspecialchars($result['student_name']); ?></td>
                                    <td><?= htmlspecialchars($result['competition_name']); ?></td>
                                    <td><?= htmlspecialchars($result['achievement']); ?></td>
                                    <td><?= htmlspecialchars($result['competition_year']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                           

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Tidak ditemukan hasil untuk pencarian "<?= htmlspecialchars($keyword) ?>"
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php require_once '../app/views/templates/user-footer.php'; ?>
