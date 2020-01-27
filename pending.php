<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    if(!isset($_SESSION['admin']) || $_SESSION['admin'] == false){
        header ("location: login.php");
    }

    $_SESSION['dissaproveMsg'] = $dissaproveMsg = "Your request was dissaproved by an administrator.";

    $pending = $mysqli->query("SELECT r.id, r.vsota, r.datum, r.pot, r.opis, u.username as un FROM racuni r INNER JOIN users u ON u.id=r.user_id WHERE preverjeno = '0'");

    if(isset($_POST['approve'])){
        $rID = $mysqli->escape_string($_POST['racunID']);
            $approve = $mysqli->query("UPDATE racuni SET preverjeno=1 WHERE id = $rID");
            header ("location: pending.php");
        }
    else if(isset($_POST['dissaprove'])){
        $rID = $mysqli->escape_string($_POST['racunID']);
            $dissaprove = $mysqli->query("DELETE FROM racuni WHERE id='$rID'");
            echo $dissaproveMsg;
            header ("location: pending.php");
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <link href="css/pending.css" rel="stylesheet" type="text/css" media="screen">
    <title>Pending requests</title>
</head>
<body>
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

    <h1>Pending Requests</h1> <br>
    
    <div class="vsebina">
        
    <?php
        while($row = $pending->fetch_assoc()){
            echo "<div class='vsb'> <hr>";
            echo "User: <span style='color:orange; font-weight:bold';>" . $row ['un'] . "</span>";
            echo "<br>";
            echo "Description: " . $row ['opis'];
            echo "<br>";
            echo "Value: <span style='font-weight:bold';>" . $row ['vsota'] . "</span>";
            echo "<br>";
            echo "Date: " . $row ['datum'];
            echo "<br>";
            echo "<img class='picture' width='700px' height='500px' src='images/". $row['pot'] ."' alt='Receipt'>";
            echo "<br>";
            ?>
            <form action="pending.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="racunID" value="<?php echo $row['id'] ?>">
            <button class="button" type="submit" name="approve">Approve</button> <br>
            <button class="button" type="submit" name="dissaprove">Dissaprove</button>
            
            </form>
            <?php
            if(isset($_POST['dissaprove']) && $_POST['dissaprove']){
                echo $dissaproveMsg;
            }
        }
    ?>
    </div>


</body>
</html>