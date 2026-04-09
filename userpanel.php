<?php 
session_start(); 
if (!isset($_SESSION["xx"])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION["xx"];
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
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif; 
        }

        body {
            min-height: 100vh;
            /* Added a slight overlay to make text more readable on any background image */
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('poster14.jpg') no-repeat center/cover;
            background-attachment: fixed;
        }

        /* --- NAVBAR (UNCHANGED as requested) --- */
        .navbar {
            width: 100%;
            background: #ffb6c1;  /* solid light pink */
            padding: 5px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            z-index: 1000;
            height: 55px;
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

 
.navbar-brand { 
    font-family: 'Lobster', cursive !important; 
    font-size: 28px;     text-decoration: none;
    display: flex;
    align-items: center;
}

/* Force spans to inherit the cursive font and apply your colors */
.navbar-brand span {
    font-family: 'Lobster', cursive !important;
}

.navbar-brand span:first-child { 
    color: #d81b60; /* Magenta */
}

.navbar-brand span:last-child { 
    color: #4b0082; /* Indigo */
}
        
        /* --- BEAUTIFUL BODY AREA --- */
                /* Small Profile Box */

                .panel-container {
               position: relative;
               width: 90%;
               max-width: 900px;
                margin: 85px auto 60px; 
               z-index: 1;
            }


        .profile-box {
            text-align: center;
            background: rgba(255, 255, 255, 0.15); /* Glass effect */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 20px;
            border-radius: 20px;
            margin: 0 auto 30px;
            max-width: 400px; /* Made smaller */
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .profile-img {
            width: 65px; /* Smaller image */
            height: 65px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 2px solid white;
            object-fit: cover;
        }

        .profile-box h2 {
            font-size: 1.4rem;
            margin-bottom: 2px;
            font-weight: 600;
        }

        .profile-box p {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 0;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
        }

        /* Interactive Cards */
        .card-link {
            padding: 25px 15px;
            text-align: center;
            border-radius: 18px;
            text-decoration: none;
            font-weight: 600;
            color: #333;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.4);
        }

        .card-link:hover {
            transform: translateY(-8px);
            background: #fff;
            box-shadow: 0 15px 30px rgba(216, 27, 96, 0.2);
            color: #d81b60;
        }

        .card-link img {
            width: 42px;
            height: 42px;
            transition: 0.3s ease;
        }

        .card-link:hover img {
            transform: scale(1.15);
        }

        /* Subtle background colors for cards to look "Beautiful" */
        .c-1 { background: #fff0f3; }
        .c-2 { background: #f0faff; }
        .c-3 { background: #f2fff5; }
        .c-4 { background: #fff9f0; }
        .c-5 { background: #f6f0ff; }
        .c-6 { background: #fff0f0; }

        @media(max-width: 768px){
            .panel-container { margin-top: 130px; }
            .menu-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="#">
                <span>Fashion</span><span>Hub</span>
            </a>
            <div class="d-none d-md-flex ms-3">
                <a href="#" class="text-dark text-decoration-none fw-bold small px-2">Help</a>
                <a href="#" class="text-dark text-decoration-none fw-bold small px-2">Offers</a>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <input type="text" class="form-control form-control-sm d-none d-sm-block" placeholder="Search..." style="border-radius:20px; width:150px; border:none;">
            <a href="usercart.html" class="btn btn-dark btn-sm fw-bold rounded-pill px-3">My Cart</a>
        </div>
    </div>
</nav>

<div class="panel-container">
    
    <div class="profile-box">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User" class="profile-img">
        <h2>Hi, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>Manage your style journey</p>
    </div>

    <div class="menu-grid">
        <a href="myaccount.php" class="card-link c-1">
            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="Account">
            <span>My Account</span>
        </a>
        <a href="usercart.html" class="card-link c-2">
            <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="Cart">
            <span>My Cart</span>
        </a>
        <a href="orders.php" class="card-link c-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3144/3144456.png" alt="Orders">
            <span>Orders</span>
        </a>
        <a href="coupons.php" class="card-link c-4">
            <img src="https://cdn-icons-png.flaticon.com/512/2331/2331949.png" alt="Coupons">
            <span>Coupons</span>
        </a>
        <a href="wallet.php" class="card-link c-5">
            <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" alt="Wallet">
            <span>Wallet</span>
        </a>
        <a href="userlogin.html" class="card-link c-6">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828427.png" alt="Logout">
            <span class="text-danger">Logout</span>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>