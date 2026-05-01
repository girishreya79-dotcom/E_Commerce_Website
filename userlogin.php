<?php
session_start();

$t1 = $_POST['nm1']; 
$t2 = $_POST['nm2']; 

$conn = mysqli_connect("localhost", "root", "", "userdata");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = mysqli_real_escape_string($conn, $t1);
$password = mysqli_real_escape_string($conn, $t2);

$sql = mysqli_query($conn, "SELECT * FROM useregister WHERE email='$email' AND password='$password'");

if($di = mysqli_fetch_array($sql)) {
    $_SESSION["user_id"] = $di['user_id']; 
    $_SESSION["full_name"] = $di['fullname']; 
    
    header("Location: userpanel.php");
    exit(); 
} else {
    header("Location: userlogin.php?error=1");
    exit();
}
?>