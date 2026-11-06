<?php
session_start();
// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("location: index.php?pesan=Silakan login terlebih dahulu!");
    exit;
}

include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Mini Digital Library</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-white me-3">Halo, <b><?php echo $_SESSION['username']; ?></b></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Koleksi Buku</h3>
            <a href="tambah_buku.php" class="btn btn-primary">+ Tambah Buku Baru</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Sampul</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
                        while ($row = mysqli_fetch_assoc($query)) {
                            // Logika percabangan status ketersediaan buku
                            if ($row['stok'] > 0) {
                                $status = '<span class="badge bg-success">Tersedia</span>';
                            } else {
                                $status = '<span class="badge bg-danger">Dipinjam / Habis</span>';
                            }
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td class="text-center">
                                <?php if($row['sampul']): ?>
                                    <img src="uploads/<?php echo $row['sampul']; ?>" width="50" height="70" class="object-fit-cover rounded">
                                <?php else: ?>
                                    <span class="text-muted small">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['judul']; ?></td>
                            <td><?php echo $row['kategori']; ?></td>
                            <td><?php echo $row['penulis']; ?></td>
                            <td class="text-center"><?php echo $row['tahun_terbit']; ?></td>
                            <td class="text-center"><?php echo $row['stok']; ?></td>
                            <td class="text-center"><?php echo $status; ?></td>
                            <td class="text-center">
                                <a href="edit_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>