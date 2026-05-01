<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) { 
    header("Location: userlogin.html"); 
    exit(); 
}
$uid = $_SESSION['user_id']; 
$conn = mysqli_connect("localhost", "root", "", "userdata");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM useregister WHERE user_id = '$uid'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_array($result);

if (!$user) {
    header("Location: userlogin.html?error=usernotfound");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Aesthetic Light Grey/Blue Gradient - No Pink */
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .navbar {
            background: rgba(255, 192, 203, 0.9) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: 55px;
        }
        
        .navbar-brand { font-family: 'Lobster', cursive !important; font-size: 24px; }
        .navbar-brand span:first-child { color: #d81b60; }
        .navbar-brand span:last-child { color: #4b0082; }

        .account-card {
            background: #ffffff;
            border-radius: 30px;
            padding: 40px 30px;
            /* Soft shadow for a "floating" look */
            box-shadow: 0 20px 60px rgba(148, 163, 184, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.8);
            max-width: 360px;
            width: 90%;
            text-align: center;
            margin-top: 80px;
        }

        .profile-circle {
            width: 90px;
            height: 90px;
            /* Changed gradient to a more neutral blue-indigo */
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px auto;
            border: 6px solid #f8fafc;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);
        }

        .user-name {
            color: #0f172a;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .user-email {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 25px;
        }

        .info-list {
            text-align: left;
            background: #f8fafc;
            border-radius: 20px;
            padding: 15px;
            border: 1px solid #f1f5f9;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 12px;
            gap: 15px;
        }

        .info-item:not(:last-child) {
            border-bottom: 1px solid #edf2f7;
        }

        .icon-box {
            width: 36px;
            height: 36px;
            background: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6366f1;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .info-content .label {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.8px;
        }

        .info-content .value {
            display: block;
            font-size: 13px;
            color: #334155;
            font-weight: 600;
        }

        .btn-logout {
            margin-top: 25px;
            background: #fee2e2;
            color: #ef4444;
            border: none;
            padding: 14px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 14px;
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #d81b60;
            color: white;
            font-size: 11px;
            border-radius: 50px;
            padding: 6px 16px;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .btn-back:hover {
            opacity: 0.9;
            color: white;
        }

        @media (max-width: 400px) {
            .account-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

<nav class="navbar fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="userpanel.php">
            <span>Fashion</span><span>Hub</span>
        </a>
        <a href="userpanel.php" class="btn-back">
            <i class="bi bi-arrow-left"></i> BACK
        </a>
    </div>
</nav>

<div class="account-card">
    <div class="profile-circle">
        <i class="bi bi-person-fill"></i>
    </div>
    
    <div class="user-name"><?php echo htmlspecialchars($user['fullname']); ?></div>
    <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>

    <div class="info-list">
        <div class="info-item">
            <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
            <div class="info-content">
                <span class="label">Contact</span>
                <span class="value"><?php echo htmlspecialchars($user['contactnumber']); ?></span>
            </div>
        </div>

        <div class="info-item">
            <div class="icon-box"><i class="bi bi-geo-alt-fill"></i></div>
            <div class="info-content">
                <span class="label">Address</span>
                <span class="value"><?php echo htmlspecialchars($user['address']); ?></span>
            </div>
        </div>

        <div class="info-item">
            <div class="icon-box"><i class="bi bi-person-badge-fill"></i></div>
            <div class="info-content">
                <span class="label">Gender</span>
                <span class="value"><?php echo ucfirst(htmlspecialchars($user['gender'])); ?></span>
            </div>
        </div>
    </div>

    <a href="logout.php" class="btn-logout">
        <i class="bi bi-box-arrow-right me-2"></i> SIGN OUT
    </a>
</div>

</body>
</html>
<?php mysqli_close($conn); ?>