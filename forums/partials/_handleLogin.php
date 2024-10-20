<?php

$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];
    $sql = "SELECT * FROM `users` WHERE `user_email` = '$email'";
    $result = mysqli_query($conn,$sql);
    $numrow = mysqli_num_rows($result);
    if($numrow == 1)
    {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass,$row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['userid'] = $row['sno'];
            header("Location:/forums/index.php?loginSuccess=true");
            exit();
        }
    }
    header("Location:/forums/index.php?loginSuccess=false");
    exit();
}

?>