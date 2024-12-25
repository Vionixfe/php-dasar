<?php
require "config/app.php";

session_start();

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
            document.location.href = 'users.php';
          </script>";
    exit;
}

$id_user = (int)$_GET['id'];

$getDataById = query("SELECT * FROM users WHERE id_user = $id_user")[0];

if(count($getDataById) == 0) {
    echo "<script>
        alert('User not found');
        document.location.href = 'users.php';
    </script>";
    exit;
}

if (delete_users($id_user) > 0) {
    echo "<script>
        alert('User has been deleted');
        document.location.href = 'users.php';
    </script>";
}
else {
    echo "<script>
        alert('User has not been deleted');
        document.location.href = 'users-create.php';
    </script>";
}
?>

