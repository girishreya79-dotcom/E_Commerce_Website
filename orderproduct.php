<?php
session_start();
$conn_shop = mysqli_connect("localhost", "root", "", "shopping"); 
$conn_user = mysqli_connect("localhost", "root", "", "userdata"); 

if (!$conn_shop || !$conn_user) { 
    die("Connection failed: " . mysqli_connect_error()); 
}
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.php");
    exit();
}

$uid = $_SESSION['user_id'];
$pid = isset($_POST['id']) ? mysqli_real_escape_string($conn_shop, $_POST['id']) : null;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1; 

if (!$pid) {
    die("No product selected.");
}
$p_res = mysqli_query($conn_shop, "SELECT * FROM addproduct WHERE product_id = '$pid'");
$product = mysqli_fetch_assoc($p_res);

if (!$product) {
    die("Product not found.");
}
$u_res = mysqli_query($conn_user, "SELECT * FROM useregister WHERE user_id = '$uid'");
$user = mysqli_fetch_assoc($u_res);

$total_price = $product['price'] * $qty;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | FashionHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { 
            background-color: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
        }

        .checkout-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .order-card {
            background: #ffffff;
            width: 100%;
            max-width: 450px;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            padding: 32px;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .header-section { text-align: center; margin-bottom: 24px; }
        .header-section h3 { font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px; }
        
        .product-mini-card {
            background: #f1f5f9;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .product-info h6 { margin: 0; font-weight: 700; color: #0f172a; }
        .product-info span { font-size: 0.85rem; color: #64748b; }

        .price-tag {
            margin-left: auto;
            font-weight: 800;
            color: #0f172a;
            font-size: 1.1rem;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 15px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-place-order {
            background: #0f172a;
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            margin-top: 10px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-place-order:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
            color: #fbbf24;
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 0.85rem;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
        }
        
        .cancel-link:hover { color: #f43f5e; }

        .secure-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            color: #cbd5e1;
            text-transform: uppercase;
            margin-top: 20px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
<div class="checkout-wrapper">
    <div class="order-card">
        <div class="header-section">
            <h3>Checkout</h3>
            <p class="text-muted small">Complete your order details below</p>
        </div>

        <div class="product-mini-card">
            <div class="product-info">
                <h6><?php echo htmlspecialchars($product['productname']); ?></h6>
                <span>Qty: <?php echo $qty; ?> | Premium Quality</span>
            </div>
            <div class="price-tag">
                $<?php echo number_format($total_price, 2); ?>
            </div>
        </div>

        <form action="placeorder.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
            <input type="hidden" name="quantity" value="<?php echo $qty; ?>">
            <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <!-- Using session or database values to pre-fill the form -->
                <input type="text" name="customer_name" class="form-control" 
                       value="<?php echo isset($user['fullname']) ? htmlspecialchars($user['fullname']) : ''; ?>" required>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="contact" class="form-control" 
                           value="<?php echo isset($user['contact']) ? htmlspecialchars($user['contact']) : ''; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Shipping Address</label>
                <textarea name="address" class="form-control" rows="2" required><?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Payment Method</label>
                <select name="payment" class="form-select">
                    <option value="Cash on Delivery">Cash on Delivery (COD)</option>
                    <option value="Online Payment">Online Payment</option>
                </select>
            </div>

            <button type="submit" class="btn-place-order">
                <span>Confirm Order</span>
                <i class="bi bi-arrow-right-short fs-4"></i>
            </button>

            <a href="product.php" class="cancel-link">Discard and return</a>

            <div class="secure-badge">
                <i class="bi bi-shield-lock-fill"></i>
                Secure Checkout Powered by FashionHub
            </div>
        </form>
    </div>
</div>

</body>
</html>