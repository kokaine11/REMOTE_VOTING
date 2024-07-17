<?php
require 'vendor/autoload.php';
include 'includes/session.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['file']['name'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowedType = array('xls', 'xlsx', 'csv');

    if (in_array($fileExtension, $allowedType)) {
        $spreadsheet = IOFactory::load($fileTmpName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $row) {
            $lastname = $row[0];
            $firstname = $row[1];
            $voters_id = $row[2];
            $photo = ''; // If you have photo information in your Excel file, you can handle it here

            $sql = "INSERT INTO voters (lastname, firstname, voters_id, photo) VALUES ('$lastname', '$firstname', '$voters_id', '$photo')";
            $query = $conn->query($sql);

            if (!$query) {
                $_SESSION['error'] = 'Error importing data.';
                header('location: index.php');
                exit();
            }
        }

        $_SESSION['success'] = 'Data imported successfully.';
        header('location: index.php');
    } else {
        $_SESSION['error'] = 'Invalid file type. Only XLS, XLSX, and CSV files are allowed.';
        header('location: index.php');
    }
}
?>
