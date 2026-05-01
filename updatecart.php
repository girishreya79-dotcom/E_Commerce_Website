<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!isset($_SESSION['user_id'])) {
    header("Location: productlogin.php");
    exit();
}
if (isset($_POST['product_id']) && isset($_POST['qty'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $new_qty = intval($_POST['qty']);

    if ($new_qty < 1) { $new_qty = 1; }
    $sql = "UPDATE cart SET quantity = '$new_qty' 
            WHERE user_id = '$user_id' AND product_id = '$product_id'";

    mysqli_query($conn, $sql);
}

header("Location: cart.php");
exit();
?>