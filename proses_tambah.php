<?php
include "config/koneksi.php";

if (isset($_POST['simpan'])) {
    $judul        =$_POST['judul'];
    $kategori     =$_POST['kategori'];
    $penulis      =$_POST['penulis'];
    $tahun_terbit =$_POST['tahun_terbit'];
    $stok         =$_POST['stok'];

    // Konfigurasi File Upload
    $nama_file    =$_FILES['sampul']['name'];
    $ukuran_file  =$_FILES['sampul']['size'];
    $tmp_file     =$_FILES['sampul']['tmp_name'];
    $ekstensi     = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    
    // Validasi ekstensi
    $ekstensi_diijinkan = ['jpg', 'jpeg', 'png'];
    
    if (in_array($ekstensi,$ekstensi_diijinkan)) {
        // Validasi ukuran maksimal 2MB (2 * 1024 * 1024 bytes)
        if ($ukuran_file <= 2097152) {
            // Beri nama unik agar tidak bentrok
            $nama_baru = time() . '_' . basename($nama_file);
            $path = "uploads/" . $nama_baru;

            if (move_uploaded_file($tmp_file,$path)) {
                // Query Insert ke database
                $query = "INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) 
                          VALUES ('$judul', '$kategori', '$penulis', '$tahun_terbit', '$stok', '$nama_baru')";
                $sql = mysqli_query($koneksi,$query);

                if ($sql) {
                    header("location: dashboard.php?pesan=Berhasil tambah data");
                } else {
                    echo "Gagal menyimpan ke database: " . mysqli_error($koneksi);
                }
            } else {
                echo "Gagal mengunggah file gambar!";
            }
        } else {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location='tambah_buku.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi file tidak valid! Hanya format JPG, JPEG, dan PNG yang diizinkan.'); window.location='tambah_buku.php';</script>";
    }
}
?>