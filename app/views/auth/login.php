<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?= BASEURL; ?>/auth/login" method="POST">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
    <a href="<?= BASEURL; ?>/auth/forgotpassword">Lupa Password?</a>
</body>
</html>
