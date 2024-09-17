<?php
include"../assets/classes/DB.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $file = new Files;
    $register = new ModelDB("users");
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];


    // if(empty($firstname) or empty($lastname))
    // {
    //     $_SESSION['Error'] = 'First and Last name is required!';
    //     header('location: ../frontpages/register.php');
    //     exit();
    // }
    // if (!$password)
    // {
    //     $_SESSION['Error'] = 'Password is required!';
    //     header('location: ../frontpages/register.php');
    //     exit();
    // }
    if ($_POST['password'] === $_POST['passwordconfirm'])
        {
            $password = password_hash( $_POST['password'], PASSWORD_DEFAULT);
        }
    else
        {
            $_SESSION['Error'] = 'Passwords do not match!';
            header('location: ../frontpages/register.php');
            exit();
        }
    // if(!$email)
    // {
    //     $_SESSION['Error'] = 'Email is required';
    //     header('location: ../frontpages/register.php');
    //     exit();
    // }
    $data = [
                'firstName' => $firstname,
                'lastName' => $lastname,
                'password' => $password,
                'email'=> $email,
                'picture' => ''
            ];
            if(!empty($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                $profile = $file->upload($_FILES['image']);
                $data['picture'] = $profile;
            }
            if (!file_exists($data['picture'])) $data['picture'] = '../assets/profiles/default.png';

    if($register->insertValues($data))
    {
        $user = $register->onlyFirst('email',$email);
        unset ($user['password']);
        $_SESSION['Success'] = 'Registered Successfully';
        setcookie('TODO_USER',json_encode($user),time() + 24 * 60 * 60,'/');
        header((string)'location: ../frontpages/homepage.php');
    }
}
