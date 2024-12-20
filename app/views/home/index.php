<?php require_once '../app/views/templates/user-header.php'; ?>
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
                <div class="d-flex justify-content-center">
                    <!-- Search Bar with Dropdown -->
                    <form action="<?= url('home/search'); ?>" method="get" class="input-group">
                        <!-- Dropdown Menu -->
                        <select class="form-select" name="category">
                            <option value="">Pilih Kategori</option>
                            <option value="Kompetisi">Kompetisi</option>
                            <option value="Prestasi">Prestasi</option>
                        </select>
                        <!-- Search Input -->
                        <input class="form-control" type="search" name="keyword" placeholder="Cari..." aria-label="Search">
                        <!-- Search Button -->
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../app/views/templates/user-footer.php'; ?>
