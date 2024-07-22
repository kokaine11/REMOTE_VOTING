<?php
    session_start();
    if(isset($_SESSION['admin'])){
        header('location: admin/home.php');
    }
    if(isset($_SESSION['voter'])){
        header('location: home.php');
    }
?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            background-image: url('images/xxcoldestvote.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .form-container {
            z-index: 1;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9); /* Form background color */
            text-align: center;
            /* border-radius: 10px;  */
            
            
        }

        .login-logo {
            margin-bottom: 20px;
        }
        .login-logo b {
            font-size: 1.2em;
            color: #176684;
            font-weight: bold;
        }
        .login-box-msg {
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 20px;
            color: #555;
        }
        .smiley {
            color: goldenrod;
            font-size: 45px;
        }
        .form-control {
            font-size: 1.5em;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            border-color: #176684;
        }
        .btn-primary {
            background: #176684;
            border: none;
            border-radius: 25px;
            font-size: 1.3em;
            color: white;
            padding: 10px;
        }
        .btn-primary:hover {
            background-color: #28a745;
        }
        .callout-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .form-group {
            position: relative;
        }
        .form-control-feedback {
            position: absolute;
            right: 15px;
            top: 85%;
            transform: translateY(-50%);
            font-size: 1.2em;
            color: #28a745;
        }
        .header-title {
            position: absolute;
            top: 28px;
            text-align: center;
            color: #ffffff;
            font-family: serif;
            font-size: 6.0em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            z-index: 2;
        }

        
    </style>
</head>
<body>
    <div class="header-title">Online Voting System</div>
    <div class="form-container">
        <div class="login-logo">
            <b>Welcome</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to vote</p>
            <form action="login.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="voter" placeholder="Voter ID" required>
                    <span class="fas fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="code" placeholder="Code" required>
                    <span class="fas fa-unlock-alt form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block" name="login"><i class="fas fa-sign-in-alt"></i> Sign In</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
            if(isset($_SESSION['error'])){
                echo "
                    <div class='callout-danger text-center'>
                        <p>".$_SESSION['error']."</p>
                    </div>
                ";
                unset($_SESSION['error']);
            }
        ?>
    </div>

    <?php include 'includes/scripts.php' ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
