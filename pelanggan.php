<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pelanggan') {
    header("Location: login.php");
    exit();
}

include "db.php";

$result = mysqli_query($conn, "SELECT * FROM barang");

if (isset($_POST['buy']) && isset($_POST['id_barang']) && isset($_POST['jumlah'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $result_barang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = $id_barang");
    $barang = mysqli_fetch_assoc($result_barang);

    if ($barang['stok'] >= $jumlah) {
        $total_harga = $barang['harga'] * $jumlah;
        
        $new_stok = $barang['stok'] - $jumlah;
        mysqli_query($conn, "UPDATE barang SET stok = $new_stok WHERE id_barang = $id_barang");

        $id_pelanggan = $_SESSION['user']['id'];  
        $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_pelanggan, id_barang, jumlah, total_harga) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iiid', $id_pelanggan, $id_barang, $jumlah, $total_harga);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<p class='total-harga'>Pembelian berhasil! Total harga: Rp $total_harga</p>";
    } else {
        echo "<p>Stok tidak cukup untuk jumlah yang diminta!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pelanggan - Toko Sembako</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .total-harga {
            font-size: 18px;
            font-weight: bold;
            color: #4caf50;
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #4caf50;
            border-radius: 5px;
            background-color: #e8f5e9;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Pembelian Barang</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Beli</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id_barang'] ?></td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['harga'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                    <input type="number" name="jumlah" min="1" max="<?= $row['stok'] ?>" required>
                    <button type="submit" name="buy">Beli</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="login.php">Logout</a>
</body>
</html>
