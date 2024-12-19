<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIPPolindra <?= isset($data['judul']) ? $data['judul'] : 'PIPPolindra'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/styles.css">
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .subtext {
            font-size: 0.8rem;
        }

        .navbar-nav a {
            font-size: 0.9rem;
        }

        .logo-container img {
            width: 100%;
            max-width: 120px;
        }

        .navbar-text {
            font-size: 1rem;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .logo-container img {
                max-width: 80px;
                max-height: 80px;
            }

            .navbar-brand {
                font-size: 0.9rem;
                text-align: center;
            }

            .navbar-text {
                font-size: 0.8rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container align-items-center">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="<?= BASEURL; ?>/home">
                <div class="logo-container bg-white rounded-5 p-1 me-2">
                    <img src="<?= BASEURL; ?>/img/Polindra.png" alt="Logo of Politeknik Negeri Indramayu" class="img-fluid">
                </div>
                <span class="text-white navbar-text">
                    PUSAT INFORMASI PRESTASI<br>Politeknik Negeri Indramayu
                </span>
            </a>

            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link <?= isset($data['judul']) && $data['judul'] === 'Home' ? 'active' : ''; ?>" href="<?= BASEURL; ?>/home/index">Home</a>
                    <a class="nav-link <?= isset($data['judul']) && $data['judul'] === 'Kompetisi' ? 'active' : ''; ?>" href="<?= BASEURL; ?>/home/kompetisi">Kompetisi</a>
                </div>
            </div>
        </div>
    </nav>

    