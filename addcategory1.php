<html>
<body>
<?php
$t1 = $_POST['nm1'];
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
$recs = mysqli_query($conn, "INSERT INTO category (nameofcategory) VALUES ('$t1')");
if ($recs) {
    echo "<h2>Category Added!..</h2>";
   } 
else {
    echo "<h2>Sorry Try Again!..</h2>";
   }
mysqli_close($conn);
?>
</body>
</html>