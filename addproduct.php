<html>
<body>
<?php
$t1 = $_POST['nm1'];
$t2 = $_POST['nm2'];
$t3 = $_POST['nm3'];
$t4 = $_POST['nm4'];
$t5 = $_POST['nm5'];
$folder = "foldernew/";
if (!file_exists($folder)) {
    mkdir($folder);
}
function uploadImage($file, $folder) {
    if (!empty($file['name'])) {
        $filename = time() . "_" . basename($file['name']);
        $path = $folder . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return $path;
        } else {
            return "";
        }
    }
    return "";
}
$xx1 = uploadImage($_FILES['nm6'], $folder);
$xx2 = uploadImage($_FILES['nm7'], $folder);
$xx3 = uploadImage($_FILES['nm8'], $folder);

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