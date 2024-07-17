<?php
require 'vendor/autoload.php';
include 'includes/session.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['file']['name'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowedTypes = ['xls', 'xlsx', 'csv'];

    if (in_array($fileExtension, $allowedTypes)) {
        try {
            $spreadsheet = IOFactory::load($fileTmpName);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {
                $firstname = $row[0];
                $lastname = $row[1];
                $position = $row[2];
                $platform = $row[3];
                $photo = $row[4]; // Assumes photo path or filename is included in the Excel file

                // Insert data into the database
                $sql = "INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES ('$position', '$firstname', '$lastname', '$photo', '$platform')";
                $query = $conn->query($sql);

                if (!$query) {
                    $_SESSION['error'] = 'Error importing data: ' . $conn->error;
                    header('location: candidates.php');
                    exit();
                }
            }

            $_SESSION['success'] = 'Data imported successfully.';
            header('location: candidates.php');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error loading file: ' . $e->getMessage();
            header('location: candidates.php');
        }
    } else {
        $_SESSION['error'] = 'Invalid file type. Only XLS, XLSX, and CSV files are allowed.';
        header('location: candidates.php');
    }
} else {
    $_SESSION['error'] = 'No file uploaded.';
    header('location: candidates.php');
}
?>
