<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
</head>
<body>
    <h1>Selamat Datang, <?= $data['user']['nama']; ?>!</h1>
    <p>NIM: <?= $data['user']['nim']; ?></p>
    <p>Kelas: <?= $data['user']['kelas']; ?></p>
    <p>Jurusan: <?= $data['user']['jurusan']; ?></p>

    <a href="<?= BASEURL; ?>/auth/logout">Logout</a>
</body>
</html>
