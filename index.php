<?php

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/index.css" rel="stylesheet" type="text/css" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <title>Tracker</title>
</head>

<body>

    <div>

        <!-- Cover -->

        <div class="cover">

            <h1>Tracker</h1>

            <div class="arrowdown">
                <a href="#navbar">
                    <img src="slike/arrrow_down.svg" alt="arrow_down">
                </a>
            </div>
        </div>

        <!-- Navigation bar -->

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
        <br> <br>


        <!-- Content -->

    
        <div class="context">
            <?php
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                    echo "<h1 class='welcome_sign'>Welcome <span style='color:orange';> ". "&nbsp" . $_SESSION['username']. "&nbsp" ."</span> to Tracker!</h1>";
                    echo "<p class='welcome_paragraph'>To quickly guide you through my website, <br>
                    there is a navigation bar to lead you to all other features that this site has to offer. <br>
                    Its a straight forward website, so you shouldn't have trouble using it.<br>
                    If you have any questions you can always communicate with other users in the comment section. <br>
                    I will not be holding you on for any longer because nobody will even read this but yes, <br>
                    before I go, don't abuse the website and respect other users.<br>
                    Enjoy!<br>
                    
                    <br>
                    &nbsp Thank you for using our website, <br>
                    &nbsp -Tracker team
                    </p>";
                }

                else{
                    echo "<h1 class='welcome_sign'>Welcome to Tracker!</h1>  

                    <p class='welcome_paragraph'>This website is based on a banking idea, which allows a group of people to track, <br>
                        their purchases for their home, and the website will automaticly recommend whoever <br>
                        that has the least purchases has to go to the store next. All the data collected is viewable <br>
                        within these people. To prevent from abusing the system there are admins who confirm these <br>
                        purchases before it gets summed up with the total amount of money a person has spent. <br>
                        The users are also able to communicate with eachother in the comments section. <br>
                        So what are you waiting for? Register to access everything mentioned above and more!<br>
                        <br>
                        &nbsp Thank you for using our website, <br>
                        &nbsp -Tracker team
                    </p>";
                }
            
            ?>

        </div>

        <br> <br>

        <!-- Footer -->

        <div class="footer">

            <p class="footer_paragraph">Brina Jehart © 2019</p>

        </div>

</body>

</html>