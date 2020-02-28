<?php
if(isset($_GET["errors"]))
  $errors=explode(";",$_GET["errors"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <style>
    html,
    body {
      height: 100%
    }
  </style>
</head>
<body>
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <form class="col" action="authenticator.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="FirstName">First Name</label>
          <input type="text" id="FirstName" name="FirstName" class="form-control">
          <small class="form-text text-muted">Only letters and white space allowed</small>
          <?php if(isset($_GET["errors"])) if(in_array("FirstName", $errors)) { ?>
            <small style="color: red">invalid FirstName</small>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="LastName">Last Name</label>
          <input type="text" id="LastName" name="LastName" class="form-control">
          <small class="form-text text-muted">Only letters and white space allowed</small>
          <?php if(isset($_GET["errors"])) if(in_array("LastName", $errors)) { ?>
            <small style="color: red">invalid LastName</small>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="UserName">User Name</label>
          <input type="text" id="UserName" name="UserName" class="form-control">
          <small class="form-text text-muted">Only letters and white space allowed</small>
          <?php if(isset($_GET["errors"])) if(in_array("UserName", $errors)) { ?>
            <small style="color: red">invalid UserName</small>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="Password">Password</label>
          <input type="password"  name="Password" class="form-control" id="Password">
          <?php if(isset($_GET["errors"])) if(in_array("Password", $errors)) { ?>
            <small style="color: red">invalid Password</small>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="Email">Email</label>
          <input type="text"  name="Email" class="form-control" id="Email">
          <?php if(isset($_GET["errors"])) if(in_array("Email", $errors)) { ?>
            <small style="color: red">invalid Email</small>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="Age">Age</label>
          <input type="number" max="60" min="18" name="Age" class="form-control" id="Age">
          <?php if(isset($_GET["errors"])) if(in_array("Age", $errors)) { ?>
            <small style="color: red">invalid Age</small>
          <?php } ?>
        <div class="form-group" style="margin-top:15px;">
          <label for="image">Profile Pic</label>
          <br>
          <input type="file" name="image" id="image">
          <small class="form-text text-muted">Will set to an anonymous image if not chosen</small>
          <?php if(isset($_GET["errors"])) if(in_array("image", $errors)) { ?>
            <small style="color: red">invalid image</small>
          <?php } ?>
        </div>
        <button name="register" type="submit" class="btn btn-primary">Register</button>
        <a href="login.php">Already have an account</a>
      </form>
    </div>
  </div>
</body>
<script src="files/jquery/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="files/bootstrap/css/bootstrap.css">
<script src="files/bootstrap/js/bootstrap.min.js"></script>
</html>