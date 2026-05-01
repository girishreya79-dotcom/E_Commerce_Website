<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Removal Status - FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Lobster&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fdf2f5; font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .navbar { background-color: #2d2d2d; position: fixed; top: 0; width: 100%; padding: 12px 0; }
        .navbar-brand { font-family: 'Lobster', cursive; color: #d81b60 !important; font-size: 1.8rem; margin-left: 20px; }
        .message-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; max-width: 450px; border: 1px solid #fce4ec; }
        .btn-back { background-color: #d81b60; color: white; border-radius: 10px; padding: 10px 25px; text-decoration: none; display: inline-block; margin-top: 20px; transition: 0.3s; }
        .btn-back:hover { background-color: #b0154b; color: white; }
        .success-text { color: #28a745; font-weight: 700; }
        .error-text { color: #dc3545; font-weight: 700; }
    </style>
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="#">FashionHub</a>
</nav>

<div class="message-card">
<?php
$pid = $_POST['category_id']; 
$conn = mysqli_connect("localhost", "root", "", "shopping");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "DELETE FROM category WHERE category_id = $pid";
if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
        echo "<h2 class='success-text'>Category Removed!</h2>";
        echo "<p>Category with ID <b>$pid</b> was successfully deleted.</p>";
    } else {
        echo "<h2 class='error-text'>Not Found</h2>";
        echo "<p>No category exists with ID <b>$pid</b>. Please check your database.</p>";
    }
} else {
    echo "<h2 class='error-text'>Error</h2>";
    echo "<p>Query failed: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>
    <a href="admindashboard1.php" class="btn-back">Return to Dashboard</a>
</div>

</body>
</html>