<?php 
session_start(); 

// 1. Session Protection (Checks if email is stored in session)
if (!isset($_SESSION["xx"])) {
    header("Location: userlogin.php"); 
    exit();
}

$user_email = $_SESSION["xx"];

// 2. Database Connection
$conn = mysqli_connect("localhost", "root", "", "userdata");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 3. Fetch details using the EMAIL from the session
$safe_email = mysqli_real_escape_string($conn, $user_email);
$query = "SELECT * FROM useregister WHERE email = '$safe_email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_array($result);

// Error handling if record is missing
if (!$user) {
    session_destroy();
    header("Location: userlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('poster14.jpg') no-repeat center/cover;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 192, 203, 0.6);
             backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 55px;
        }
        .navbar-brand { font-family: 'Lobster', cursive !important; font-size: 26px; }
        .navbar-brand span:first-child {
    color: #d81b60;
}
.navbar-brand span:last-child {
    color: #4b0082;
}


        .account-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 80px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .profile-circle {
            width: 80px;
            height: 80px;
            background: #ffb6c1;
            color: #d81b60;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 15px;
            border: 3px solid #fff;
        }

        .info-box {
            background: #fdfdfd;
            border-left: 4px solid #d81b60;
            padding: 12px 15px;
            margin-bottom: 12px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        }

        .label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: #999;
            letter-spacing: 1px;
            display: block;
        }

        .value {
            font-size: 15px;
            color: #333;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="userpanel.php">
            <span class="brand-m">Fashion</span><span class="brand-i">Hub</span>
        </a>
        <a href="userpanel.php" class="btn btn-dark btn-sm rounded-pill px-4">Back</a>
    </div>
</nav>

<div class="container d-flex justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="account-card">
            <div class="text-center mb-4">
                <div class="profile-circle">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h4 class="fw-bold mb-0"><?php echo $user['fullname']; ?></h4>
                <p class="text-muted small"><?php echo $user['email']; ?></p>
            </div>

            <div class="info-box">
                <span class="label">Full Name</span>
                <span class="value"><?php echo $user['fullname']; ?></span>
            </div>

            <div class="info-box">
                <span class="label">Contact Number</span>
                <span class="value"><?php echo $user['contactnumber']; ?></span>
            </div>

            <div class="info-box">
                <span class="label">Home Address</span>
                <span class="value"><?php echo $user['address']; ?></span>
            </div>

            <div class="info-box">
                <span class="label">Gender</span>
                <span class="value"><?php echo ucfirst($user['gender']); ?></span>
            </div>

            <div class="mt-4">
                <button class="btn btn-outline-danger w-100 rounded-pill fw-bold btn-sm">Sign Out from this Device</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>