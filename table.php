<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    $result = $mysqli->query("SELECT u.id, u.username, SUM(r.vsota) as skupna_vsota FROM racuni r INNER JOIN users u ON r.user_id = u.id WHERE (r.preverjeno = 1) GROUP BY r.user_id ORDER BY skupna_vsota DESC");
    $prediction = $mysqli->query("SELECT u.id, u.username, SUM(r.vsota) as skupna_vsota FROM racuni r INNER JOIN users u ON r.user_id = u.id WHERE (r.preverjeno = 1) GROUP BY r.user_id ORDER BY skupna_vsota ASC LIMIT 1");


    if(isset($_POST['submit'])){
        $komentar = $_POST['comment'];
        $comment = $mysqli->query("INSERT INTO komentarji (komentar, date_time, user_id) VALUES('$komentar', NOW(), '{$_SESSION['user_id']}')");
        header("location: table.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet" type="text/css" media="screen">
    <title>Table</title>
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
<br>
<div class="vsebina">
    <div class="results">
    <p class="naslov">Table</p>
    <table>
    <tr>
        <th>User</th>
        <th>Total value in €</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) {?>
    <tr>
        <td>
            <?php
                if($row['id'] == $_SESSION['user_id']) {
                    echo "<span class='currentUser'><b>" . $row['username'] . "</b></span>";
                } else {
                    echo $row['username'];
                }
            ?>
        </td>
        <td><?php echo $row['skupna_vsota'] ?></td>
    </tr>
    <?php } ?>
    </table>
    <div class="self_prediction">

    <?php
        $predict = $prediction->fetch_assoc();
        echo "<p><span style='color:orangered;'><b>" . $predict['username'] . "</b></span> mrš v trgovino!";
    ?>

    </div>
    </div>

    <p class="naslov">Comment section</p>
    <div class="comment_section">
        <form action="table.php" method="POST" enctype="multipart/form-data">
            <div>
                <textarea class="txtarea" name="comment" placeholder="e.g. Mijav" required></textarea>
            </div>
            <div>
                <button type="submit" name="submit">Send</button>
            </div>
            <div>
                <?php
                    $displayComm = $mysqli->query("SELECT k.id as kid, k.komentar, k.date_time, k.user_id as kuid, u.username FROM komentarji k INNER JOIN users u ON u.id=k.user_id ORDER BY date_time DESC");
                    while($row = $displayComm->fetch_assoc()){
                        echo "<div class='comments'>";
                        echo "<p> <span style='color:orange;font-size:1.1em'><b>" . $row['username'] . "</b></span>" . "&nbsp" . "<span style='color:black;font-size:0.8em;'>" . $row['date_time'] ."</span></p>";
                        echo $row['komentar'];
                        echo "<br>";
                        ?>
                        <br>
                        <div>
                            <?php
                            if(isset($_SESSION['user_id']) && $row['kuid'] == $_SESSION['user_id'] || isset($_SESSION['admin']) && $_SESSION['admin']){
                            echo "<a class='izbrkom' href='delete.php?id=" . $row['kid'] . "'>Izbriši komentar</a>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    }
                ?>
            </div>
            
        </form>
        <div>
        <?php
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo "<p class='error' style='color: white;'>" . $error . "</p>";

                        }
                   }
                ?>   
        </div>
    </div>
    
</div>
<!-- Footer -->

<div class="footer">

<p class="footer_paragraph">Brina Jehart © 2019</p>

</div>
</body>

</html>