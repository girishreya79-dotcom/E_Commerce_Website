<?php 
session_start(); 
if (!isset($_SESSION["xx"])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION["xx"];

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - FashionHub</title>

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

        /* --- Navbar (Exactly like your provided code) --- */
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

        /* --- Product Card Design --- */
        .product-card {
            background: var(--card-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(216, 27, 96, 0.05);
            border: 1px solid #fce4ec;
            transition: 0.3s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(216, 27, 96, 0.1);
        }

        .img-container {
            background: #fff9fa;
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
            border-bottom: 1px solid #fdf2f5;
        }

        .thumb-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .card-body-custom {
            padding: 20px;
        }

        .category-tag {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--accent-pink);
            background: #fff0f3;
            padding: 3px 10px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .product-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--nav-bg);
            margin-bottom: 5px;
        }

        .price-text {
            color: var(--nav-bg);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .stock-info {
            font-size: 0.8rem;
            color: var(--label-color);
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
        <h3>Product Catalog</h3>
        <p class="text-muted small">View and manage all items currently available in the system.</p>
    </div>

    <div class="row g-4">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM addproduct ORDER BY product_id DESC");
        if (mysqli_num_rows($sql) > 0) {
            while ($di = mysqli_fetch_array($sql)) {
                // Using 'foldernew' as per your folder setup
                $img1 = "foldernew/" . basename($di[6]);
                $img2 = "foldernew/" . basename($di[7]);
                $img3 = "foldernew/" . basename($di[8]);
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="product-card">
                <div class="img-container">
                    <img src="<?php echo $img1; ?>" class="thumb-img" onerror="this.src='https://via.placeholder.com/70?text=N/A'">
                    <img src="<?php echo $img2; ?>" class="thumb-img" onerror="this.src='https://via.placeholder.com/70?text=N/A'">
                    <img src="<?php echo $img3; ?>" class="thumb-img" onerror="this.src='https://via.placeholder.com/70?text=N/A'">
                </div>

                <div class="card-body-custom">
                    <span class="category-tag"><?php echo $di[4]; ?></span>
                    <h5 class="product-title"><?php echo $di[1]; ?></h5>
                    <p class="text-muted small mb-3" style="height: 35px; overflow: hidden;"><?php echo substr($di[5], 0, 60); ?>...</p>
                    
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div class="price-text">₹<?php echo number_format((float)preg_replace('/[^0-9.]/', '', $di[2]), 2); ?></div>
                        <div class="text-end">
                            <div class="stock-info fw-bold"><?php echo $di[3]; ?> In Stock</div>
                            <div class="text-muted" style="font-size: 10px;">ID: #<?php echo $di[0]; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<div class='col-12 text-center p-5'><p class='text-muted'>No products found in the database.</p></div>";
        }
        mysqli_close($conn);
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>