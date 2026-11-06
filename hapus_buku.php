<?php
include "config/koneksi.php";

$id = $_GET['id'];

// Ambil nama file sampul berdasarkan id
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$row = mysqli_fetch_assoc($query);
$sampul = $row['sampul'];

// Hapus file fisik gambar dari folder uploads
if (!empty($sampul) && file_exists("uploads/" . $sampul)) {
    unlink("uploads/" . $sampul);
}

// Query Delete data dari database
$hapus = mysqli_query($koneksi, "DELETE FROM buku WHERE id = '$id'");

if ($hapus) {
    header("location: dashboard.php?pesan=Berhasil hapus data");
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>