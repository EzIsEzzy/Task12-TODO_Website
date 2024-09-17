<?php
if(isset($_COOKIE['TODO_USER']) && !empty($_COOKIE['TODO_USER'])) {
    $user = json_decode($_COOKIE['TODO_USER'] , true);
}
else{
    header('location: ../index.php');
}
include"../assets/classes/DB.php";
session_start();
$id = $_GET['id'];
$noteDelete = new ModelDB('notes');
if($noteDelete->deleteValues($id))
{
    header('location:../frontpages/homepage.php');
    $_SESSION ['success'] = 'Deleted Successfully!';
}