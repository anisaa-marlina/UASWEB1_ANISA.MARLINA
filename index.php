<?php
session_start();
include 'koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Ambil user berdasarkan email
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($query) == 1) {

        $row = mysqli_fetch_assoc($query);

        // CEK PASSWORD (karena kamu masih pakai plaintext)
        if ($password === $row['password']) {

            // === SESSION UTAMA ===
            $_SESSION['id_user'] = $row['id'];      // KUNCI
            $_SESSION['name']    = $row['name'];
            $_SESSION['email']   = $row['email'];
            $_SESSION['role']    = $row['role'];

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
*{box-sizing:border-box}
body{
    margin:0;
    min-height:100vh;
    font-family:Arial,sans-serif;
    background:#2c3e50;
    display:flex;
    justify-content:center;
    align-items:center;
}
.login-card{
    background:#fff;
    width:100%;
    max-width:360px;
    padding:20px;
    border-radius:10px;
    box-shadow:0 6px 18px rgba(0,0,0,.2);
}
.login-card h2{
    text-align:center;
    margin-bottom:15px;
    color:#2c3e50;
}
.form-group{margin-bottom:10px}
.form-group label{
    font-size:13px;
    font-weight:bold;
}
.form-group input{
    width:100%;
    padding:9px;
    border-radius:5px;
    border:1px solid #ccc;
}
.password-wrapper{position:relative}
.password-wrapper input{padding-right:38px}
.toggle-password{
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#777;
}
.btn{
    width:100%;
    padding:9px;
    margin-top:6px;
    background:#3498db;
    border:none;
    color:#fff;
    border-radius:5px;
    cursor:pointer;
}
.btn:hover{background:#2980b9}
.btn-reset{
    background:#bdc3c7;
    color:#000;
}
.error{
    background:#e74c3c;
    color:#fff;
    padding:8px;
    border-radius:5px;
    margin-bottom:10px;
    text-align:center;
}
.footer{
    text-align:center;
    margin-top:10px;
    font-size:11px;
    color:#777;
}
</style>
</head>
<body>

<div class="login-card">
    <h2>POLGAN MART</h2>

    <?php if ($error != "") { ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" required>
                <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword()"></i>
            </div>
        </div>

        <button type="submit" class="btn">Login</button>
        <button type="reset" class="btn btn-reset">Batal</button>
    </form>

    <div class="footer">© 2026 POLGAN MART</div>
</div>

<script>
function togglePassword(){
    const pass = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if(pass.type === "password"){
        pass.type = "text";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }else{
        pass.type = "password";
        icon.classList.replace("fa-eye","fa-eye-slash");
    }
}
</script>

</body>
</html>
