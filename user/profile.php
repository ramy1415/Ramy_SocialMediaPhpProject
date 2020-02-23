<?php
    $mysqli = new mysqli("localhost","root","","socialmedia"); 
    if ($mysqli -> connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
      exit(); 
    }
    if(isset($_POST["publish"])){
      if(!empty($_POST["article"])){
        $sql = "INSERT INTO posts (body, user_id) VALUES ('{$_POST["article"]}',{$_POST["userid"]})";
        $mysqli -> query($sql);
      }
    }

    if(isset($_POST["delete"])){
      $sql = "DELETE FROM posts WHERE id={$_POST["postid"]}";
      $mysqli -> query($sql);
    }

    if(isset($_POST["ok"])){
      $sql = "UPDATE posts SET body='{$_POST["postbody"]}' WHERE id={$_POST["postid"]}";
      $mysqli -> query($sql);
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
    <a class="navbar-brand" href="profile.php?UserName=<?php echo($_GET["UserName"]."&id=".$_GET["id"]); ?>">Welcome <span id="myname"><?php echo($_GET["UserName"]); ?></span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
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
      <form class="form-inline my-2 my-lg-0">
        <a href="/SocialMediaPhpProject/login.php" class="btn btn-outline-success my-2 my-sm-0" type="submit">LogOut</a>
      </form>
    </div>
  </nav>
  <div class="container h-100">
    <div class="row align-items-center">
    <form class="col" action="" method="POST">
        <div class="form-group">
          <label for="article">New Post</label>
          <input type="text" id="article" name="article" class="form-control">
          <input type="text" hidden readonly value="<?php echo $_GET["id"] ?>" id="userid" name="userid" class="form-control">
        </div>
        <button name="publish" type="submit" class="btn btn-primary">Post</button>
    </form>  
    </div>
    <?php
      $sql="SELECT * FROM posts WHERE user_id='{$_GET["id"]}'";
      $result = $mysqli -> query($sql);
      while($row = $result -> fetch_assoc()){?>
        <div class="row" style="border: 1px black solid;padding:18px;margin-top:30px;border-radius:10%;background-color:lightgray;">
        <form action="" method="post">
          <?php if(isset($_POST["edit"])&&$_POST["postid"]==$row["id"]){ ?>
            <input type="text" name="postbody" value='<?php echo($row["body"]);?>' style="margin-bottom:19px"> 
            <br>
            <input hidden readonly type="text" value=<?php echo($row["id"]); ?> name="postid" id="postid">
            <button type="submit" name="ok">OK</button>
            <button type="submit" name="delete">Delete</button>
          <?php }else{?>
            <p> <?php echo($row["body"]); ?></p>
            <input hidden readonly type="text" value=<?php echo($row["id"]); ?> name="postid" id="postid">
            <button type="submit" name="edit">Edit</button>
            <button type="submit" name="delete">Delete</button>
          <?php }?>
        </form>
        </div>
      <?php }?>
  </div>
</body>
<script src="../files/jquery/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../files/bootstrap/css/bootstrap.css">
<script src="../files/bootstrap/js/bootstrap.min.js"></script>
</html>