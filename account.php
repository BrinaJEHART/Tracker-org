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
    <link href="css/account.css" rel="stylesheet" type="text/css" media="screen">
    <title>Account</title>
</head>
<body>
    <!--Display username and pass, add the option to change pass-->

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
        <h1 class="naslov"> Account Settings </h1>
        <div class="vsebina">
        <div class="acc_settings">
        <?php
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                echo "<h1 class='acc_sign'>-<span style='color:orange';> ". $_SESSION['username']."</span></h1>";

            }
        ?>
        
        <a class="settings" href="reset_pass.php">Reset Password</a> <br>
        <a class="settings" href="reset_emailsite.php">Reset Email</a> <br>
        <a class="settings" href="my_requests.php">My requests</a>
        
    </div>

</body>
</html>