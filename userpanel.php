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

$query = "SELECT fullname FROM useregister WHERE user_id = '$uid'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);
$display_name = $user_data['fullname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub User Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lobster&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { 
            min-height: 100vh; 
     background: linear-gradient(rgba(248, 249, 252, 0.1), rgba(248, 249, 252, 0.1)),
url('online4.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding-top: 60px; 
        }

        .navbar {
            background: rgba(255, 192, 203, 0.8) !important; 
            backdrop-filter: blur(15px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 45px !important; 
            z-index: 1000;
            padding: 0 !important;
        }

        .navbar-brand { 
            font-family: 'Lobster', cursive !important; 
            font-size: 24px !important; 
            text-decoration: none !important; 
            display: flex !important; 
            align-items: center !important; 
            height: 45px !important;
            margin: 0 !important;
        }

        .brand-fashion { color: #d81b60 !important; }
        .brand-hub { color: #4b0082 !important; }

        .panel-container { width: 95%; max-width: 400px; margin: 30px auto; }

        .profile-box {
            text-align: center;
            background: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 20px;
            border: 1px solid #ffdae0;
            box-shadow: 0 8px 32px rgba(0,0,0,0.05);
            backdrop-filter: blur(5px);
        }

        .profile-img { 
            width: 65px; height: 65px; border-radius: 50%; 
            margin-bottom: 10px; border: 2px solid #d81b60; object-fit: cover; 
        }

        .profile-box h2 { font-size: 1.2rem; font-weight: 600; color: #1e293b; }
        .profile-box p { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }

        .menu-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }

        .card-link {
            padding: 15px 10px;
            text-align: center;
            border-radius: 18px;
            text-decoration: none !important;
            font-weight: 600;
            color: #475569;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            border: 1px solid rgba(241, 245, 249, 0.8);
            backdrop-filter: blur(5px);
        }

        .card-link:hover {
            transform: translateY(-4px);
            background: #fff;
            color: #d81b60;
            border-color: #ffdae0;
        }

        .card-link img { width: 32px; height: 32px; }
        .card-link span { font-size: 12px; }

        .c-1 { border-top: 4px solid #ff9a9e; }
        .c-2 { border-top: 4px solid #b3e5fc; }
        .c-3 { border-top: 4px solid #a18cd1; }
        .c-4 { border-top: 4px solid #fad0c4; }
        .c-5 { border-top: 4px solid #84fab0; }
        .c-6 { border-top: 4px solid #ff4d6d; }
    </style>
</head>
<body>

<nav class="navbar fixed-top">
    <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="userpanel.php">
            <span class="brand-fashion">Fashion</span><span class="brand-hub">Hub</span>
        </a>
        <div class="d-flex align-items-center">
            <a href="cart.php" class="btn btn-dark btn-sm fw-bold rounded-pill px-3" style="font-size: 0.7rem; padding: 2px 12px;">View Cart</a>
        </div>
    </div>
</nav>

<div class="panel-container">
    <div class="profile-box">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User" class="profile-img">
        <h2>Hi, <?php echo htmlspecialchars($display_name); ?>!</h2>
        <p>Style Dashboard</p>
    </div>

    <div class="menu-grid">
        <a href="myaccount.php" class="card-link c-1">
            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="Account">
            <span>Account</span>
        </a>

        <a href="cart.php" class="card-link c-2">
            <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="Shop">
            <span>My Cart</span>
        </a>
        
        <a href="viewproductconfirm.php" class="card-link c-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3144/3144456.png" alt="Orders">
            <span>My Orders</span>
        </a>

        <a href="coupons.php" class="card-link c-4">
            <img src="https://cdn-icons-png.flaticon.com/512/2331/2331949.png" alt="Coupons">
            <span>Coupons</span>
        </a>

        <a href="wallet.php" class="card-link c-5">
            <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" alt="Wallet">
            <span>Wallet</span>
        </a>

        <a href="logout.php" class="card-link c-6">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828427.png" alt="Logout">
            <span class="text-danger">Logout</span>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php mysqli_close($conn); ?>