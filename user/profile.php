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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <style>
    html,
    body {
      height: 100%
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand"
      href="profile.php">Welcome <span
        id="myname"><?php echo($_SESSION["UserName"]); ?></span></a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="navbar-brand"
          href="timeline.php"> TimeLine</a></li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="/SocialMediaPhpProject/authenticator.php" method="post">
      <button class="btn btn-danger my-2 my-sm-0" name="logout" type="submit">Logout</button>
    </form>
    </div>
  </nav>
  <div class="container">
    <div class="row align-items-center">
      <form class="col" action="postsController.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="article">New Post</label>
          <input type="text" id="article" name="article" class="form-control">
          <input type="file" name="image">
          <input type="text"  hidden readonly value="<?php echo $_SESSION["id"] ?>" id="userid" name="userid"
            class="form-control">
        </div>
        <button name="publish" type="submit" class="btn btn-primary">Post</button>
      </form>
    </div>
    <?php
      $sql="SELECT p.id,p.body,p.user_id,u.UserName,u.pic FROM posts AS p, users AS u WHERE p.user_id=u.id and p.user_id={$_SESSION['id']}";
      $result = $mysqli -> query($sql);
      while($row = $result -> fetch_assoc()){$sql2="SELECT c.id,c.body,c.post_id,c.user_id,u.UserName,u.pic FROM comments c JOIN users u WHERE c.user_id=u.id and c.post_id={$row["id"]}"; $result2 = $mysqli -> query($sql2);?>
    <div class="row col-12">
      <div class="col-1"
        style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px 0 0 20px;background-color:lightblue;">
        <img src=<?php echo "../files/images/{$row["pic"]}" ?> style="width:50px;height:auto;border-radius:10px;"
          alt="">
        <p><?php echo "{$row["UserName"]} " ?></p>
      </div>
      <div class="col-11"
        style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:0 20px 20px 0;background-color:lightgray;">
        <?php if(isset($_GET["edit"])&&$_GET["postid"]==$row["id"]&&$_SESSION["id"]==$row["user_id"]){ ?>
        <form action="postsController.php" method="post">
          <input type="text" name="postbody" value='<?php echo($row["body"]);?>'
            style="margin-bottom:19px; width:800px;">
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
        <?php if(isset($_GET["editcomment"])&&$_GET["commentid"]==$row2["id"]&&$_SESSION["id"]==$row2["user_id"]){ ?>
        <form class="row col-12" action="postsController.php" method="post">
          <div class="col-1" style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px;background-color:lightblue;"><img src=<?php echo "../files/images/{$row2["pic"]}" ?> style="width:50px;height:auto;border-radius:10px;"
          alt=""><p><?php echo "{$row2["UserName"]} " ?></p></div>
          <div class="col-11" style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px;background-color:floralwhite;">
            <input type="text" name="commentbody" value='<?php echo($row2["body"]);?>'
              style="margin-bottom:19px; width:800px;">
            <br>
            <input hidden readonly type="text" value=<?php echo($row2["id"]); ?> name="commentid">
            <button type="submit" name="confirmEdit" class="btn btn-success">Confirm Edit</button>
          </div>
        </form>
        <?php }else{ ?>
        <form class="row col-12" action="postsController.php" method="post">
          <div class="col-1" style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:20px 0 0 20px;background-color:lightblue;"><img src=<?php echo "../files/images/{$row2["pic"]}" ?> style="width:50px;height:auto;border-radius:10px;"
          alt=""><p><?php echo "{$row2["UserName"]} " ?></p></div>
          <div class="col-11" style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:0 20px 20px 0;background-color:floralwhite;">
            <p> <?php echo($row2["body"]); ?></p>
            <input type="text" hidden readonly value="<?php echo $row2["id"] ?>" id="commentid" name="commentid" class="form-control">
            <?php if($row2["user_id"]==$_SESSION["id"]){?>
            <button type="submit" name="editComment" class="btn btn-success">Edit Comment</button>
            <button type="submit" name="deleteComment" class="btn btn-secondary">Delete Comment</button>
            <?php }?>
          </div>
          </form>
          <?php }?>
      <?php }?>
    </div>
    </div>
  <?php }?>
  </div>
</body>
<script src="../files/jquery/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../files/bootstrap/css/bootstrap.css">
<script src="../files/bootstrap/js/bootstrap.min.js"></script>
</html>