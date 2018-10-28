<?php
if(!file_exists('database/database.php')){
    header("Location: setup/index.php");
}
session_start();
include_once 'config.php';

if(@$_SESSION['islogged'] !== true){
    include_once 'templates/login_form.php';
}elseif(@$_SESSION['islogged'] === true){
    include_once 'login.php';
}else{
    echo 'error';
}