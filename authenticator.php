<?php
    session_start();
    $mysqli = new mysqli("localhost","root","","socialmedia");

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    if(isset($_POST['register'])){
        $errors=[];
        foreach ($_POST as $key=>$val){
            if(empty($val)&&$key!="register"){
                array_push($errors,$key);
            }
        }
        if(empty($errors)){
            $sql = "INSERT INTO users (FirstName, LastName, UserName, Password, Email, Age) VALUES ('{$_POST["FirstName"]}','{$_POST["LastName"]}','{$_POST["UserName"]}','{$_POST["Password"]}','{$_POST["Email"]}',{$_POST["Age"]})";
            if($mysqli -> query($sql))
                header("Location:login.php");
        }else{
            header("Location:register.php?errors=".implode(";",$errors));
        }
        
    }

    if(isset($_POST['login'])){
        $sql="SELECT * FROM users WHERE UserName='{$_POST["UserName"]}' and Password='{$_POST["Password"]}'";
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
        if(isset($row["UserName"])){
            session_start();
            $_SESSION['UserName']=$row["UserName"];
            $_SESSION['id']=$row["id"];
            $_SESSION['logged']=true;
            header("Location:user/profile.php?UserName=".$_SESSION['UserName']."&id=".$_SESSION['id']);
        }else{
            header("Location:login.php");
        }
        $result -> free_result();
        }
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location:login.php");
        }
