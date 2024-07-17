<?php
include 'includes/session.php';

if (isset($_POST['curr_password'])) {
    $curr_password = $_POST['curr_password'];
    $admin_id = $_SESSION['admin'];

    $sql = "SELECT * FROM admin WHERE id = '$admin_id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    if (password_verify($curr_password, $row['password'])) {
        // Password is correct, proceed to reset votes
        $reset_sql = "DELETE FROM votes";
        if ($conn->query($reset_sql)) {
            $_SESSION['success'] = 'Votes reset successfully.';
        } else {
            $_SESSION['error'] = $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Incorrect password.';
    }
} else {
    $_SESSION['error'] = 'Please enter your password.';
}

header('location: votes.php');
?>