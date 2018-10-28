<?php

    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
?>
<h1>Login form</h1>
<form method="post" action="login.php">
    <input type="text" placeholder="username" name="username"/>
    <input type="text" placeholder="password" name="password">
    <select name="selector">
        <option value="1">
            Parent</option>
        <option value="2">Student</option>
        <option value="3">Teacher</option>
        <option value="4">Director</option>
    </select>
    <input type="submit"/>
</form>