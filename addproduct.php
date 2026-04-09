<html>
<body>
<?php
$t1 = $_POST['nm1'];
$t2 = $_POST['nm2'];
$t3 = $_POST['nm3'];
$t4 = $_POST['nm4'];
$t5 = $_POST['nm5'];

// File uploads
$t6 = $_FILES['nm6'];
$t7 = $_FILES['nm7'];
$t8 = $_FILES['nm8'];
$folder = "foldernew/";
move_uploaded_file($t6['tmp_name'], $folder . $t6['name']);
move_uploaded_file($t7['tmp_name'], $folder . $t7['name']);
move_uploaded_file($t8['tmp_name'], $folder . $t8['name']);
$xx1 = $folder . $t6['name'];
$xx2 = $folder . $t7['name'];
$xx3 = $folder . $t8['name'];
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO addproduct 
(productname, price, stock, category, description, image1, image2, image3)
VALUES ('$t1','$t2','$t3','$t4','$t5','$xx1','$xx2','$xx3')";
$recs = mysqli_query($conn, $sql);

if ($recs) {
    echo "<h2>Product Added Successfully!..</h2>";
} else {
    echo "<h2>Sorry Try Again!..</h2>";
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
</body>
</html>