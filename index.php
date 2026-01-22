<?php
session_start();
include 'koneksi.php';

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if ($row = mysqli_fetch_assoc($result)) {

        if ($password == $row['password']) {

            $_SESSION['email'] = $row['email'];
            $_SESSION['name']  = $row['name'];
            $_SESSION['role']  = $row['role'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Password salah.";
        }

    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login POLGAN MART</title>
</head>
<body>

<div class="login-card">
    <h2>POLGAN MART</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="post">

        <div class="form-group">
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Masukkan email anda" required>
        </div>
        <br>

        <div class="form-group">
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        <br>

        <button type="submit" class="btn">Login</button>
        <button type="reset" class="btn-reset">Batal</button>

    </form>

    <div class="footer">
        <p>© 2026 POLGAN MART</p>
    </div>
</div>

</body>
</html>
