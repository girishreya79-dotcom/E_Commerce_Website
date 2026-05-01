<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.php");
    exit();
}
$uid = $_SESSION['user_id'];
$folder = "foldernew/"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | FashionHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-color: #f8f9fa;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --accent-pink: #e91e63;
            --accent-purple: #6a0dad;
            --card-bg: #ffffff;
        }

        body { 
            background-color: var(--bg-color); 
            font-family: 'Inter', sans-serif; 
            color: var(--text-dark);
            margin: 0;
        }

        .navbar-custom {
            background: rgba(255, 192, 203, 0.6);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            height: 60px; 
            padding: 0 30px; 
            display: flex;
            align-items: center; 
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand { 
            font-family: 'Dancing Script', cursive; 
            font-size: 32px; 
            font-weight: 500 !important; 
            text-decoration: none;
            display: flex;
            gap: 8px;
        }

        .navbar-brand span:first-child { color: var(--accent-pink); }
        .navbar-brand span:last-child { color: var(--accent-purple); }

        .container { max-width: 950px; margin-top: 50px; }
        
        .page-header { margin-bottom: 40px; }
        .page-header h3 { font-weight: 800; color: var(--text-dark); margin-bottom: 10px; }

        .order-card {
            display: grid;
            grid-template-columns: 120px 1fr 140px 160px; 
            align-items: center;
            gap: 20px;
            background: var(--card-bg);
            padding: 25px 35px; 
            border-radius: 20px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .order-card:hover { 
            transform: translateY(-3px);
            border-color: var(--accent-pink); 
            box-shadow: 0 12px 30px rgba(233, 30, 99, 0.1); 
        }

        .img-box { 
            width: 100px; 
            height: 100px; 
            border-radius: 13px; 
            overflow: hidden; 
            background: #f1f5f9; 
            border: 1px solid #eee;
        }
        .img-box img { width: 100%; height: 100%; object-fit: cover; }

        .order-meta { font-size: 11px; font-weight: 800; color: var(--accent-pink); text-transform: uppercase; margin-bottom: 5px; }
        .prod-name { font-size: 20px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .order-date { font-size: 14px; color: var(--text-muted); margin-top: 3px; }
        
        .price-text { font-size: 22px; font-weight: 800; color: var(--text-dark); }
        .pay-method { font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        
        .status-pill {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .pending { background: #fff4f7; color: #d81b60; border: 1px solid #f8bbd0; }
        .confirmed { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .cancelled { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        @media (max-width: 850px) {
            .order-card { grid-template-columns: 1fr; text-align: center; justify-items: center; }
            .text-end { text-align: center !important; }
        }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <a class="navbar-brand" href="product.php">
        <span>Fashion</span><span>Hub</span>
    </a>
</nav>

<div class="container">
    <div class="page-header">
        <h3>My Purchase History</h3>
        <div style="width: 80px; height: 5px; background: var(--accent-pink); border-radius: 10px;"></div>
    </div>

    <?php
    $query = "SELECT o.*, p.productname, p.image1 
              FROM orderproduct o 
              JOIN addproduct p ON o.product_id = p.product_id 
              WHERE o.user_id = '$uid' 
              ORDER BY o.order_id DESC";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $status = strtolower($row['status']);
            
            $imageFileName = trim($row['image1']);
            $cleanFileName = basename($imageFileName); 
            $imgPath = $folder . $cleanFileName;
    ?>
        <div class="order-card">
            
            <div class="img-box">
                <img src="<?php echo $imgPath; ?>" 
                     onerror="this.src='https://via.placeholder.com/100?text=Product';">
            </div>

            <div>
                <div class="order-meta">Order ID: #<?php echo $row['order_id']; ?></div>
                <p class="prod-name"><?php echo htmlspecialchars($row['productname']); ?></p>
                <div class="order-date">
                    <span class="badge bg-light text-dark border me-2">Qty: <?php echo $row['quantity']; ?></span>
                    <i class="bi bi-calendar3 me-2"></i><?php echo date('M d, Y', strtotime($row['order_date'])); ?>
                </div>
            </div>

            <div class="text-center">
                <div class="price-text">$<?php echo number_format($row['total_price'], 2); ?></div>
                <div class="pay-method"><?php echo $row['payment_method']; ?></div>
            </div>

            <div class="text-end">
                <span class="status-pill <?php echo $status; ?>">
                    <?php if($status == 'pending'): ?><i class="bi bi-hourglass-split"></i><?php endif; ?>
                    <?php if($status == 'confirmed'): ?><i class="bi bi-patch-check-fill"></i><?php endif; ?>
                    <?php echo strtoupper($status); ?>
                </span>
            </div>

        </div>
    <?php 
        }
    } else {
        echo "<div class='text-center p-5 bg-white rounded-4 border shadow-sm'>
                <i class='bi bi-bag-x text-muted' style='font-size: 4rem;'></i>
                <p class='mt-3 text-muted fw-bold'>No history found.</p>
              </div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>