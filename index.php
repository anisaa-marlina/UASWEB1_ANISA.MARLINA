<?php
session_start();
include 'koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if ($row = mysqli_fetch_assoc($query)) {
        if ($password == $row['password']) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['name']  = $row['name'];
            $_SESSION['role']  = $row['role'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<div class="login-card">
    <h2>POLGAN MART</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="post">
        <label>Email</label><br>
        <input type="email" name="email" placeholder="Masukkan email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" placeholder="Masukkan password" required><br><br>

        <button type="submit">Login</button>
        <button type="reset">Batal</button>
    </form>

</div>

</body>
</html>
