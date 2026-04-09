<?php 
session_start(); 
if (!isset($_SESSION["xx"])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION["xx"];

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "userdata");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers - FashionHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-body: #fdf2f5;
            --nav-bg: #2d2d2d;
            --card-white: #ffffff;
            --accent-pink: #d81b60;
            --label-color: #7d6b70;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            min-height: 100vh;
            margin: 0;
        }

        /* --- Navbar (Exact same design) --- */
        .navbar {
            background-color: var(--nav-bg);
            padding: 12px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-family: 'Lobster', cursive;
            font-size: 1.8rem;
            color: var(--accent-pink) !important;
            text-decoration: none;
        }

        .nav-status {
            border-left: 1px solid #444;
            padding-left: 15px;
            margin-left: 15px;
        }

        .nav-status small {
            color: #ff75a0;
            font-size: 10px;
            display: block;
            text-transform: uppercase;
        }

        .nav-status span {
            color: white;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-return {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-return:hover {
            background-color: var(--accent-pink);
            color: white;
        }

        /* --- Content Layout --- */
        .main-content {
            margin-top: 50px;
            padding-bottom: 50px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h3 {
            font-weight: 700;
            color: var(--nav-bg);
        }

        /* --- Customer Card Design --- */
        .customer-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(216, 27, 96, 0.05);
            border: 1px solid #fce4ec;
            transition: 0.3s;
            height: 100%;
            position: relative;
        }

        .customer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(216, 27, 96, 0.1);
        }

        .user-icon {
            width: 50px;
            height: 50px;
            background: #fff0f3;
            color: var(--accent-pink);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .customer-id {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 11px;
            font-weight: 700;
            color: #bbb;
        }

        .customer-name {
            font-weight: 700;
            color: var(--nav-bg);
            margin-bottom: 5px;
        }

        .customer-info {
            font-size: 0.85rem;
            color: var(--label-color);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .customer-info i {
            color: var(--accent-pink);
            width: 15px;
        }

        .gender-badge {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            background: #f8f9fa;
            padding: 2px 10px;
            border-radius: 50px;
            margin-top: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="#">FashionHub</a>
            <div class="nav-status d-none d-md-block">
                <small>System Status</small>
                <span>Administrator (<?php echo htmlspecialchars($username); ?>)</span>
            </div>
        </div>
        <a href="admindashboard1.php" class="btn-return">&larr; Return to Dashboard</a>
    </div>
</nav>

<div class="container main-content">
    <div class="section-header">
        <h3>Registered Customers</h3>
        <p class="text-muted small">Managing all active user accounts for FashionHub.</p>
    </div>

    <div class="row g-4">
        <?php
        // Fetching from useregister table
        $sql = mysqli_query($conn, "SELECT * FROM useregister ORDER BY user_id DESC");
        
        if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_array($sql)) {
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="customer-card">
                <span class="customer-id">#USER-<?php echo $row['user_id']; ?></span>
                
                <div class="user-icon">
                    <i class="bi bi-person-badge-fill"></i>
                </div>

                <h5 class="customer-name"><?php echo $row['fullname']; ?></h5>
                
                <div class="customer-info">
                    <i class="bi bi-envelope-fill"></i> <?php echo $row['email']; ?>
                </div>
                
                <div class="customer-info">
                    <i class="bi bi-telephone-fill"></i> <?php echo $row['contactnumber']; ?>
                </div>

                <div class="customer-info">
                    <i class="bi bi-geo-alt-fill"></i> <?php echo $row['address']; ?>
                </div>

                <div class="gender-badge">
                    <i class="bi bi-gender-ambiguous"></i> <?php echo $row['gender']; ?>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<div class='col-12 text-center p-5'><p class='text-muted'>No customers registered yet.</p></div>";
        }
        mysqli_close($conn);
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>