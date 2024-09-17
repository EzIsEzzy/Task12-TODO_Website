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
    $file = new Files;
    $updateProfile = new ModelDB("users");
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    if ($_POST['password'] === $_POST['passwordconfirm'])
    {
        $password =password_hash( $_POST['password'], PASSWORD_DEFAULT);
    }
    else
    {
        $_SESSION['Error'] = 'Passwords do not match!';
        header('location: ../frontpages/profile.php');
        exit();
    }
    $data = [
                'firstName' => $firstname,
                'lastName' => $lastname,
                'password' => $password,
                'email'=> $email,
                'picture' => ''
            ];
    if(file_exists($user['picture']))
    {
        if ($user['picture'] != '../assets/profiles/default.png')
            {
                $file->remove($user['picture']);
                $data['picture'] = '../assets/profiles/default.png';
            }
        if(!empty($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $profile = $file->upload($_FILES['image']);
            $data['picture'] = $profile;
        }
    }  
    if($updateProfile->updateValues($data, 'id', $user['id']))
    {
        unset ($data['password']);
        $updated_user = $updateProfile->onlyFirst('email',$email);
        if($updated_user)
        {
            setcookie('TODO_USER', '', time() - 24 * 60 * 60,'/');
            $_SESSION['Success'] = 'Updated Successfully';
            unset($updated_user['password']);
            setcookie('TODO_USER',json_encode($updated_user),time() + 24 * 60 * 60,'/');
            header('location: ../frontpages/homepage.php');
        }
    }
}
