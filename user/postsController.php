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
    if(isset($_POST["publish"])){
      if(!empty($_POST["article"])){
        $upfile ='../files/images/'.$_FILES["image"]["name"];
        if (is_uploaded_file($_FILES['image']['tmp_name'])) { 
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upfile)) {
          echo 'Problem: Could not move file to destination directory'; exit; }
          $sql = "INSERT INTO posts (body, user_id) VALUES ('posted by {$_SESSION["UserName"]} : ' '{$_POST["article"]}' '<br>' '<img src=../files/images/{$_FILES["image"]["name"]} >'   ,{$_POST["userid"]})";
          $mysqli -> query($sql);
          }else{
            $sql = "INSERT INTO posts (body, user_id) VALUES ('posted by {$_SESSION["UserName"]} : ' '{$_POST["article"]}',{$_SESSION["id"]})";
            $mysqli -> query($sql);
          }
        }
        if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
          header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
          exit();
          }
          header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
          exit();
      }
    if(isset($_POST["delete"])){
      $sql = "DELETE FROM posts WHERE id={$_POST["postid"]}";
      $sql2 = "DELETE FROM comments WHERE post_id={$_POST["postid"]}";
      $mysqli -> query($sql2);
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
        }
        header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
    }
    if(isset($_POST["deleteComment"])){
      $sql = "DELETE FROM comments WHERE id={$_POST["commentid"]}";
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
        }
        header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
    }
    if(isset($_POST["edit"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
            header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&edit=true"."&postid=".$_POST["postid"]);
            exit();
      }
      header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&edit=true"."&postid=".$_POST["postid"]);
            exit();
    }
    if(isset($_POST["editComment"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
            header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&edit=true"."&commentid=".$_POST["commentid"]);
            exit();
      }
      header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&edit=true"."&commentid=".$_POST["commentid"]);
            exit();
    }
    if(isset($_POST["ok"])){
      $sql = "UPDATE posts SET body='{$_POST["postbody"]}' WHERE id={$_POST["postid"]}";
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
        }
        header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
    }
    if(isset($_POST["confirmEdit"])){
      $sql = "UPDATE comments SET body='{$_POST["commentbody"]}' WHERE id={$_POST["commentid"]}";
      $mysqli -> query($sql);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
        }
        header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        exit();
    }
    if(isset($_POST["comment"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&comment=true"."&postid=".$_POST["postid"]);
        exit();
        }
        header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']."&comment=true"."&postid=".$_POST["postid"]);
        exit();
    }
    if(isset($_POST["AddComment"])){
      if(!empty($_POST["commentbody"])){
        $upfile ='../files/images/'.$_FILES["images"]["name"];
        if (is_uploaded_file($_FILES['images']['tmp_name'])) { 
        if (!move_uploaded_file($_FILES['images']['tmp_name'], $upfile)) {
          echo 'Problem: Could not move file to destination directory'; exit; }
          $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('comment by {$_SESSION["UserName"]} : ' '{$_POST["commentbody"]}' '<br>' '<img src=../files/images/{$_FILES["images"]["name"]} >'   ,{$_SESSION["id"]},{$_POST["postid"]})";
          $mysqli -> query($sql);
          }else{
            $sql = "INSERT INTO comments (body, user_id,post_id) VALUES ('comment by {$_SESSION["UserName"]} : ' '{$_POST["commentbody"]}',{$_SESSION["id"]},{$_POST["postid"]})";
            $mysqli -> query($sql);
          }
        }
        if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
          header("Location:timeline.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
          exit();
          }
          header("Location:profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
          exit();
      }
?>