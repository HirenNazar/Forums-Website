<?php
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_name = $_POST['signupName'];
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupCpassword'];
    $existName = "SELECT * FROM `users` WHERE `user_name` = '$user_name'";
    $existMail = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
    $result1 = mysqli_query($conn,$existName);
    $result2 = mysqli_query($conn,$existMail);
    $numRows1 = mysqli_num_rows($result1);
    $numRows2 = mysqli_num_rows($result2);
    if ($numRows1 > 0)
    {
        $showError = "User name is already used.";
    }
    elseif ($numRows2 > 0) 
    {
        $showError = "An acount with this email already exits.";
    }
    elseif ($pass == $cpass){
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`sno`, `user_name`, `user_email`, `user_pass`, `timestamp`) VALUES (NULL, '$user_name', '$user_email', '$hash', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if($result){
            header("Location:/forums/index.php?signupsuccess=true");
            exit();
        }
    }
    else{
        $showError = "Passwords do not match.";
    }
    header("Location:/forums/index.php?signupsuccess=false&error=$showError");
    exit();
}
?>