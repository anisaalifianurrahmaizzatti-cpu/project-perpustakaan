<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit;
}

include "config/koneksi.php";

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Form Edit Buku</h4>
            </div>
            <div class="card-body">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="sampul_lama" value="<?php echo $row['sampul']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" value="<?php echo $row['judul']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?php echo $row['kategori']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="<?php echo $row['penulis']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control" value="<?php echo $row['tahun_terbit']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?php echo $row['stok']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampul Buku Saat Ini:</label><br>
                        <?php if($row['sampul']): ?>
                            <img src="uploads/<?php echo $row['sampul']; ?>" width="60" class="mb-2 rounded">
                        <?php else: ?>
                            <span class="text-muted">Tidak ada sampul</span>
                        <?php endif; ?>
                        <input type="file" name="sampul" class="form-control mt-2" accept=".jpg, .jpeg, .png">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti sampul.</small>
                    </div>
                    <button type="submit" name="update" class="btn btn-warning">Update Buku</button>
                    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>