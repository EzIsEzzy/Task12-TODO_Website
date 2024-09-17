<?php
if(isset($_COOKIE['TODO_USER']) && !empty($_COOKIE['TODO_USER'])) {
    $user = json_decode($_COOKIE['TODO_USER'] , true);
}
else{
    header('location: ../index.php');
}
include"../assets/classes/DB.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $note = new ModelDB("notes");
    $title = $_POST['title'];
    $description = $_POST['desc'];
    $note_date = $_POST['date'];
    $done = $_POST['done'];
    $user_id = $user['id'];

    $data = [
        'title' => $title,
        'description'=> $description,
        'note_date' => $note_date,
        'done' => $done,
        'user_id' => $user_id
    ];
    print_r($note->insertValues($data));
    header('location: ../frontpages/homepage.php');
}
