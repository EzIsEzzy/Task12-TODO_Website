<?php 
if(isset($_COOKIE['TODO_USER']) && !empty($_COOKIE['TODO_USER'])) {
    $user = json_decode($_COOKIE['TODO_USER'] , true);
}
else
{
    unset($_COOKIE['TODO_USER']);
}
include "htmlhead.php";
?>
    <!-- start of header -->
    <header id="header">
        <a href="" class="logo">
            <h1>TODO App</h1>
        </a>
        <div class="tabs">
            <?php
            if (isset($_COOKIE['TODO_USER']) && !empty($_COOKIE['TODO_USER'])){
                echo '<a href="../backpages/logout_back.php">Logout</a>';
                echo '<a href="../frontpages/profile.php">
                <img src="'. $user['picture'] .'" id="profile" alt="">
                </a>';
            }
            if(!isset($_COOKIE['TODO_USER']) && empty($_COOKIE['TODO_USER'])){
                echo'<a href="./frontpages/login.php">Login</a>';
                echo '<a href="./frontpages/register.php">Register</a>';
            }
            ?>
        </div>
    </header>
    <!-- end of header -->