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
    <title>Welcome!</title>
</head>
<body>
    <?php
        if(isset($_SESSION['errors'])){
            foreach($_SESSION['errors'] as $error){ ?>
                <p class='red-text'> <?= $error ?> </p>
            <?php } 
        unset($_SESSION['errors']);
        }
        if(isset($_SESSION['success_message'])){ ?>
            <p class='green-text'> <?php $_SESSION['success_message'] ?> </p>
        <?php unset($_SESSION['success_message']);
        } ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Register</h2></div>
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
        </div>
    </div>
</body>
</html>