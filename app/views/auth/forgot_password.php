<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
</head>
<body>
    <h1>Lupa Password</h1>
    <form action="<?= BASEURL; ?>/auth/resetpassword" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Kirim</button>
    </form>
</body>
</html>
