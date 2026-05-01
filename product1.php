<html>
<head>
<title>Product Display</title>
</head>
<body>
<?php
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = mysqli_query($conn, "SELECT * FROM addproduct ORDER BY product_id DESC");
$image_path = "foldernew/"; 
?>

<table border="1" cellpadding="10" cellspacing="0">
<?php
while ($di = mysqli_fetch_assoc($sql)) {
?>
    <tr>
        <td><b><i>Product Name</i></b></td>
        <td><?php echo htmlspecialchars($di['productname']); ?></td>
    </tr>

    <tr>
        <td><b><i>Price</i></b></td>
        <td>$<?php echo $di['price']; ?></td>
    </tr>

    <tr>
        <td><b><i>Stock</i></b></td>
        <td><?php echo $di['stock']; ?></td>
    </tr>

    <tr>
        <td><b><i>Category</i></b></td>
        <td><?php echo $di['category']; ?></td>
    </tr>

    <tr>
        <td><b><i>Description</i></b></td>
        <td><?php echo htmlspecialchars($di['description']); ?></td>
    </tr>

    <tr>
        <td><b><i>Image</i></b></td>
        <td>
            <img src="<?php echo $di['image1']; ?>" height="100" width="100">     
       </td>
    </tr>

    <tr><td colspan="2"><hr></td></tr>

<?php
}
mysqli_close($conn);
?>
</table>

</body>
</html>