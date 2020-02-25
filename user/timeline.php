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
    if(isset($_POST["delete"])){
      $sql = "DELETE FROM posts WHERE id={$_POST["postid"]}";
      $mysqli -> query($sql);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TimeLine Page</title>
  <style>
    html,
    body {
      height: 100%
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="profile.php?UserName=<?php echo($_SESSION['UserName']."&id=".$_SESSION['id']); ?>">Welcome <span id="myname"><?php echo($_GET["UserName"]); ?></span></a>
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
      <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="navbar-brand" href="timeline.php?UserName=<?php echo($_SESSION['UserName']."&id=".$_SESSION['id']); ?>"> TimeLine</a></li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Events Options
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/event/list">list events</a>
            <a class="dropdown-item" href="/admin/event/add">add events</a>
            <a class="dropdown-item" href="/admin/event/delete">delete events</a>
            <a class="dropdown-item" href="/admin/event/edit">edit events</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Speaker Options
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/speaker/list">list speakers</a>
            <a class="dropdown-item" href="/admin/speaker/add">add speakers</a>
            <a class="dropdown-item" href="/admin/speaker/delete">delete speakers</a>
            <a class="dropdown-item" href="/admin/speaker/edit">edit speakers</a>
            <div class="dropdown-divider"></div>
          </div>
        </li> -->
      </ul>
      <form class="form-inline my-2 my-lg-0" action="/SocialMediaPhpProject/authenticator.php" method="post">
        <button class="btn btn-outline-danger my-2 my-sm-0" name="logout" type="submit">Logout</button>
      </form>
    </div>
  </nav>
  <div class="container h-100">
    <div class="row align-items-center">
    <form class="col" action="postsController.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="article">New Post</label>
          <input type="text" id="article" name="article" class="form-control">
          <input type="file" name="image">
          <input type="text" hidden readonly value="<?php echo $_GET["id"] ?>" id="userid" name="userid" class="form-control">
        </div>
        <button name="publish" type="submit" class="btn btn-primary">Post</button>
    </form>  
    </div>
    <?php
      $sql="SELECT * FROM posts";
      $result = $mysqli -> query($sql);
      while($row = $result -> fetch_assoc()){$sql2="SELECT * FROM comments WHERE post_id={$row["id"]}"; $result2 = $mysqli -> query($sql2);?>
        <div class="row" style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px;background-color:lightgray;">
        <?php if(isset($_GET["edit"])&&$_GET["postid"]==$row["id"]&&$_SESSION["id"]==$row["user_id"]){ ?>
            <form action="postsController.php" method="post">
            <input type="text" name="postbody" value='<?php echo($row["body"]);?>' style="margin-bottom:19px; width:800px;"> 
            <br>
            <input hidden readonly type="text" value=<?php echo($row["id"]); ?> name="postid" id="postid">
            <button type="submit" name="ok" class="btn btn-success">OK</button>
            <button type="submit" name="delete" class="btn btn-secondary">Delete</button>
            <button type="submit" name="comment" class="btn btn-success">Comment</button>
            </form>
        <?php }else if(isset($_GET["comment"])&&$_GET["postid"]==$row["id"]){ ?>
        <form action="postsController.php" method="post" enctype="multipart/form-data">
        <p> <?php echo($row["body"]); ?></p>
        <br>
        <input hidden readonly type="text" value=<?php echo($row["id"]); ?> name="postid" id="postid">
        <input type="text" name="commentbody" style="margin-bottom:19px; width:800px;"> 
        <input type="file" name="images">
        <button type="submit" name="AddComment" class="btn btn-success">AddComment</button>
        </form>
        <?php }else{?>
          <form action="postsController.php" method="post">
          <p> <?php echo($row["body"]); ?></p>
          <input hidden readonly type="text" value=<?php echo($row["id"]); ?> name="postid" id="postid">
          <?php if($row["user_id"]==$_SESSION['id']){?>
              <button type="submit" name="edit" class="btn btn-success">Edit</button>
              <button type="submit" name="delete" class="btn btn-secondary">Delete</button>
        <?php }?>
              <button type="submit" name="comment" class="btn btn-success">Comment</button>
          </form>
          <?php }?>
          <?php while($row2 = $result2 -> fetch_assoc()){?>
            <?php if(isset($_GET["edit"])&&$_GET["commentid"]==$row2["id"]&&$_SESSION["id"]==$row2["user_id"]){ ?>
            <form action="postsController.php" method="post">
              <div  style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px;background-color:lightyellow;">
                <input type="text" name="commentbody" value='<?php echo($row2["body"]);?>' style="margin-bottom:19px; width:800px;"> 
                <br>
                <input hidden readonly type="text" value=<?php echo($row2["id"]); ?> name="commentid">
                <button type="submit" name="confirmEdit" class="btn btn-success">Confirm Edit</button>
              </div>
            </form>
            <?php }else{ ?>
            <form class="col-12" action="postsController.php" method="post">
              <div  style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px;background-color:lightyellow;">
              <p> <?php echo($row2["body"]); ?></p>
              <input type="text" hidden readonly value="<?php echo $row2["id"] ?>" id="commentid" name="commentid" class="form-control">
              <?php if($row2["user_id"]==$_SESSION["id"]){?>
                <button type="submit" name="editComment" class="btn btn-success">Edit Comment</button>
                <button type="submit" name="deleteComment" class="btn btn-secondary">Delete Comment</button>
              <?php }?>
              <?php }?>
            </form>
            </div>
          <?php }?>
        </div>
      <?php }?>
  </div>
</body>
<script src="../files/jquery/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../files/bootstrap/css/bootstrap.css">
<script src="../files/bootstrap/js/bootstrap.min.js"></script>
</html>