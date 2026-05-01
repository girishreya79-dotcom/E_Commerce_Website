<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopping");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location.href='userlogin.php';</script>";
    exit();
}

$uid = $_SESSION['user_id'];
$folder = "foldernew/"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bag | FashionHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --accent-pink: #e91e63;
            --accent-purple: #6a0dad;
            --soft-bg: #f8fafc;
            --text-main: #334155;
        }

        body { background-color: var(--soft-bg); font-family: 'Inter', sans-serif; color: var(--text-main); }
        
        .navbar-custom { 
            background: rgba(255, 192, 203, 0.6); 
            backdrop-filter: blur(10px);
            padding: 10px 25px; 
            box-shadow: 0 2px 15px rgba(0,0,0,0.1); 
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand { 
            font-family: 'Dancing Script', cursive; 
            font-size: 30px; 
            font-weight: 800; 
            text-decoration: none;
        }
        .navbar-brand span:first-child { color: var(--accent-pink); }
        .navbar-brand span:last-child { color: var(--accent-purple); }

        .container { max-width: 1100px; margin-top: 30px; }

        .cart-row { 
            background: #ffffff; 
            border-radius: 12px; 
            padding: 10px 20px; 
            margin-bottom: 10px; 
            display: grid;
            grid-template-columns: 70px 1.5fr 1.2fr 100px 280px;
            align-items: center;
            gap: 15px;
            border: 1px solid #edf2f7;
            transition: all 0.2s ease-in-out;
        }
        .cart-row:hover { border-color: var(--accent-pink); background-color: #fffafc; }
        
        .prod-img { width: 65px; height: 65px; object-fit: cover; border-radius: 8px; }
        .prod-name { font-weight: 600; color: #1e293b; margin: 0; font-size: 0.95rem; }
        
        .qty-input { width: 50px; height: 32px; border: 1px solid #e2e8f0; text-align: center; border-radius: 6px; font-size: 0.85rem; }
        .btn-update { background: #f8fafc; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; color: #64748b; }
        
        .btn-view { background: #f1f5f9; color: #475569; border-radius: 8px; font-size: 0.75rem; font-weight: 700; padding: 8px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
        .btn-view:hover { background: #e2e8f0; color: #1e293b; }

        .btn-order { 
            background: linear-gradient(45deg, var(--accent-pink), var(--accent-purple));
            color: white; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 0.75rem;
            text-transform: uppercase; transition: 0.2s;
        }
        .btn-order:hover { opacity: 0.9; transform: translateY(-1px); color: white; }

        .price-text { font-weight: 700; color: #1e293b; font-size: 1rem; text-align: right; }
        .trash-btn { color: #cbd5e1; border: none; background: none; font-size: 1.1rem; transition: 0.2s; }
        .trash-btn:hover { color: #ef4444; }

        @media (max-width: 992px) {
            .cart-row { grid-template-columns: 1fr; text-align: center; justify-items: center; gap: 10px; }
        }
    </style>
</head>
<body>

<nav class="navbar-custom sticky-top">
    <a class="navbar-brand" href="product.php"><span>Fashion</span><span>Hub</span></a>
    <a href="product.php" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold" style="font-size: 0.75rem;">Continue Shopping</a>
</nav>

<div class="container">
    <h5 class="fw-bold mb-4" style="color: #0f172a;">Shopping Bag</h5>
    
    <?php
    $query = "SELECT c.quantity, p.* FROM cart c 
              JOIN addproduct p ON c.product_id = p.product_id 
              WHERE c.user_id = '$uid'
              ORDER BY c.cart_id DESC";
    
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pid = $row['product_id'];
            $qty = $row['quantity'];
            $subtotal = $row['price'] * $qty;
            
            $img_path = trim($row['image1']);
            $final_src = $folder . basename($img_path);
    ?>
        <div class="cart-row">
            <img src="<?php echo $final_src; ?>" class="prod-img" onerror="this.src='https://via.placeholder.com/60?text=Img';">

            <div>
                <p class="prod-name"><?php echo htmlspecialchars($row['productname']); ?></p>
                <small class="text-muted fw-bold">$<?php echo number_format($row['price'], 2); ?></small>
            </div>

            <form action="updatecart.php" method="POST" class="d-flex align-items-center gap-2">
                <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
                <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" class="qty-input">
                <button type="submit" class="btn-update">Update</button>
            </form>

            <div class="price-text">$<?php echo number_format($subtotal, 2); ?></div>

            <div class="d-flex align-items-center justify-content-end gap-2">
                <a href="productdetails.php?id=<?php echo $pid; ?>" class="btn-view">
                    <i class="bi bi-eye"></i> View
                </a>
                
                <form action="orderproduct.php" method="POST" class="m-0">
                    <input type="hidden" name="id" value="<?php echo $pid; ?>">
                    <input type="hidden" name="qty" value="<?php echo $qty; ?>">
                    <button type="submit" class="btn-order">Order Now</button>
                </form>

                <form action="removefromcart.php" method="POST" class="m-0">
                    <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
                    <button type="submit" class="trash-btn" onclick="return confirm('Remove?')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
    <?php 
        }
    } else {
        echo "<div class='text-center py-5 bg-white rounded-3 border'>
                <p class='text-muted small fw-bold'>Your bag is empty.</p>
              </div>";
    }
    ?>
</div>

</body>
</html>