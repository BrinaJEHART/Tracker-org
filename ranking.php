<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    if(!isset($_SESSION['admin']) || $_SESSION['admin'] == false){
        header ("location: login.php");
    }

    $errors = [];
    $valueID = $mysqli->escape_string($_GET['id']);
    $valueAdmin = $mysqli->escape_string($_GET['admin']);

    if($valueID != $_SESSION['user_id']){

        if($valueID != 5){

            if($valueAdmin == 1){
                $mysqli->query("UPDATE users SET admin='0' WHERE id='$valueID'");
                header ("location: users.php");
            }
        
            else if($valueAdmin == 0){
                $mysqli->query("UPDATE users SET admin='1' WHERE id='$valueID'");
                header ("location: users.php");
            }
        }
    
        else{
            header("location: users.php?error=You cannot demote mijavmijav, because mijavmijav is GOD!!");
        }

    }

    else{
        header("location: users.php?error=You cannot demote yourself!");
    }

    

    
    
?>