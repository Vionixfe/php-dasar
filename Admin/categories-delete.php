<?php
require "config/app.php";

session_start();

// Periksa apakah user sudah login dan role adalah admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('Akses ditolak! Hanya admin yang bisa menghapus data.');
            document.location.href = 'categories.php';
          </script>";
    exit;
}

$id_category = (int)$_GET['id'];

$getDataById = query("SELECT * FROM categories WHERE id_category = $id_category")[0];

if(count($getDataById) == 0) {
    echo "<script>
        alert('Categories not found');
        document.location.href = 'categories.php';
    </script>";
}

if (delete_category($id_category) > 0) {
    echo "<script>
        alert('Categories has been deleted');
        document.location.href = 'categories.php';
    </script>";
}
else {
    echo "<script>
        alert('Categories has not been deleted');
        document.location.href = 'categories-create.php';
    </script>";
}


?>