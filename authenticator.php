<?php
    session_start();
    if(!isset($_SESSION['logged'])){
    header("Location:/Ramy_SocialMediaPhpProject/Login.php");
    }
    $mysqli = new mysqli("localhost","root","","socialmedia");

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    $allowed_image_extension = ["png","jpg","jpeg",""];
    $path_parts = pathinfo("{$_FILES["image"]["name"]}");
    
    if(isset($_POST['register'])){
        $errors=[];
        foreach ($_POST as $key=>$val){
            if(empty($val)&&$key!="register"){
                array_push($errors,$key);
            }
        }
        if (!in_array($path_parts['extension'], $allowed_image_extension)) {
            array_push($errors,"image");
        }
        if (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
            array_push($errors,"Email");
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["UserName"])) {
            array_push($errors,"UserName");
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["FirstName"])) {
            array_push($errors,"FirstName");
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["LastName"])) {
            array_push($errors,"LastName");
        }
        if(empty($errors)){
            $_FILES["image"]["name"]="avatar"."-{$_POST["UserName"]}".".{$path_parts['extension']}";
            $upfile ='files/images/'.$_FILES["image"]["name"];
            if (is_uploaded_file($_FILES['image']['tmp_name'])) { 
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upfile)) {
            echo 'Problem: Could not move file to destination directory'; exit; }else{
                $sql = "INSERT INTO users (FirstName, LastName, UserName, Password, Email, Age,pic) VALUES ('{$_POST["FirstName"]}','{$_POST["LastName"]}','{$_POST["UserName"]}','{$_POST["Password"]}','{$_POST["Email"]}',{$_POST["Age"]},'{$_FILES["image"]["name"]}')";
                $mysqli -> query($sql);
                header("Location:login.php");
            }
            }else{
                $sql = "INSERT INTO users (FirstName, LastName, UserName, Password, Email, Age,pic) VALUES ('{$_POST["FirstName"]}','{$_POST["LastName"]}','{$_POST["UserName"]}','{$_POST["Password"]}','{$_POST["Email"]}',{$_POST["Age"]},'anon.png')";
                $mysqli -> query($sql);
                header("Location:login.php");
            }
        }else{
            header("Location:register.php?errors=".implode(";",$errors));
        }
    }
    if(isset($_POST['login'])){
        $sql="SELECT * FROM users WHERE UserName='{$_POST["UserName"]}' and Password='{$_POST["Password"]}'";
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
        if(isset($row["UserName"])){
            $_SESSION['UserName']=$row["UserName"];
            $_SESSION['pic']=$row["pic"];
            $_SESSION['id']=$row["id"];
            $_SESSION['logged']=true;
            header("Location:user/profile.php");
        }else{
            header("Location:login.php");
        }
        $result -> free_result();
        }
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location:login.php");
        }