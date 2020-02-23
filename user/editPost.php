<?php
    $mysqli = new mysqli("localhost","root","","socialmedia"); 
    if ($mysqli -> connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
      exit(); 
    }

    if(isset($_POST[""])){
        if(!empty($_POST["article"])){
          $sql = "INSERT INTO posts (body, user_id) VALUES ('{$_POST["article"]}',{$_POST["userid"]})";
          $mysqli -> query($sql);
        }
      }

    
?>