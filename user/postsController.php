<?php
    session_start();
    if(!isset($_SESSION['logged'])){
      header("Location:/SocialMediaPhpProject/Login.php");
    }
    $mysqli = new mysqli("localhost","root","","socialmedia"); 
    if ($mysqli -> connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
      exit(); 
    }
    require('../models/post.php');
    if(isset($_POST["publish"])){
      if(!empty($_POST["article"])){
        $post_=new post();
        $post_->body=$_POST["article"];
        $post_->user_id=$_SESSION["id"];
        $upfile ='../files/images/'.$_FILES["image"]["name"];
        if (is_uploaded_file($_FILES['image']['tmp_name'])) { 
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upfile)) {
          echo 'Problem: Could not move file to destination directory'; exit; }
          $post_->image=$_FILES["image"]["name"];
          $post_->insertwithimage($post_);
          }else{
            $post_->insert($post_);
          }
        }
        if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
          header("Location:timeline.php");
          exit();
          }
          header("Location:profile.php");
          exit();
      }
    if(isset($_POST["delete"])){
      $post_=new post();
      $post_->delete($_POST["postid"]);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["deleteComment"])){
      // $post_=new post();
      // $post_->delete($_POST["commentid"]);
      $sql = "DELETE FROM comments WHERE id={$_POST["commentid"]}";
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["edit"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
            // header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&edit=true"."&postid=".$_POST["postid"]);
            header("Location:timeline.php?"."edit=true"."&postid=".$_POST["postid"]);
            exit();
      }
      header("Location:profile.php?"."edit=true"."&postid=".$_POST["postid"]);
            exit();
    }
    if(isset($_POST["editComment"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
            header("Location:timeline.php?"."editcomment=true"."&commentid=".$_POST["commentid"]);
            exit();
      }
      header("Location:profile.php?"."editcomment=true"."&commentid=".$_POST["commentid"]);
            exit();
    }
    if(isset($_POST["ok"])){
      $sql = "UPDATE posts SET body='{$_POST["postbody"]}' WHERE id={$_POST["postid"]}";
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["confirmEdit"])){
      $sql = "UPDATE comments SET body='{$_POST["commentbody"]}' WHERE id={$_POST["commentid"]}";
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["comment"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php"."?comment=true"."&postid=".$_POST["postid"]);
        exit();
        }
        header("Location:profile.php"."?comment=true"."&postid=".$_POST["postid"]);
        exit();
    }
    if(isset($_POST["AddComment"])){
      if(!empty($_POST["commentbody"])){
        $upfile ='../files/images/'.$_FILES["images"]["name"];
        if (is_uploaded_file($_FILES['images']['tmp_name'])) { 
        if (!move_uploaded_file($_FILES['images']['tmp_name'], $upfile)) {
          echo 'Problem: Could not move file to destination directory'; exit; }
          $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('{$_POST["commentbody"]}' '<br>' '<img src=../files/images/{$_FILES["images"]["name"]} >'   ,{$_SESSION["id"]},{$_POST["postid"]})";
          $mysqli -> query($sql);
          }else{
            $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('{$_POST["commentbody"]}',{$_SESSION["id"]},{$_POST["postid"]})";
            $mysqli -> query($sql);
          }
        }
        if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
          header("Location:timeline.php");
          exit();
          }
          header("Location:profile.php");
          exit();
      }
?>