<?php
require 'vendor/autoload.php';
require 'config/app.php';

session_start();

if (!isset($_SESSION['login'])) {
  echo "<script>
            alert('Please login first');
            document.location.href = 'login.php';
        </script>";

  exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$activeWorksheet->setCellValue('A2', 'No')->getColumnDimension('A')->setAutoSize(true);
$activeWorksheet->setCellValue('B2', 'Category')->getColumnDimension('B')->setAutoSize(true);
$activeWorksheet->setCellValue('C2', 'URL')->getColumnDimension('C')->setAutoSize(true);
$activeWorksheet->setCellValue('D2', 'Title')->getColumnDimension('D')->setAutoSize(true);
$activeWorksheet->setCellValue('E2', 'Slug')->getColumnDimension('E')->setAutoSize(true);
$activeWorksheet->setCellValue('F2', 'Description')->getColumnDimension('F')->setAutoSize(true);
$activeWorksheet->setCellValue('G2', 'Release Date')->getColumnDimension('G')->setAutoSize(true);
$activeWorksheet->setCellValue('H2', 'Studio')->getColumnDimension('H')->setAutoSize(true);
$activeWorksheet->setCellValue('I2', 'Status')->getColumnDimension('I')->setAutoSize(true);
$activeWorksheet->setCellValue('J2', 'Created At')->getColumnDimension('J')->setAutoSize(true);
$styleColoum = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            
        ],
    ],
];

$no =1;
$loc= 3;

$films = query("SELECT f.id_film, f.url, f.title, f.slug, f.description, f.release_date, f.studio, f.category_id, f.is_private, f.created_at, c.title AS category_title FROM films f JOIN categories c ON f.category_id = c.id_category ORDER BY f.created_at DESC");

    foreach ($films as $film) {
        $activeWorksheet->setCellValue('A'.$loc, $no++);
        $activeWorksheet->setCellValue('B'.$loc, $film['category_title']);
        $activeWorksheet->setCellValue('C'.$loc, $film['url']);
        $activeWorksheet->setCellValue('D'.$loc, $film['title']);
        $activeWorksheet->setCellValue('E'.$loc, $film['slug']);
        $activeWorksheet->setCellValue('F'.$loc, $film['description']);
        $activeWorksheet->setCellValue('G'.$loc, $film['release_date']);
        $activeWorksheet->setCellValue('H'.$loc, $film['studio']);
        $activeWorksheet->setCellValue('I'.$loc, $film['is_private'] ? 'Private' : 'Public');
        $activeWorksheet->setCellValue('J'.$loc, $film['created_at']);

        $loc++;
    }

$activeWorksheet->getStyle('A2:J'.$loc - 1)->applyFromArray($styleColoum);

$writer = new Xlsx($spreadsheet);
$file_nama='films list.xlsx';
$writer->save($file_nama);

// Pastikan file ada dan tidak kosong
if (!file_exists($file_nama) || filesize($file_nama) == 0) {
    die('File tidak ditemukan atau kosong.');
}

// Hapus output yang ada
ob_end_clean();

// Atur header
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($file_nama));
header('Content-Disposition: attachment; filename="' . basename($file_nama) . '"');

// Kirim file ke browser
readfile($file_nama);

// Hapus file setelah diunduh
unlink($file_nama);

// if (file_exists($file_nama)) {
//     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//     header('Content-Length: ' . filesize($file_nama));
//     header('Content-Disposition: attachment; filename="' . $file_nama . '"');
//     readfile($file_nama);
//     unlink($file_nama);

//     echo "<script>
//     alert('Films has been downloaded');
//     window.location.href='films.php';
//     </script>";
// } else {
//     echo "<script>
//     alert('Films has not been downloaded');
//     window.location.href='films.php';
//     </script>";
// }
