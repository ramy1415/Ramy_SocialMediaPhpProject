<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
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
      <form class="col" action="authenticator.php" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">User name</label>
          <input type="text" id="UserName" name="UserName" class="form-control" aria-describedby="emailHelp">
          <small id="emailHelp" class="form-text text-muted">We'll never share your details with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password"  name="Password" class="form-control" id="Password">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button name="login" type="submit" class="btn btn-primary">Login</button>
        <a href="register.php">register a new account</a>
      </form>
    </div>
  </div>
</body>
<script src="files/jquery/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="files/bootstrap/css/bootstrap.css">
<script src="files/bootstrap/js/bootstrap.min.js"></script>
</html>