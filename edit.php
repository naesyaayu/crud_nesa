<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'db.php';

if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM barang WHERE id_barang = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_barang);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $barang = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$barang) {
        echo "Barang tidak ditemukan.";
        exit;
    }
} else {
    echo "ID Barang tidak ditemukan.";
    exit;
}

if (isset($_POST['update'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    if (is_numeric($harga) && is_numeric($stok) && $harga > 0 && $stok >= 0) {
        $stmt = mysqli_prepare($conn, "UPDATE barang SET nama_barang = ?, harga = ?, stok = ? WHERE id_barang = ?");
        mysqli_stmt_bind_param($stmt, 'sdii', $nama_barang, $harga, $stok, $id_barang);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($result) {
            header('Location: admin.php'); 
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui barang.');</script>";
        }
    } else {
        echo "<script>alert('Harga dan stok harus berupa angka positif.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang - Toko Sembako</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Barang</h1>

    <form method="POST" action="edit.php?id_barang=<?= $barang['id_barang'] ?>">
        <input type="text" name="nama_barang" value="<?= $barang['nama_barang'] ?>" required>
        <input type="number" name="harga" value="<?= $barang['harga'] ?>" required>
        <input type="number" name="stok" value="<?= $barang['stok'] ?>" required>
        <button type="submit" name="update">Perbarui Barang</button>
    </form>

    <form method="POST" action="edit.php">
        <button type="submit" name="logout">Logout</button>
    </form>

    <!-- Tombol Kembali ke Admin -->
    <form method="get" action="admin.php">
        <button type="submit">Kembali</button>
    </form>

</body>
</html>
