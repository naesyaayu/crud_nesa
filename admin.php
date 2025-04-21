<?php
session_start();

// Logout Handling
if (isset($_POST['logout'])) {
    session_destroy();  // Hapus session untuk logout
    header('Location: login.php');  // Arahkan kembali ke halaman login
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Handle Add Barang
if (isset($_POST['add'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    if (is_numeric($harga) && is_numeric($stok) && $harga > 0 && $stok >= 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO barang (nama_barang, harga, stok) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sdi', $nama_barang, $harga, $stok); // 's' untuk string, 'd' untuk double, 'i' untuk integer
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!$result) {
            echo "<script>alert('Gagal menambahkan barang');</script>";
        }
    } else {
        echo "<script>alert('Harga dan stok harus berupa angka positif.');</script>";
    }
}

// Handle Delete Barang
if (isset($_GET['delete'])) {
    $id_barang = $_GET['delete'];  

    if (is_numeric($id_barang)) {
        $stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id_barang = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id_barang); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('ID barang tidak valid.');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Toko Sembako</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Toko Sembako</h1>

    <!-- Form untuk menambah barang baru -->
    <form method="POST" action="admin.php">
        <input type="text" name="nama_barang" placeholder="Nama Barang" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="number" name="stok" placeholder="Stok" required>
        <button type="submit" name="add">Tambah Barang</button>
    </form>

    <h2>Daftar Barang</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id_barang'] ?></td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['harga'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <a href="edit.php?id_barang=<?= $row['id_barang'] ?>">Edit</a> |
                <a href="admin.php?delete=<?= $row['id_barang'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Form Logout -->
    <form method="POST" action="admin.php">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
