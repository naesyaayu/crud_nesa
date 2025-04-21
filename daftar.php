<?php
session_start();
include "db.php";

if (isset($_POST['daftar'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $nama = $_POST['nama'];

    $checkQuery = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($checkQuery) > 0) {
        echo '<script>alert("Username sudah terdaftar, silakan pilih username lain.");</script>';
    } else {
        $query = "INSERT INTO user (username, password, role, nama) VALUES ('$username', '$password', 'pelanggan', '$nama')";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Pendaftaran berhasil! Silakan login."); window.location.href="login.php";</script>';
        } else {
            echo '<script>alert("Terjadi kesalahan. Coba lagi.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Pendaftaran</h1>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <button type="submit" name="daftar">Daftar</button>
    </form>

    <br>
    <a href="login.php">
        <button type="button">Kembali ke Login</button>
    </a>
</body>
</html>
