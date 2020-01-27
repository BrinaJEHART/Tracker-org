<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <link href="css/reset_pass.css" rel="stylesheet" type="text/css" media="screen">
    <title>Reset password</title>
</head>
<body>

<div id="navbar">
            <ul class="navbar">
                <?php 
                    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                    echo "<div class='dropdown'>
                            <li>
                                <img src='slike/user_icon.png' alt='Slika' width='50px' height='50px' class='user_icon'>
                                <div class='dropdown_content'>
                                    <a href='account.php'>Account</a>
                                    <a href='logout.php'>Logout</a>
                                </div>
                            </li>
                            </div>
                            <li><a href='index.php'>Home</a></li>
                            <li><a href='insert.php'>Add Values</a></li>
                            <li><a href='table.php'>Table</a></li>
                            ";
                            if(isset($_SESSION['admin']) && $_SESSION['admin']){
                                echo "<li><a href='users.php'>Users</a></li>";
                                echo "<li><a href='pending.php'>Pending</a></li>";
                            }
 
                        }
                    else{
                        echo "
                        <li><a href='register.php' class='reg'>Register</a></li>
                        <li><a href='login.php' class='log'>Login</a></li>
                        ";
                    }         
                    ?>

            </ul>
        </div>
                    
    <br>

    <h1 class="naslov">Reset email</h1>

    <div class="vsebina">
        <form action="reset_email.php" method="POST">
            <div>
            <p>New email:</p>
            <input class="inpt" type="email" name="new_email">
            </div>
            <input class="button" type="submit" name="submit" value="Change email">
        </form>
        <div>
            <?php

                if(isset($_GET['success'])){

                    if($_GET['success'] == 1){
                        echo "<p>You have successfully changed your email!</p>";
                    }
    
                    else if($_GET['success'] == 0){
                        echo "<p>Oops! Something went wrong!</p>";
                    }
                }
        
            ?>
        </div>
    </div>
</body>
</html>