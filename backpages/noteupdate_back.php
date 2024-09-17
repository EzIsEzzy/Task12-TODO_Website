<?php
include"../assets/classes/DB.php";
if(isset($_COOKIE['TODO_USER']) && !empty($_COOKIE['TODO_USER'])) {
    $user = json_decode($_COOKIE['TODO_USER'] , true);
}
else{
    header('location: ../index.php');
}
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $id = $_GET['id'];
    $note = new ModelDB("notes");
    $title = $_POST['title'];
    $description = $_POST['desc'];
    $note_date = $_POST['date'];
    $done = $_POST['done'];

    $data = [
        'title' => $title,
        'description'=> $description,
        'note_date' => $note_date,
        'done' => $done,
    ];
    print_r($note->updateValues($data,'id',$id));
    header('location: ../frontpages/homepage.php');
}
