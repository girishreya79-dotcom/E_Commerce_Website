<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!isset($_SESSION['user_id'])) {
    header("Location: productlogin.php");
    exit();
}
if (isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $sql = "DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error deleting: " . mysqli_error($conn);
    }

} else {
    header("Location: cart.php");
    exit();
}
?>