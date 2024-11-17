<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASEURL . '/auth');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?= $_SESSION['user']['nama']; ?>!</h1>
    <a href="<?= BASEURL; ?>/auth/logout">Logout</a>
</body>
</html>
