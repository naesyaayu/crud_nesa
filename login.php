<?php
session_start();
include "db.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);

        if ($password == $data['password']) {
            $_SESSION['user'] = $data;

            if ($data['role'] == 'admin') {
                $_SESSION['role'] = 'admin';
                header("Location: admin.php");
                exit;
            } else {
                $_SESSION['role'] = 'pelanggan';
                header("Location: pelanggan.php");
                exit;
            }
        } else {
            echo '<script>alert("Username atau Password tidak sesuai.");</script>';
        }
    } else {
        echo '<script>alert("Username tidak ditemukan.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Buah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: #4caf50;
            outline: none;
        }

        .button-group button {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-group button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        p a {
            color: #4caf50;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Akun</h2>
        <form method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="button-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <p>Belum punya akun? <a href="daftar.php">Daftar</a></p>
    </div>
</body>
</html>
