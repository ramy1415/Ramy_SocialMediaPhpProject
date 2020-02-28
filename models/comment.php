<?php

class comment{
    public static function insert($body,$commentorid,$postid)
    {
        $mysqli=new mysqli("localhost","root","","socialmedia"); 
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit(); 
        };
        $allowed_image_extension = ["png","jpg","jpeg",""];
        $path_parts = pathinfo("{$_FILES["images"]["name"]}");
        if (!in_array($path_parts['extension'], $allowed_image_extension)) {
            $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('{$_POST["commentbody"]}',{$_SESSION["id"]},{$_POST["postid"]})";
            $mysqli -> query($sql);
            return;
        }
        if(!empty($_POST["commentbody"])){
            $upfile ='../files/images/'.$_FILES["images"]["name"];
            if (is_uploaded_file($_FILES['images']['tmp_name'])) { 
            if (!move_uploaded_file($_FILES['images']['tmp_name'], $upfile)) {
              echo 'Problem: Could not move file to destination directory'; exit; }
              $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('{$_POST["commentbody"]}' '<br>' '<img style=max-width:500px;max-height:500px; src=../files/images/{$_FILES["images"]["name"]} >'   ,{$_SESSION["id"]},{$_POST["postid"]})";
              $mysqli -> query($sql);
              }else{
                $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('{$_POST["commentbody"]}',{$_SESSION["id"]},{$_POST["postid"]})";
                $mysqli -> query($sql);
              }
            }
    }
    public static function delete($commentid)
    {
        $mysqli=new mysqli("localhost","root","","socialmedia"); 
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit(); 
        };
        $sql = "DELETE FROM comments WHERE id={$commentid}";
        $mysqli -> query($sql);
    }
    public static function update($commentid,$newbody)
    {
        $mysqli=new mysqli("localhost","root","","socialmedia"); 
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit(); 
        };
        $sql = "UPDATE comments SET body='{$newbody}' WHERE id={$commentid}";
        $mysqli -> query($sql);
    }

}

?>