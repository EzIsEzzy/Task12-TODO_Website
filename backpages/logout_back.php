<?php 


setcookie('TODO_USER', '', time() - 24 * 60 * 60,'/');


header('location: ../index.php');
