<?php
    
    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    $errors = [];
    if(isset($_GET['error'])){
        $errors[] = $_GET['error'];
    }
    $result = $mysqli->query("SELECT id, username, email, admin FROM users ORDER BY username ASC");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <link href="css/users.css" rel="stylesheet" type="text/css" media="screen">
    <title>Users</title>
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

        <div class="title">
            
            <h1> Users </h1>

        </div>

        <div class="results">
            <table>
                <th>Users:</th>
                <th>E-mail:</th>
                <th>Admin:</th>
                <th>Declare rank:</th>
                <?php while($row = $result->fetch_assoc()) {?>
                    <tr>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['admin'] ?></td>
                        <td>
                            <?php

                                if($row['admin'] == 1){
                                    echo "<a class='rank' href='ranking.php?id=". $row['id']. "&admin=1'>Demote</a>";
                                }

                                else if($row['admin'] == 0){
                                    echo "<a class='rank' href='ranking.php?id=". $row['id']. "&admin=0'>Promote</a>";
                                }

                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <div class="error">
                <?php
                        if(!empty($errors)){
                            foreach($errors as $error){
                                echo "<p class='error' style='color: red;text-transform:uppercase;'>" . $error . "</p>";

                            }
                    }
                    ?>   

            </div>

        </div>

    <!-- Footer -->

    <div class="footer">

        <p class="footer_paragraph">Brina Jehart © 2019</p>

    </div>
    
</body>
</html>