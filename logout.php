<?php
session_start();
session_unset();
session_destroy();

// Hapus cookie
if (isset($_COOKIE['cookie_user'])) {
    setcookie('cookie_user', '', time() - 3600, "/");
}

header("location: index.php?pesan=Berhasil logout!");
exit;
?>