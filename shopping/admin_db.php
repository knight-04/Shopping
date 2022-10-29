<?php
session_start();
include('server.php');

$errors = array();

if (isset($_POST['admin_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(empty($username)){
        array_push($errors, "Username is required");
    }
    if(empty($password)){
        array_push($errors, "Password is required");
    }
    if(count($errors) == 0 ){
        $password = md5($password);
        $query = "SELECT * FROM admin_user WHERE username = '$username' AND password = '$password' ";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1){
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Your are now logged in";
            header("location: admin.php"); 
        }
        else{   //input false alert text page login
            array_push($errors, "Wrong username/password combination");
            $_SESSION['error'] = "Wrong username or password tryagain";
            header("location: admin_login.php"); 
        } 
    }
}
?>
