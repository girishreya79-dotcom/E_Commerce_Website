<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: product.php");
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "userdata"); 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['nm1']) && isset($_POST['nm2'])) {
    $t1 = mysqli_real_escape_string($conn, $_POST['nm1']);
    $t2 = mysqli_real_escape_string($conn, $_POST['nm2']);
    
    
    $sql = mysqli_query($conn, "SELECT * FROM useregister WHERE email='$t1' AND password='$t2'");
    
    if ($di = mysqli_fetch_array($sql)) {
      
        $_SESSION['user_id'] = $di['user_id']; 
        $_SESSION['email'] = $di['email']; 
        $_SESSION['logged_in'] = true; 

        header("Location: product.php");
        exit(); 
    } else {
        echo "<script>alert('Invalid Email or Password'); window.location.href='productlogin.html';</script>";
        exit();
    }
} 
?>