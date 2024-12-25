<?php

$title = 'Create Users';
require "layout/header.php";

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Please login first');
              document.location.href = 'login.php';
          </script>";
  
    exit;
  }
  
// Cek apakah pengguna sudah login dan perannya admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('Akses ditolak! Hanya admin yang bisa menambah pengguna.');
            document.location.href = 'users.php';
          </script>";
    exit;
}


if (isset($_POST['submit'])) {
    if (store_user($_POST) > 0) {
        echo "<script>
                alert('Users has been created');
                document.location.href = 'users.php';
            </script>";
    } else {
        echo "<script>
                alert('Users has not been created');
                document.location.href = 'users-create.php';
            </script>";
    }
}

?>

<!-- main -->
<main class="p-4">
    <div class="containter">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-plus"></i>
                        <?= $title; ?>
                    </div>

                    <div class="card-body shadow-sm">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="" hidden>---Select---</option>
                                    <option value="0">Operator</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>

                            <div class="float-end">
                                <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-upload"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require "layout/footer.php"; ?>
