<?php
include_once 'config.php';
@session_start();
if(isset($_POST['username'])){
    if(intval($_POST['selector']) == 4 and $_POST['username'] == $director['username'] and $_POST['password'] == $director['password']){
        echo 'DIRECTOR';
        $_SESSION['islogged'] = true;
        $_SESSION['selector'] = intval($_POST['selector']);

    }
    elseif(strlen($_POST['username']) > 3 and strlen($_POST['password']) > 3){
        $_SESSION['selector'] = intval($_POST['selector']);

        $password = trim($_POST['password']);
        $username = trim($_POST['username']);
        $type = $_POST['selector'];
    }else{
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: index.php');
    }
}
echo '<p>you`re logged.</p>';
echo '<p>Role '.$typeUser[$_SESSION['selector']].'</p>';

echo '<a href="logout.php">Logout</a>';