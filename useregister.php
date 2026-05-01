<html>
<body>
<?php
$t1=$_POST['nm1'];
$t2=$_POST['nm2'];
$t3=$_POST['nm3'];
$t4=$_POST['nm4'];
$t5=$_POST['nm5'];
$t6=$_POST['nm6'];
$conn=mysqli_connect("localhost","root","","userdata");
mysqli_select_db($conn,"userdata");
$recs= mysqli_query($conn,"insert into useregister(fullname,email,password,address,contactnumber,gender) values('$t1','$t2','$t3','$t4','$t5','$t6')");

if($recs!=0)
{
  print "<center><h2>Congratulations! You registered successfully!...</h2><h3>Welcome to FashionHub</center>";
}
else
{
  print "<h2>Sorry Try Again!..</h2>";
  echo "MySQL Error: " . mysqli_error($conn);
}
?>

</body>
</html>