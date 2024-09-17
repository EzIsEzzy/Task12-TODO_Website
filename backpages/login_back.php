<?php
session_start();
require_once "../assets/classes/DB.php";

$Login = new ModelDB('users');
$email = $_POST['email'];
$password = $_POST['password'];

if(!($email && $password)) {
    $_SESSION['error'] = 'Email & Password are required !';
    header(header: 'Location: ' . $_SERVER['HTTP_REFERER']); // return back
    exit();
}
$user = $Login->onlyFirst('email',$email);
if($user){
    if(password_verify($password,$user['password'])){
        unset ($user['password']);
        setcookie('TODO_USER',json_encode($user),time() + 24 * 60 * 60,'/');
        $_SESSION['success'] = 'Login Successful!';
        header('location: ../frontpages/homepage.php');
        exit();
    }
    else{
        $_SESSION['error'] = 'Email is invalid !';
        header('Location: ' . $_SERVER['HTTP_REFERER']); // return back
        exit();
    }
}