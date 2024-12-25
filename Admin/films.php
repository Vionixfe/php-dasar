<?php


session_start();

if (!isset($_SESSION['username'])) {
  echo "<script>
            alert('Please login first');
            document.location.href = 'login.php';
        </script>";

  exit;
}


$title = "Film";
require "layout/header-datatable.php";

//$films = query("SELECT * FROM films ORDER BY created_at DESC");
$films = query("SELECT f.id_film, f.title, f.studio, f.is_private, f.created_at, c.title as category_title FROM films f JOIN categories c ON f.category_id = c.id_category ORDER BY f.created_at DESC");

?>

<!-- main -->
<main class="p-4">
    <div class="containter">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-film"></i>
                        <?= $title; ?>
                    </div>

                    <div class="card-body shadow-sm">
                        <di class="table-responsive">
                            <a href="films-create.php" class="btn btn-primary"><i classs="bi bi-plus"></i>+ Create</a>
                            <a href="films-download.php" class="btn btn-info text-white"><i class="bi bi-download"></i> Download</a>
                    <div class="card-body">
                        <table id="example" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Name</th>
                                    <th>Studio</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th  width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                <?php foreach ($films as $film) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $film['title']; ?></td>
                                        <td><?= $film['studio']; ?></td>
                                        <td><?= $film['category_title']; ?></td>
                                        <td><?= $film['is_private'] ? 'private' : 'public'; ?></td>
                                        <td><?= $film['created_at']; ?>
                                    </td>
                                        <td class="text-center">
                                        <a href="films-detail.php?id=<?= $film['id_film']; ?>"  class="btn btn-sm btn-secondary mb-1" title="Detail"><i class="bi bi-eye"></i></a>
                                        <a href="films-edit.php?id=<?= $film['id_film']; ?>"  class="btn btn-sm btn-success mb-1" title="Edit"><i class="bi bi-pen"></i></href=>
                                        <a href="films-delete.php?id=<?= $film['id_film']; ?>" onclick = "return confirm('Yakin ingin menghapus Film?')" class="btn btn-sm btn-danger mb-1" title="Delete"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require "layout/footer-datatable.php";
?>