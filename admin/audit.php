<?php
// session_start();

// Hashed password for admin (replace with your hashed password)
$hashedAdminPassword = '$2y$10$l0yFTnR.4Kdj5UJqTleLRukCPVdVkDspHoT3SDmGQgATgMdrH9.h2'; // Example hash

// Function to log events to a text file
function logEvent($event) {
    // Define the path to your log file
    $logFile = 'C:/xampp/htdocs/logs/audit_log.txt'; // Adjusted path

    // Get the current timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Format the log entry
    $logEntry = "[{$timestamp}] {$event}\n";

    // Append the log entry to the file
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

// Function to verify if user is admin
function isAdmin($password) {
    global $hashedAdminPassword;
    // Use password_verify to compare hashed passwords
    return password_verify($password, $hashedAdminPassword);
}

// Handling download request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if password is provided
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];

        // Check if password is correct
        if (isAdmin($password)) {
            $_SESSION['is_admin'] = true;

            // Log the login event
            logEvent("Administrator logged in");

            // Serve the audit log file for download
            $logFile = 'C:/xampp/htdocs/logs/audit_log.txt'; // Adjusted path

            // Check if the file exists
            if (file_exists($logFile)) {
                // Set headers for download
                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename="audit_log.txt"');
                readfile($logFile);
                exit;
            } else {
                die("Audit log file not found.");
            }
        } else {
            // Log failed login attempt
            logEvent("Failed login attempt with password: {$_POST['password']}");

            // Redirect back to the same page with an error message using GET
            header('Location: ' . $_SERVER['PHP_SELF'] . '?error=1');
            exit;
        }
    } else {
        // Redirect back to the same page with an error message if password is empty
        header('Location: ' . $_SERVER['PHP_SELF'] . '?error=2');
        exit;
    }
}

// Check for error message in GET parameter and display it
$errorMsg = '';
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 1) {
        $errorMsg = 'Incorrect password. Please try again.';
    } elseif ($error == 2) {
        $errorMsg = 'Password cannot be empty. Please enter a password.';
    }
}

// Example usage: log some events (you can extend this for other actions)
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    logEvent("Admin session started");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Audit Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="password"] {
            padding: 8px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Download Audit Log</h2>
        
        <?php if (!empty($errorMsg)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($errorMsg); ?></p>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="password">Admin Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <br>
            <button type="submit">Download Audit Log</button>
        </form>
    </div>
</body>
</html>
