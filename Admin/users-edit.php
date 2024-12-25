<?php
$title="Edit Users";
require "layout/header.php";
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

// Mengimpor koneksi database
require 'config/database.php'; 

$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['edit'])) {
    if (edit_user($_POST) > 0) {
        echo "<script>
            alert('users has been updated');
            document.location.href = 'users.php';
        </script>";
    }
    else {
        echo "<script>
            alert('users has not been updated');
            document.location.href = 'users-edit.php?id=$id';
        </script>";
    }
}
    
?>

<!--main-->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-pen"></i>
                        Edit User
                    </div>

                    <div class="card-body shadow-sm">
                        <form action="" method="post">
                            <input type="hidden" name="id_user" value="<?= $users['id_user']; ?>">

                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username"
                                    name="username" required value="<?= $users['username'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email"
                                    name="email" required value="<?= $users['email'] ?>">
                            </div>
                            <?php if ($_SESSION['role'] == '0'): ?>
                            <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                            <?php endif; ?>
     

                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                <div class="mb-3 col-md-6">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-select" required>
                                        <option value="" hidden>---Select---</option>
                                        <option value="0" <?= $users['role'] == '0' ? 'selected' : ''; ?>>Operator</option>
                                        <option value="1" <?= $users['role'] == '1' ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="role" value="<?= $users['role']; ?>">
                                <div class="mb-3 col-md-6">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" id="role"
                                           value="<?= $users['role'] == '0' ? 'Operator' : 'Admin'; ?>" disabled>
                                </div>
                            <?php endif; ?>

                            <div class="float-end">
                                <button type="submit" class="btn btn-primary" name="edit"><i class="bi bi-upload"></i> Edit </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<?php include "layout/footer.php"; ?>
                            