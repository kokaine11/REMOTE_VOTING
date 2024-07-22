<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}
?>
<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
	<style>
	body {
		height: 100%;
		margin: 0;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: #f8f9fa;
		background-image: url('images/admin.jpg');
		background-size: cover;
		background-repeat: no-repeat;
		background-position: left;
		position: relative; /* Added */
	}

	.container {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100vh; /* Full viewport height */
	}

	.login-box {
		z-index: 1;
		width: 100%;
		max-width: 400px;
		padding: 40px;
		background: rgba(255, 255, 255, 0.8);
		border-radius: 10px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		text-align: center;
		margin-left: auto;
		margin-right: auto; /* Center horizontally */
	}

	.login-logo b {
		color: #333;
		font-size: 2em;
	}

	.login-box-body {
		padding: 20px;
	}

	.login-box-msg {
		margin: 0;
		text-align: center;
		font-weight: bold;
	}

	.form-group {
		margin-bottom: 15px;
		border-radius: 20px;
	}

	.form-control {
		height: 45px;
		font-size: 16px;
	}

	.btn-primary {
		background: #176684;
		border: 2px solid #ccc;
		border-radius: 500px;
		font-size: 1em;
		color: white;
		padding: 10px;
		margin-left: auto;
		margin-right: auto; /* Center horizontally */
	}

	.btn-primary:hover {
		background-color: #0056b3;
		border-color: #004085;
	}

	.callout-danger {
		background-color: #f8d7da;
		color: #721c24;
		border-color: #f5c6cb;
		padding: 10px;
		margin-top: 20px;
		border-radius: 5px;
	}
	</style>
</head>

<body class="hold-transition login-page">
<div class="container">
    <div class="login-box">
        <div class="login-logo">
            <b>Admin</b>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="login.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
            if(isset($_SESSION['error'])){
                echo "
                    <div class='callout callout-danger text-center mt20'>
                        <p>".$_SESSION['error']."</p> 
                    </div>
                ";
                unset($_SESSION['error']);
            }
        ?>
    </div>
</div>

<?php include 'includes/scripts.php' ?>
</body>
</html>
