<?php
session_start();
include __DIR__ . '/../koneksi.php';

/* CEK LOGIN */
if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* AMBIL DATA USER */
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id_user'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "<h3>User tidak ditemukan</h3>";
    exit;
}

/* UPDATE PROFILE */
if (isset($_POST['update'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query($conn, "
        UPDATE users SET
        name='$name',
        email='$email'
        WHERE id='$id_user'
    ");

    // update session juga
    $_SESSION['name']  = $name;
    $_SESSION['email'] = $email;

    header("Location: ../dashboard.php?page=profile");
    exit;
}
?>

<style>
.profile-wrapper{
    background: linear-gradient(135deg,#0f172a,#1e293b);
    padding:40px;
    border-radius:12px;
}

.profile-card{
    max-width:500px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

.avatar{
    width:90px;
    height:90px;
    background:#0f172a;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:36px;
    font-weight:bold;
    margin:0 auto 15px;
}

.profile-card h2{
    text-align:center;
    margin-bottom:25px;
    color:#0f172a;
}

.profile-card label{
    font-size:13px;
    font-weight:bold;
    color:#374151;
}

.profile-card input{
    width:100%;
    padding:10px;
    margin-top:6px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #cbd5e1;
}

.btn-group{
    display:flex;
    gap:10px;
}

.btn-save{
    flex:1;
    padding:10px;
    background:#0f172a;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.btn-save:hover{
    background:#020617;
}

.btn-cancel{
    flex:1;
    padding:10px;
    background:#e5e7eb;
    text-align:center;
    border-radius:6px;
    text-decoration:none;
    color:#111827;
}
</style>

<div class="profile-wrapper">
    <div class="profile-card">

        <div class="avatar">
            <?= strtoupper(substr($user['name'],0,1)); ?>
        </div>

        <h2>My Profile</h2>

        <form method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="<?= $user['name']; ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= $user['email']; ?>" required>

            <div class="btn-group">
                <button type="submit" name="update" class="btn-save">
                    Update Profile
