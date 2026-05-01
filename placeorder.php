<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopping");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: userlogin.php");
        exit();
    }

    $uid = $_SESSION['user_id'];
    $pid   = mysqli_real_escape_string($conn, $_POST['product_id']);
    $name  = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['contact']);
    $addr  = mysqli_real_escape_string($conn, $_POST['address']);
    $pay   = mysqli_real_escape_string($conn, $_POST['payment']);
    
    $qty   = (int)$_POST['quantity'];
    $total = (float)$_POST['total_amount'];
    $sql = "INSERT INTO orderproduct 
            (user_id, product_id, customer_name, contact_number, address, payment_method, quantity, total_price, status, order_date) 
            VALUES 
            ('$uid', '$pid', '$name', '$phone', '$addr', '$pay', '$qty', '$total', 'Pending', NOW())";

    if (mysqli_query($conn, $sql)) {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$uid' AND product_id = '$pid'");

        echo "<script>
                alert('Order placed successfully! Total Amount: $$total');
                window.location.href='product.php'; 
              </script>";
    } else {
       
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>