<?php
session_start();
include "config/koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']); // Sesuaikan enkripsi password di database

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $data['username'];

    // Jika checklist Remember Me dicentang, buat Cookie selama 1 menit / 1 hari
    if (isset($_POST['remember'])) {
        setcookie('cookie_user', $data['username'], time() + (86400 * 30), "/");
    }

    header("location: dashboard.php");
} else {
    header("location: index.php?pesan=Username atau Password salah!");
}
?>