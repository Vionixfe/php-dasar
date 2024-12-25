<?php
require "config/app.php";

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Please login first');
            document.location.href = 'login.php';
          </script>";
    exit;
}

// Periksa apakah user sudah login dan role adalah admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('Akses ditolak! Hanya admin yang bisa menghapus data.');
            document.location.href = 'films.php';
          </script>";
    exit;
}

$id_film = (int)$_GET['id'];

$getDataById = query("SELECT * FROM films WHERE id_film = $id_film")[0];

if(count($getDataById) == 0) {
    echo "<script>
        alert('Film not found');
        document.location.href = 'films.php';
    </script>";
    exit;
}

if (delete_film($id_film) > 0) {
    echo "<script>
        alert('Film has been deleted');
        document.location.href = 'films.php';
    </script>";
}
else {
    echo "<script>
        alert('Film has not been deleted');
        document.location.href = 'films-create.php';
    </script>";
}
?>
