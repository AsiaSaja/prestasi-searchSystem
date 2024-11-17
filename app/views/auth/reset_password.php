<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <!-- Form Reset Password -->
    <form action="<?= BASEURL; ?>/forgotpassword/updatePassword" method="POST">
        <!-- Hidden Field untuk Email -->
        <input type="hidden" name="email" value="<?= $data['email']; ?>">

        <label for="password">Password Baru:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
