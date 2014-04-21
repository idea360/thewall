<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <script type="text/javascript" src="bootstrap.css"></script>
    <script type="text/javascript" src="jq.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <title>Welcome!</title>
</head>
<body>
    <?php
        if(isset($_SESSION['errors'])){
            foreach($_SESSION['errors'] as $error){ ?>
            	<div class="alert alert-warning alert-dismissable">
  					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>	
                	<strong>Error: </strong> <?= $error ?>
                </div>
            <?php } 
        unset($_SESSION['errors']);
        }
        if(isset($_SESSION['success_message'])) { ?>
        	<div class="alert alert-success">
  				<?= $_SESSION['success_message'] ?>
			</div>
        <?php unset($_SESSION['success_message']);
        } ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    	<h2>Register</h2>
                    </div>
                    <div class="panel-body">
                        <form action='process.php' method='post'>
                            <input type='hidden' name='action' value='register'>
                            <input type='text' name='first_name' placeholder='First Name'><br>
                            <input type='text' name='last_name' placeholder='Last Name'><br>
                            <input type='email' name='email' placeholder='Email'><br>
                            <input type='password' name='password' placeholder="Password">
                            <input type='password' name='confirm_password' placeholder="Confirm Password">
                            <input type='submit' value='register'>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h2>Login</h2></div>
                    <div class="panel-body"> 
                        <form action='process.php' method='post'>
                            <input type='hidden' name='action' value='login'>
                            <input type='email' name='email' placeholder="Email: ">
                            <input type='password' name='password' placeholder="Password: ">
                            <input type='submit' value='login'>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- End Row -->
    </div> <!-- End Container -->
</body>
</html>