<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location.href='productlogin.html';</script>";
    exit();
}
if (isset($_POST['id']) && !empty($_POST['id'])) {
    
    $uid = $_SESSION['user_id']; 
    $pid = mysqli_real_escape_string($conn, $_POST['id']);

        $sql = "INSERT INTO cart (user_id, product_id, quantity) 
            VALUES ('$uid', '$pid', 1) 
            ON DUPLICATE KEY UPDATE quantity = quantity + 1";

    if (mysqli_query($conn, $sql)) {
        
         if (isset($_POST['checkout_immediate']) && $_POST['checkout_immediate'] == "1") {
            header("Location: checkout.php");
        } else {
            header("Location: cart.php");
        }
        exit();

    } else {
        echo "<h4>Database Error:</h4>";
        echo mysqli_error($conn);
    }

} else {
    header("Location: product.php");
    exit();
}
?>