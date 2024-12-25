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
$activeWorksheet->setCellValue('B2', 'Title')->getColumnDimension('B')->setAutoSize(true);
$activeWorksheet->setCellValue('C2', 'Slug')->getColumnDimension('C')->setAutoSize(true);
$activeWorksheet->setCellValue('D2', 'Created At')->getColumnDimension('D')->setAutoSize(true);

$styleColumn = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$no = 1;
$loc = 3;

$categories = query("SELECT * FROM categories ORDER BY created_at DESC");

foreach ($categories as $category) {
    $activeWorksheet->setCellValue('A'. $loc, $no++);
    $activeWorksheet->setCellValue('B'. $loc, $category['title']);
    $activeWorksheet->setCellValue('C'. $loc, $category['slug']);
    $activeWorksheet->setCellValue('D'. $loc, $category['created_at']);

    $loc++;
}

$activeWorksheet->getStyle('A2:D'. ($loc - 1))->applyFromArray($styleColumn);

$writer = new Xlsx($spreadsheet);
$file_name = 'Categories List.xlsx';
$writer->save($file_name);

// Pastikan file ada dan tidak kosong
if (!file_exists($file_name) || filesize($file_name) == 0) {
    die('File tidak ditemukan atau kosong.');
}

// Hapus output yang ada
ob_end_clean();

// Atur header
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($file_name));
header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

// Kirim file ke browser
readfile($file_name);

// Hapus file setelah diunduh
unlink($file_name);
