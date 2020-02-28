<?php
    session_start();
    if(!isset($_SESSION['logged'])){
      header("Location:/Ramy_SocialMediaPhpProject/Login.php");
    }
    require('../models/post.php');
    require('../models/comment.php');
    if(isset($_POST["publish"])){
      if(!empty($_POST["article"])){
        post::insert($_POST["article"],$_SESSION["id"]);
        if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
          header("Location:timeline.php");
          exit();
          }
          header("Location:profile.php");
          exit();
      }
    }
    if(isset($_POST["delete"])){
      post::delete($_POST["postid"]);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["deleteComment"])){
      comment::delete($_POST["commentid"]);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["edit"])){
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
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
      post::update($_POST["postid"],$_POST["postbody"]);
      if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
        header("Location:timeline.php");
        exit();
        }
        header("Location:profile.php");
        exit();
    }
    if(isset($_POST["confirmEdit"])){
      comment::update($_POST["commentid"],$_POST["commentbody"]);
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
        comment::insert($_POST["commentbody"],$_SESSION["id"],$_POST["postid"]);
        if(strpos($_SERVER['HTTP_REFERER'], 'timeline')){
          header("Location:timeline.php");
          exit();
          }
          header("Location:profile.php");
          exit();
      }
?>