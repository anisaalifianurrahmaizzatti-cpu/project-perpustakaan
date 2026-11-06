<?php
include "config/koneksi.php";

if (isset($_POST['update'])) {
    $id           = $_POST['id'];
    $judul        = $_POST['judul'];
    $kategori     = $_POST['kategori'];
    $penulis      = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok         = $_POST['stok'];
    $sampul_lama  = $_POST['sampul_lama'];

    $nama_file    = $_FILES['sampul']['name'];
    $ukuran_file  = $_FILES['sampul']['size'];
    $tmp_file     = $_FILES['sampul']['tmp_name'];

    // Jika user mengupload file sampul baru
    if (!empty($nama_file)) {
        $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_diijinkan = ['jpg', 'jpeg', 'png'];

        if (in_array($ekstensi, $ekstensi_diijinkan)) {
            if ($ukuran_file <= 2097152) {
                $nama_baru = time() . '_' . basename($nama_file);
                $path = "uploads/" . $nama_baru;

                if (move_uploaded_file($tmp_file, $path)) {
                    // Hapus file sampul lama jika ada
                    if (file_exists("uploads/" . $sampul_lama)) {
                        unlink("uploads/" . $sampul_lama);
                    }
                    $sampul_terpilih = $nama_baru;
                } else {
                    echo "Gagal mengunggah file baru!";
                    exit;
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location='edit_buku.php?id=$id';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Ekstensi file tidak valid!'); window.location='edit_buku.php?id=$id';</script>";
            exit;
        }
    } else {
        // Jika tidak ganti gambar, gunakan sampul lama
        $sampul_terpilih = $sampul_lama;
    }

    // Query Update ke database
    $query = "UPDATE buku SET 
                judul = '$judul', 
                kategori = '$kategori', 
                penulis = '$penulis', 
                tahun_terbit = '$tahun_terbit', 
                stok = '$stok', 
                sampul = '$sampul_terpilih' 
              WHERE id = '$id'";
              
    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        header("location: dashboard.php?pesan=Berhasil update data");
    } else {
        echo "Gagal mengupdate database: " . mysqli_error($koneksi);
    }
}
?>