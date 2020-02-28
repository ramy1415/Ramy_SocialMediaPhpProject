<?php


class post{
    public static function insert($body,$userid)
    {
        $mysqli=new mysqli("localhost","root","","socialmedia"); 
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit(); 
        };
        $allowed_image_extension = ["png","jpg","jpeg",""];
        $path_parts = pathinfo("{$_FILES["image"]["name"]}");
        if (!in_array($path_parts['extension'], $allowed_image_extension)) {
            $sql = "INSERT INTO posts (body, user_id) VALUES ('{$body}',{$userid})";
            $mysqli -> query($sql);
            return;
        }
        $upfile ='../files/images/'.$_FILES["image"]["name"];
        if (is_uploaded_file($_FILES['image']['tmp_name'])) { 
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upfile)) {
          echo 'Problem: Could not move file to destination directory'; exit; }
          $image=$_FILES["image"]["name"];
          $sql = "INSERT INTO posts (body, user_id) VALUES ('{$body}' '<br>' '<img style=max-width:500px;max-height:500px; src=../files/images/{$image}>',{$userid})";
          $mysqli -> query($sql);
          }else{
            $sql = "INSERT INTO posts (body, user_id) VALUES ('{$body}',{$userid})";
            $mysqli -> query($sql);
          }
        
    }
    public static function delete($postid)
    {
        $mysqli=new mysqli("localhost","root","","socialmedia"); 
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit(); 
        };
        $sql = "DELETE FROM posts WHERE id={$postid}";
        $sql2 = "DELETE FROM comments WHERE post_id={$postid}";
        $mysqli -> query($sql2);
        $mysqli -> query($sql);
    }
    public static function update($postid,$newbody)
    {
        $mysqli=new mysqli("localhost","root","","socialmedia"); 
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit(); 
        };
        $sql = "UPDATE posts SET body='{$newbody}' WHERE id={$postid}";
        $mysqli -> query($sql);
    }

}

?>