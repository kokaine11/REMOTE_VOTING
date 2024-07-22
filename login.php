<?php
session_start();
include 'includes/conn.php';

if(isset($_POST['login'])){
    $voter = $_POST['voter'];
    $code = $_POST['code'];

    // Validate Voter's ID
    $sql = "SELECT * FROM voters WHERE voters_id = '$voter'";
    $query = $conn->query($sql);

    if($query->num_rows < 1){
        $_SESSION['error'] = 'Cannot find voter with the ID';
    }
    else{
        $row = $query->fetch_assoc();
        // Validate the Code
        if($row['code'] == $code){
            $_SESSION['voter'] = $row['id'];
            header('location: home.php');
            exit(); // Ensure script stops execution after redirect
        }
        else{
            $_SESSION['error'] = 'Incorrect code';
        }
    }
}
else{
    $_SESSION['error'] = 'Input voter credentials first';
}

header('location: index.php');
?>
