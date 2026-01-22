<?php
session_start();
include 'koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

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
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login POLGAN MART</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    background: #2c3e50;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
}

/* CARD */
.login-card {
    background: #ffffff;
    width: 100%;
    max-width: 360px;   /* INI KUNCI → beda terasa */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}

/* TITLE */
.login-card h2 {
    text-align: center;
    margin: 0 0 14px;
    font-size: 20px;
    color: #2c3e50;
}

/* FORM */
.form-group {
    margin-bottom: 10px;
}

.form-group label {
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 4px;
    display: block;
}

.form-group input {
    width: 100%;
    padding: 9px 10px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* PASSWORD */
.password-wrapper {
    position: relative;
}

.password-wrapper input {
    padding-right: 38px;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #777;
    font-size: 15px;
}

.toggle-password:hover {
    color: #3498db;
}

/* BUTTON */
.btn {
    width: 100%;
    padding: 9px;
    margin-top: 6px;
    background: #3498db;
    border: none;
    color: white;
    border-radius: 5px;
    font-size: 15px;
    cursor: pointer;
}

.btn:hover {
    background: #2980b9;
}

.btn-reset {
    width: 100%;
    padding: 9px;
    margin-top: 6px;
    background: #bdc3c7;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

/* ERROR */
.error {
    background: #e74c3c;
    color: white;
    padding: 8px;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 13px;
}

/* FOOTER */
.footer {
    text-align: center;
    margin-top: 10px;
    font-size: 11px;
    color: #777;
}

/* RESPONSIVE EXTRA */
@media (max-width: 480px) {
    .login-card {
        padding: 18px;
    }

    .login-card h2 {
        font-size: 18px;
    }
}
</style>
</head>
<body>

<div class="login-card">
    <h2>POLGAN MART</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword()"></i>
            </div>
        </div>

        <button type="submit" class="btn">Login</button>
        <button type="reset" class="btn-reset">Batal</button>
    </form>

    <div class="footer">
        © 2026 POLGAN MART
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    }
}
</script>

</body>
</html>
